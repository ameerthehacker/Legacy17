<?php

namespace App\Http\Controllers;

use Request;
use App\Confirmation;
use App\User;

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
        return redirect()->route('admin::requests');
    }
}
