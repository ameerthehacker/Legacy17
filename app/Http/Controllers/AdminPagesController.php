<?php

namespace App\Http\Controllers;

use Request;
use App\Http\Requests\CommandRequest;
use App\Confirmation;
use App\User;
use App\Accomodation;
use App\Rejection;
use App\Team;
use Illuminate\Support\Facades\Input;
use App\Traits\Utilities;
use App\Payment;
use App\Config;

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
    function registrations(){
        $search = Input::get('search', '');
        $search = $search . '%';
        $user_ids = User::search($search)->pluck('id')->toArray();
        $registrations = User::whereIn('id', $user_ids)->where('activated', true)->paginate(10);
        return view('pages.admin.registrations')->with('registrations', $registrations);
    }
    function editRegistration($user_id){
        $user = User::findOrFail($user_id);
        return view('pages.admin.edit_registration', ['registration' => $user]);
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
    function allRequests(){
        $search = Input::get('search', '');
        $search = $search . '%';
        $user_ids = User::search($search)->pluck('id')->toArray();
        $requests = Confirmation::all()->where('file_name', '<>',  null)->whereIn('user_id', $user_ids)->filter(function($confirmation){
            return $confirmation->user->needApproval();
        });
        $page = Input::get('page', 1);
        $per_page = 10;
        $requests = $this->paginate($page, $per_page, $requests);
        return view('pages.admin.requests')->with('requests', $requests);
    }
    function requests(){
        $search = Input::get('search', '');
        $search = $search . '%';
        $user_ids = User::search($search)->pluck('id')->toArray();
        $requests = Confirmation::all()->where('status', null)->where('file_name', '<>',  null)->whereIn('user_id', $user_ids)->filter(function($confirmation){
            return $confirmation->user->needApproval();
        });
        $page = Input::get('page', 1);
        $per_page = 10;
        $requests = $this->paginate($page, $per_page, $requests);
        return view('pages.admin.requests')->with('requests', $requests);
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
