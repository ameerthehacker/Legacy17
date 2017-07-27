<?php

namespace App\Http\Controllers;

use Request;
use App\Http\Requests\TeamRequest;
use App\Http\Requests\UploadTicketRequest;
use App\Team;
use App\Registration;
use App\TeamMember;
use App\User;
use App\Event;
use App\Confirmation;
use Auth;
use Session;
use PDF;

class PagesController extends Controller
{
    function dashboard(){
        $events = Auth::user()->events;
        $teamEvents = Auth::user()->teamEvents();        
        return view('pages.dashboard')->with('events', $events)->with('teamEvents', $teamEvents);
    }
    function about(){
        return view('pages.about');
    }
    function events(){
        $registeredTeam = null;
        if(Auth::check()){
            $events = Event::all()->reject(function($event, $key){          
                return Auth::user()->hasRegisteredEvent($event->id);
            });
            $events = $events->all();
        }
        else{
            $events = Event::all();                 
        }
        return view('pages.events')->with('events', $events);
    }
    function register($id){
        $event = Event::find($id);
        $user = Auth::user();                                  
        $response = [];  
        $user->events()->save($event);
        $response['error'] = false;
        return response()->json($response);
    }
    function unregister($id){
        $event = Event::find($id);
        $user = Auth::user();
        $event->users()->detach($user->id);        
        return  redirect()->route('pages.dashboard');
    }
    function createTeam($event_id){
        $team = new Team();
        return view('teams.create')->with('team', $team);
    }
    function registerTeam(TeamRequest $request, $event_id){
        $event  = Event::find($event_id);              
        $inputs = Request::all();
        $team  = new Team($inputs);
        $team->user_id = Auth::user()->id;
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
        Session::flash('success', 'Team registered and event added to dashboard!');
        return redirect()->route('pages.events');
    }
    function unregisterTeam($event_id, $id){
        $team = Team::find($id);
        $event  = Event::find($event_id);                         
        $event->teams()->detach($id);
        $team->teamMembers()->delete();
        Team::destroy($team->id);
        return  redirect()->route('pages.dashboard');
    }
    function getCollegeMates(){
        $user  = Auth::user();
        $userEmails = User::where('college_id', $user->college_id)->where('id', '<>', $user->id)->get(['email']);
        return response()->json($userEmails);
    }
    function confirm(){
        $confirmation = new Confirmation();
        Auth::user()->confirmation()->save($confirmation);
        return redirect()->route('pages.dashboard');
    }
    function downloadTicket(){
        $pdf = PDF::loadView('pages.ticket');
        return $pdf->download('ticket.pdf');
    }
    function uploadTicketImage(UploadTicketRequest $request){
        // Check if the student can upload ticket for approval
        if(!Auth::user()->needApproval()){
            Session::flash('success', 'Sorry! Your verification and payment will be done by one of your team leaders');
            return redirect()->route('pages.dashboard');            
        }
        $extension = $request->file('ticket')->getClientOriginalExtension();
        $filename = 'ticket_' . Auth::user()->id . '.' . $extension;
        $confirmation = Auth::user()->confirmation;
        $request->file('ticket')->move('uploads/tickets', $filename);
        $confirmation->file_name = $filename;
        $confirmation->save();
        return redirect()->route('pages.dashboard');
    }
    function paymentSuccess(Request $request){
        $inputs = $request::all();
        if($this->verifyPaymentRequest($request)){
            if(strtolower($inputs['status']) == 'success' || strtolower($inputs['status']) == 'captured' ){
                Auth::user()->doPayment($inputs['txnid']);
                return view('pages.payment.success')->with('info', 'Your payment was successful!');
            }
            else{
                return view('pages.payment.failure')->with('info', 'Sorry! your transaction failed please try again!');
            }
        }
        else{
            return view('pages.payment.failure')->with('info', 'Invalid transaction!');
        }
    }
    function paymentFailure(Request $request){
        $errorInfo = "";     
        $inputs = $request::all();           
        if($this->verifyPaymentRequest($request)){
            if(isset($inputs['error']) && !empty($inputs['error'])){
                $errorInfo = $inputs['error'];
            }
            return view('pages.payment.failure')->with('info', 'Sorry! your transaction failed')->with('errorInfo', $errorInfo);            
        }
        else{
            return view('pages.payment.failure')->with('info', 'Invalid transaction!')->with('errorInfo', $errorInfo);
        }
    }
    function verifyPaymentRequest(Request $request){
        $inputs = $request::all();
        if(isset($inputs['key']) && !empty($inputs['key']) && isset($inputs['txnid']) && !empty($inputs['txnid']) && isset($inputs['amount']) && !empty($inputs['amount']) && isset($inputs['productinfo']) && !empty($inputs['productinfo']) && isset($inputs['email']) && !empty($inputs['email']) && isset($inputs['firstname']) && !empty($inputs['firstname']) && isset($inputs['hash']) && !empty($inputs['hash']) && isset($inputs['status']) && !empty($inputs['status'])){

            $key = $inputs['key'];
            $txnid = $inputs['txnid'];
            $amount = $inputs['amount'];
            $productInfo = $inputs['productinfo'];
            $email = $inputs['email'];
            $firstname = $inputs['firstname'];
            $salt = Auth::user()->getSalt();
            $status = $inputs['status'];
            $postback_hash = $inputs['hash'];
            $hashFormat = "$salt|$status|||||||||||$email|$firstname|$productInfo|$amount|$txnid|$key";
            $hash = strtolower(hash('sha512', $hashFormat));
            if($hash == $postback_hash){
                return true;
            }
            else{
                return false;                
            }
        }
        else{
            return false;                            
        }
    }
    function paymentReciept(){
        $pdf = PDF::loadView('pages.payment.reciept');
        return $pdf->download('payment-details.pdf');
    }
}
