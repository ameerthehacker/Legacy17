<?php

namespace App\Http\Controllers;

use Request;
use App\Confirmation;
use App\User;
use App\Accomodation;
use Illuminate\Support\Facades\Input;
use Illuminate\Pagination\LengthAwarePaginator;

class AdminPagesController extends Controller
{
    function root(){
        return view('pages.admin.root');
    }
    function requests(\Illuminate\Http\Request $request){
        $requests = Confirmation::all()->where('status', null)->where('file_name', '<>',  null)->filter(function($confirmation){
            return $confirmation->user->hasTeams();
        });
        $page = Input::get('page', 1);
        $perPage = 10;
        $offset = ($page * $perPage) - $perPage;
        $requests =  new LengthAwarePaginator(
            $requests->splice($offset, $perPage, true),
            count($requests), 
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );
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
        $requests = Accomodation::where('status', null)->paginate(10);
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
