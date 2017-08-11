<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use Request;
use Auth;
use Session;

class PasswordController extends Controller
{
    function showChangePassword(){
        $layout = Auth::user()->type=='student'?'layouts.default':'layouts.admin';        
        return view('auth.change_password')->with('layout', $layout);
    }
    function changePassword(ChangePasswordRequest $request){
        $inputs = $request->all();
        Auth::user()->password = bcrypt($inputs['new_password']);
        Auth::user()->save();
        Session::flash('info', 'Your password was changed!');
        return redirect()->route('auth.changePassword');
    }
}
