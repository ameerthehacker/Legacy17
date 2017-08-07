@extends('layouts.default')

@section('content')

<div class="row">
    <div class="col s12">
        <ul class="stepper">
            <li class="step {{ (!Auth::user()->hasRequestedAccomodation() || Auth::user()->accomodation->status != 'ack')?'active':'' }}">
                <div class="step-title waves-effect waves-dark">
                    Request Accomodation
                </div>
                <div class="step-content">
                    <p>
                        <i class="fa {{ Auth::user()->hasConfirmed()?'fa-check':'fa-times' }}"></i> Confirm your registration
                    </p>
                    {{ link_to_route('pages.hospitality.request', 'Send Request', null, ['class' => "btn waves-effect waves-light green " . (Auth::user()->hasRequestedAccomodation()||!Auth::user()->hasConfirmed()?'disabled':'')]) }}
                </div>
            </li>
            <li class="step {{ (Auth::user()->hasRequestedAccomodation() && Auth::user()->accomodation->status == 'ack')?'active':'' }}">
                <div class="step-title waves-effect waves-dark">
                    Payment
                </div>
                <div class="step-content">
                    <button type="button" onclick="$('#frm-payment').submit()" class="btn waves-effect waves-light green {{ (Auth::user()->hasRequestedAccomodation() && Auth::user()->accomodation->status == 'ack')?'':'disabled' }}"><i class="fa fa-credit-card"></i> Pay by PayUmoney</button>
                </div>
            </li>
        </ul>
    </div>
</div>
@if(Auth::user()->hasRequestedAccomodation() && Auth::user()->accomodation->status == 'ack')
    <form action="https://test.payu.in/_payment" id='frm-payment' method="post">
        <input type="hidden" name="key" value="{{ App\Payment::getPaymentKey() }}">
        <input type="hidden" name="txnid" value="{{ Auth::user()->getTransactionId() }}">    
        <input type="hidden" name="amount" value="{{ Auth::user()->getAccomodationAmount() }}">   
        <input type="hidden" name="productinfo" value="{{ App\Payment::getProductInfo() }}">
        <input type="hidden" name="firstname" value="{{ Auth::user()->full_name }}">
        <input type="hidden" name="email" value="{{ Auth::user()->email }}">
        <input type="hidden" name="phone" value="{{ Auth::user()->mobile }}">            
        <input type="hidden" name="surl" value="{{ route('pages.payment.success', ['type' => 'accomodation']) }}">   
        <input type="hidden" name="furl" value="{{ route('pages.payment.failure') }}">
        <input type="hidden" name="hash" value="{{ Auth::user()->getHash(Auth::user()->getAccomodationAmount()) }}">
    </form>
@endif

@endsection