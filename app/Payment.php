<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    private static $paymentKey = "gtKFFx";
    private static $paymentSalt = "eCwWELxi";    
    private static $productInfo = "Legacy17 Events";
    private static $eventAmount = 200;
    private static $transactionFee = 0.04;
    private static $accomodationAmount = 100;    
    function user(){
        return $this->belonsTo('App\User');
    }
    function paidBy(){
        return $this->belongsTo('App\User', 'paid_by');
    }
    static function getPaymentKey(){
        return self::$paymentKey;
    }
    static function getPaymentSalt(){
        return self::$paymentSalt;
    }
    static function getProductInfo(){
        return self::$productInfo;
    }
    static function getTransactionFee(){
        return self::$transactionFee;
    }
    static function getEventAmount(){
        return self::$eventAmount;
    }
    static function getAccomodationAmount(){
        return self::$accomodationAmount;
    }
}
