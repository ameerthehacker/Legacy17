<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Request;
use Illuminate\Support\Facades\Input;
use Mail;
use App\Mail\RegistrationConfirmation;
use Session;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/auth/register';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $messages = ['college_id.required' => 'The college name field is required'];
        return Validator::make($data, [
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed',
            'gender' => 'required',
            'college_id' => 'required',
            'mobile_number' => 'required|digits:10'
        ], $messages);
    }
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $activation_code = substr(hash('SHA512', rand(100000, 1000000)), 0, 15);
        $user = User::create([
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'gender' => $data['gender'],
            'college_id' => $data['college_id'],
            'mobile' => $data['mobile_number'],
            'type' => 'student',
            'activated' => false,
            'activation_code' => $activation_code
        ]);
        Mail::to($user->email)->send(new RegistrationConfirmation($user));
		Session::flash('info', 'An Activation mail has been sent to your email');
    }
    public function activate(){
        $email = Input::get('email', false);
        $activation_code = Input::get('activation_code', false);
        if($email && $activation_code){
            $user = User::where('email', $email)->first();
            if($user){
                if($user->activation_code == $activation_code){
                    $user->activated = true;
                    $user->save();
                    return view('auth.activate')->with('info', "Your account has been confirmed");   
                }
            }
        }
        return redirect()->route('pages.root');
    }
}
