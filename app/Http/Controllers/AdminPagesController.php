<?php

namespace App\Http\Controllers;

use Request;
use App\Confirmation;
use App\User;
use App\Accomodation;

class AdminPagesController extends Controller
{
    function root(){
        return view('pages.admin.root');
    }
    function requests(){
        $requests = Confirmation::all()->where('status', null)->where('file_name', '<>',  null)->reject(function($confirmation){
            return !$confirmation->user->hasTeams();
        });
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
    function accomodationRequests(){
        $requests = Accomodation::all()->where('status', null);
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
}
