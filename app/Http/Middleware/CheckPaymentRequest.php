<?php

namespace App\Http\Middleware;

use Closure;
use App\Payment;

class CheckPaymentRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $inputs = $request->all();
        if(isset($inputs['key']) && !empty($inputs['key']) && isset($inputs['txnid']) && !empty($inputs['txnid']) && isset($inputs['amount']) && !empty($inputs['amount']) && isset($inputs['productinfo']) && !empty($inputs['productinfo']) && isset($inputs['email']) && !empty($inputs['email']) && isset($inputs['firstname']) && !empty($inputs['firstname']) && isset($inputs['hash']) && !empty($inputs['hash']) && isset($inputs['status']) && !empty($inputs['status'])){

            $key = $inputs['key'];
            $txnid = $inputs['txnid'];
            $amount = $inputs['amount'];
            $productInfo = $inputs['productinfo'];
            $email = $inputs['email'];
            $firstname = $inputs['firstname'];
            $salt = Payment::getPaymentSalt();
            $status = $inputs['status'];
            $postback_hash = $inputs['hash'];
            $hashFormat = "$salt|$status|||||||||||$email|$firstname|$productInfo|$amount|$txnid|$key";
            $hash = strtolower(hash('sha512', $hashFormat));
            if($hash == $postback_hash){
                return $next($request);                
            }
            else{
                return view('pages.payment.failure')->with('info', 'Invalid transaction!');                
            }
        }
        else{
            return view('pages.payment.failure')->with('info', 'Invalid transaction!');
        }
    }
}
