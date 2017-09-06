<?php

namespace App\Http\Controllers;

use Auth;
use Session;
use Request;
use App\Http\Requests\RegistrationRequest;
use App\Http\Requests\TeamRequest;
use App\Http\Requests\CommandRequest;
use App\Confirmation;
use App\User;
use App\Accomodation;
use App\Rejection;
use App\Team;
use App\TeamMember;
use App\Event;
use Illuminate\Support\Facades\Input;
use App\Traits\Utilities;
use App\Payment;
use App\Config;
use App\College;
use Excel;

class AdminPagesController extends Controller
{
    use Utilities;

    function root(){
        $registered_count = User::where('type', 'student')->count();
        $confirmed_registrations = 0;
        $users = User::all()->where('type', 'student')->where('activated', true); 
        foreach($users as $user){
            if($user->isConfirmed()){
                $confirmed_registrations++;
            }
        }
        $payment_count = Payment::count();
        $accomodation_count = Accomodation::count();
        $confirmed_accomodation = Accomodation::where('status', 'ack')->count();
        $accomodation_payment = Accomodation::where('paid', true)->count();
        return view('pages.admin.root')->with('registered_count', $registered_count)->with('confirmed_registrations', $confirmed_registrations)->with('payment_count', $payment_count)->with('accomodation_count', $accomodation_count)->with('confirmed_accomodation', $confirmed_accomodation)->with('accomodation_payment', $accomodation_payment);
    }
    function register($user_id){
        $event_id = Input::get('event_id', false);
        if($event_id){
            $event = Event::find($event_id);
            $user = User::find($user_id);
            $user->events()->save($event);
        }
        return redirect()->route('admin::registrations.edit', ['user_id' => $user->id]);
    }
    function registerAccomodation($user_id){
        $user = User::findOrFail($user_id);
        $accomodation = new Accomodation();
        $accomodation->status = 'ack';
        $accomodation->paid = true;
        $user->accomodation()->save($accomodation);
        return redirect()->route('admin::registrations.edit', ['user_id' => $user->id]);
    }
    function unregister($user_id, $event_id){
        $event = Event::find($event_id);
        $user = User::find($user_id);
        $event->users()->detach($user->id);        
        return  redirect()->route('admin::registrations.edit', ['user_id' => $user_id]);
    }
    function registerTeam($user_id, \Illuminate\Http\Request $request){
        $inputs = Request::all();
        $event = Event::findOrFail($inputs['event_id']);        
        $this->validate($request, [
            'event_id' => 'required',
            'name' => 'required',
            'team_members' => 'required|teamMembersExist|teamMembersCount:' . $event->id
        ]);
        $user = User::findOrFail($user_id);
        $team  = new Team();
        $team->name = $inputs['name'];
        $team->user_id = $user->id;
        $team->save();
        $team_members_emails = explode(',', $inputs['team_members']);
        $team_members_users = User::all()->whereIn('email', $team_members_emails);
        foreach($team_members_users as $team_member_user){
            $team_member = new TeamMember();
            $team_member->team_id = $team->id;
            $team_member->user_id = $team_member_user->id;
            $team->teamMembers()->save($team_member);
        }
        $team->events()->save($event);
        return redirect()->route('admin::registrations.edit', ['user_id' => $user->id]);
    }
    function unregisterTeam($user_id, $event_id){
        $user = User::find($user_id);
        $team = $user->teamLeaderFor($event_id);
        $event  = Event::find($event_id);                         
        $event->teams()->detach($team->id);
        $team->teamMembers()->delete();
        Team::destroy($team->id);
        return  redirect()->route('admin::registrations.edit', ['user_id' => $user->id]);
    }
    function editTeam($id){
        $team = Team::find($id);
        return view('pages.admin.edit_team')->with('team', $team);
    }
    function updateTeam(\Illuminate\Http\Request $request, $id){
        $team  = Team::findOrFail($id);        
        $this->validate($request, [
            'name' => 'required',
            'team_members' => 'required|teamMembersExist|teamMembersCount:' . $team->events->first()->id
        ]);
        $inputs = Request::all();
        $team->teamMembers()->delete();
        $team_members_emails = explode(',', $inputs['team_members']);
        $team_members_users = User::all()->whereIn('email', $team_members_emails);
        foreach($team_members_users as $team_member_user){
            $team_member = new TeamMember();
            $team_member->team_id = $team->id;
            $team_member->user_id = $team_member_user->id;
            $team->teamMembers()->save($team_member);
        } 
        return redirect()->route('admin::registrations.edit', ['user_id' => $team->user->id]); 
    }
    function getAdmins(){
        $adminEmails = User::where('type', 'admin')->get(['email']);
        return response()->json($adminEmails);
    }
    function openRegistrations(){
        Config::setConfig('registration_open', true);
        return redirect()->route('admin::root');
    }
    function closeRegistrations(){
        Config::setConfig('registration_open', false);
        return redirect()->route('admin::root');
    }
    function enableOfflineRegistration(){
        Config::setConfig('offline_link', true);
        return redirect()->route('admin::root');
    }
    function disableOfflineRegistration(){
        Config::setConfig('offline_link', false);
        return redirect()->route('admin::root');
    }
    function new_registration(){
        return view('pages.admin.new_registration');
    }
    function create_registration(RegistrationRequest $request){
        $inputs = Request::all();
        $user = User::create([
            'full_name' => $inputs['full_name'],
            'email' => $inputs['email'],
            'password' => bcrypt('test'),
            'gender' => $inputs['gender'],
            'college_id' => $inputs['college_id'],
            'mobile' => $inputs['mobile'],
            'type' => 'student',
            'activated' => true,
            'activation_code' => 0
        ]);
        Session::flash('success', 'The user was registered');
        return redirect()->route('admin::registrations.create');
    }
    function registrations(){
        $search = Input::get('search', '');
        $search = $search . '%';
        $user_ids = User::search($search)->pluck('id')->toArray();
        $registrations = User::whereIn('id', $user_ids)->where('activated', true);
        $registrations_count = $registrations->count();
        $registrations = $registrations->paginate(10);
        return view('pages.admin.registrations')->with('registrations', $registrations)->with('registrations_count', $registrations_count);
    }
    function editRegistration($user_id){
        $user = User::findOrFail($user_id);
        $team = new Team();
        $soloEvents = Event::where('max_members', 1)->pluck('title', 'id')->toArray();
        $teamEvents = Event::where('max_members', '>', 1)->pluck('title', 'id')->toArray();        
        return view('pages.admin.edit_registration', ['registration' => $user])->with('soloEvents', $soloEvents)->with('teamEvents', $teamEvents)->with('team', $team);
    }
    function updateRegistration($user_id, RegistrationRequest $request){
        $user = User::findOrFail($user_id);
        $inputs = Request::all();
        $user->full_name = $inputs['full_name'];
        $user->email = $inputs['email'];
        $user->gender = $inputs['gender'];
        $user->college_id = $inputs['college_id'];
        $user->mobile = $inputs['mobile'];
        $user->update();
        Session::flash('success', 'The user was updated!');
        return redirect()->route('admin::registrations.edit', $user_id);
    }
    function eventRegistrations($event_id){
        $event = Event::findOrFail($event_id);
        $search = Input::get('search', '');
        $search = $search . '%';
        $user_ids = User::search($search)->pluck('id')->toArray();
        if($event->isGroupEvent()){
            $registered_user_ids = $event->teams()->whereIn('user_id', $user_ids)->pluck('user_id')->toArray();
        }
        else{
            $registered_user_ids = $event->users()->whereIn('id', $user_ids)->pluck('id')->toArray();
        }
        $registrations = User::all()->whereIn('id', $registered_user_ids);
        $registrations_count = $registrations->count();        
        // Paginate registrations
        $page = Input::get('page', 1);
        $per_page = 10;
        $registrations = $this->paginate($page, $per_page, $registrations);
        return view('pages.admin.registrations')->with('registrations', $registrations)->with('registrations_count', $registrations_count);
    }
    function confirmPayment($user_id){
        $user = User::findOrFail($user_id);
        $type = Input::get('type', '');
        if($type == 'accomodation'){
            if($user->accomodation && $user->accomodation->status == 'ack'){
                if($user->accomodation->paid){
                    Session('success', 'User has already paid for accomodation');                                 
                }
                else{
                    $user->accomodation->paid = true;
                    $user->accomodation->save();                    
                }
            }
            else{
                Session('success', 'User has no accomodation');                                         
            }
        }
        else{
            if($user->hasPaid()){
                Session('success', 'User has already done his payment');                      
            }
            else{
                $user->doPayment(null);
                $this->rejectOtherRegistrations($user->id);
            }
        }
        
        return redirect()->route('admin::registrations.edit', ['user_id' => $user_id]);
    }
    function unconfirmPayment($user_id){
        $user = User::findOrFail($user_id);
        $type = Input::get('type', '');        
        if($type == 'accomodation'){
            if($user->accomodation && $user->accomodation->status == 'ack'){
                if($user->accomodation->paid){
                    $user->accomodation->paid = false;                    
                    $user->accomodation->save();
                }
                else{
                    $user->accomodation->paid = true;
                    Session('success', 'User has not paid for accomodation');                                    
                }
            }
            else{
                Session('success', 'User has no accomodation');                                         
            }
        }
        else{
            if($user->hasPaid()){
                $user->payments()->delete();
            }
            else{
                Session('success', 'User has not done his payment');                                              
            }
        }
       
        return redirect()->route('admin::registrations.edit', ['user_id' => $user_id]);
    }
    function confirmRegistration($user_id){
        $user = User::findOrFail($user_id);
        if($user->hasConfirmed()){
            Session('success', 'User has already confirmed the registration');                      
        }
        else{
            $confirmation = new Confirmation();
            $user->confirmation()->save($confirmation);
        }
        return redirect()->route('admin::registrations.edit', ['user_id' => $user_id]);
    }
    function unconfirmRegistration($user_id){
        $user = User::findOrFail($user_id);
        if($user->hasConfirmed()){
            $user->confirmation()->delete();
        }
        else{
            Session('success', 'User has not confirmed the registration');          
        }
        return redirect()->route('admin::registrations.edit', ['user_id' => $user_id]);
    }
    function reports(){
        if(!Auth::user()->hasRole('root') && !Auth::user()->hasRole('hospitality') && !Auth::user()->organizings->count() == 0){
            return redirect()->route('admin::root');
        }
        if(Auth::user()->hasRole('root')){
            $colleges = ['all' => 'All'];
            $events = ['all' => 'All'];        
            $events += Event::pluck('title', 'id')->toArray();                    
        }else{
            $colleges = [];
            $events = [];
            $events = Auth::user()->organizings->pluck('title', 'id')->toArray();        
        }
        $colleges += College::pluck('name', 'id')->toArray();
        return view('pages.admin.reports')->with('colleges', $colleges)->with('events', $events);
    }
    function reportRegistrations(Request $request){
        $inputs = Request::all();
        $event_id = $inputs['event_id'];
        $college_id = $inputs['college_id'];
        $gender = $inputs['gender'];
        $payment = $inputs['payment'];
        // Get the registered users in the given event
        if($event_id == "all"){
            $users = User::all()->where('type', 'student');
        }
        else{
            if(!Auth::user()->isOrganizing($event_id) && !Auth::user()->hasRole('root')){
                Session::flash('success', 'You dont have rights to view this report!');
                return redirect()->route('admin::root');
            }
            $event = Event::findOrFail($event_id);
            if($event->isGroupEvent()){
                $user_ids = [];
                foreach($event->teams as $team){
                    array_push($user_ids, $team->user_id);
                    foreach($team->teamMembers as $teamMember){
                        array_push($user_ids, $teamMember->user->id);
                    }
                }
                $users = User::all()->whereIn('id', $user_ids);
            }
            else{
                $users = $event->users;
            }
        }
        if($college_id != "all"){
            $users = $users->where('college_id', $college_id);
        }
        if($gender != "all"){
            $users = $users->where('gender', $gender);
        }
        if($payment != "all"){
            $users = $users->filter(function($user) use ($payment){
                return $user->hasPaid() == $payment;
            });
        }
        if($inputs['report_type'] == 'View Report'){
            $users_count = $users->count();
            $page = Input::get('page', 1);
            $per_page = 10;
            $users = $this->paginate($page, $per_page, $users);
            return view('pages.admin.report_registrations')->with('users', $users)->with('users_count', $users_count);            
        }
        else if($inputs['report_type'] == 'Download Excel'){
            $usersArray = [];
            foreach($users as $user){
                $userArray['LGID'] = $user->id;                
                $userArray['FullName'] = $user->full_name;
                $userArray['Email'] = $user->email;
                $userArray['College'] = $user->college->name;                
                $userArray['Gender'] = $user->gender;                
                $userArray['Mobile'] = $user->mobile;
                if(!$user->hasConfirmed()){
                    $userArray['Status'] = 'Not yet confirmed';
                }
                else{
                    if($user->isAcknowledged()){
                        $userArray['Status'] = $user->confirmation->status == 'ack'? 'Accepted':'Rejected';  
                    }
                    else{
                        $userArray['Status'] = 'Yet to be acknowledged';                          
                    }
                }
                $userArray['Payment'] = $user->hasPaid()? 'Paid': 'Not Paid';
                array_push($usersArray, $userArray);
            }
            Excel::create('report', function($excel) use($usersArray){
                $excel->sheet('Sheet1', function($sheet) use($usersArray){
                    $sheet->fromArray($usersArray);
                });
            })->download('xlsx');
        }
    }
    function reportAccomodations(Request $request){
        if(!Auth::user()->hasRole('hospitality')){
            Session::flash('success', 'You dont have rights to view this report!');
            return redirect()->route('admin::root');
        }
        $inputs = Request::all();
        $college_id = $inputs['college_id'];
        $gender = $inputs['gender'];
        $payment = $inputs['payment'];
        $status = $inputs['status'];
        // Get the user who requested for accomodations
        $user_ids = Accomodation::pluck('user_id')->toArray();
        $users = User::all()->whereIn('id', $user_ids);
        if($college_id != "all"){
            $users = $users->where('college_id', $college_id);
        }
        if($gender != "all"){
            $users = $users->where('gender', $gender);
        }
        if($status != "all"){
            $users = $users->filter(function($user) use ($status){
                return $user->accomodation->status == $status;
            });
        }
        if($payment != "all"){
            $users = $users->filter(function($user) use($payment){
                return $user->accomodation->paid == $payment;
            });
        }
        if($inputs['report_type'] == 'View Report'){
            $users_count = $users->count();
            $page = Input::get('page', 1);
            $per_page = 10;
            $users = $this->paginate($page, $per_page, $users);
            return view('pages.admin.report_accomodations')->with('users', $users)->with('users_count', $users_count);        
        }
        else if($inputs['report_type'] == 'Download Excel'){
            $usersArray = [];
            foreach($users as $user){
                $userArray['LGID'] = $user->id;                
                $userArray['FullName'] = $user->full_name;
                $userArray['Email'] = $user->email;
                $userArray['College'] = $user->college->name;                
                $userArray['Gender'] = $user->gender;                
                $userArray['Mobile'] = $user->mobile;
                $userArray['Days'] = $user->accomodation->days;
                if($user->accomodation->status){
                    $userArray['Status'] = $user->accomodation->status == 'ack'? 'Accepted':'Rejected';  
                }
                else{
                    $userArray['Status'] = 'Yet to be acknowledged';                          
                }
                $userArray['Payment'] = $user->accomodation->paid? 'Paid': 'Not Paid';
                array_push($usersArray, $userArray);
            }
            Excel::create('report', function($excel) use($usersArray){
                $excel->sheet('Sheet1', function($sheet) use($usersArray){
                    $sheet->fromArray($usersArray);
                });
            })->download('xlsx');
        }
    }
    function allRequests(){
        $search = Input::get('search', '');
        $search = $search . '%';
        $user_ids = User::search($search)->pluck('id')->toArray();
        $requests = Confirmation::all()->where('file_name', '<>',  null)->whereIn('user_id', $user_ids)->filter(function($confirmation){
            return $confirmation->user->needApproval();
        });
        $requests_count = $requests->count();
        $page = Input::get('page', 1);
        $per_page = 10;
        $requests = $this->paginate($page, $per_page, $requests);
        return view('pages.admin.requests')->with('requests', $requests)->with('requests_count', $requests_count);
    }
    function requests(){
        $search = Input::get('search', '');
        $search = $search . '%';
        $user_ids = User::search($search)->pluck('id')->toArray();
        $requests = Confirmation::all()->where('status', null)->where('file_name', '<>',  null)->whereIn('user_id', $user_ids)->filter(function($confirmation){
            return $confirmation->user->needApproval();
        });
        $requests_count = $requests->count();        
        $page = Input::get('page', 1);
        $per_page = 10;
        $requests = $this->paginate($page, $per_page, $requests);
        return view('pages.admin.requests')->with('requests', $requests)->with('requests_count', $requests_count);
    }
    function eventRequests($event_id){
        $event = Event::findOrFail($event_id);
        $search = Input::get('search', '');
        $search = $search . '%';
        $user_ids = User::search($search)->pluck('id')->toArray();
        if($event->isGroupEvent()){
            $registered_user_ids = $event->teams()->whereIn('user_id', $user_ids)->pluck('user_id')->toArray();
        }
        else{
            $registered_user_ids = $event->users()->whereIn('id', $user_ids)->pluck('id')->toArray();
        }
        $requests = Confirmation::all()->where('status', null)->where('file_name', '<>',  null)->whereIn('user_id', $registered_user_ids)->filter(function($confirmation){
            return $confirmation->user->needApproval();
        });
        $requests_count = $requests->count();                
        $page = Input::get('page', 1);
        $per_page = 10;
        $requests = $this->paginate($page, $per_page, $requests);
        return view('pages.admin.requests')->with('requests', $requests)->with('requests_count', $requests_count);
    }
    function replyRequest(Request $request){
        $inputs = Request::all();
        $user_id = $inputs['user_id'];
        $user = User::find($user_id);
        if($inputs['submit'] == 'Accept'){
            $user->confirmation->status = 'ack';
        }
        else if($inputs['submit'] == 'Reject'){
            $user->confirmation->status = 'nack';
            $user->confirmation->message = $inputs['message'];
        }
        $user->confirmation->save();
        return redirect()->back();
    }
    function allAccomodationRequests(){
        $search = Input::get('search', '');
        $search = $search . '%';
        $user_ids = User::search($search)->pluck('id')->toArray();
        $requests = Accomodation::whereIn('user_id', $user_ids)->paginate(10);
        return view('pages.admin.accomodations')->with('requests', $requests);
    }
    function accomodationRequests(){
        $search = Input::get('search', '');
        $search = $search . '%';
        $user_ids = User::search($search)->pluck('id')->toArray();
        $requests = Accomodation::where('status', null)->whereIn('user_id', $user_ids)->paginate(10);
        return view('pages.admin.accomodations')->with('requests', $requests);
    }
    function replyAccomodationRequest(Request $request){
        $inputs = Request::all();
        $user_id = $inputs['user_id'];
        $user = User::find($user_id);
        if($inputs['submit'] == 'Accept'){
            $user->accomodation->status = 'ack';
        }
        else if($inputs['submit'] == 'Reject'){
            $user->accomodation->status = 'nack';
            $user->accomodation->message = $inputs['message'];
        }
        $user->accomodation->save();
        return redirect()->back();
    }
    function terminal(){
        return view('pages.admin.terminal');
    }
    function executeCommand(CommandRequest $request){
        $inputs = $request->all();
        $output = [];
        exec($inputs['command'], $output);
        return view('pages.admin.terminal')->with('output', implode("<br>", $output));
    }
    
}
