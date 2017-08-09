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
                    <p>You need to pay 100 rupees per head per day</p>   
                    <p>
                        <p class="red-text"> 
                            @if(Auth::user()->hasRequestedAccomodation() && Auth::user()->accomodation->status == 'nack')
                                Sorry! Your accomodation request is rejected
                                @if(Auth::user()->accomodation->message)
                                    , {{ Auth::user()->accomodation->message }}
                                @endif
                            @endif
                        </p>
                    </p>                 
                    <p>
                        <i class="fa {{ Auth::user()->hasConfirmed()?'fa-check':'fa-times' }}"></i> Confirm your registration
                    </p>
                    {!! Form::open(['url' => route('pages.hospitality.request'), 'method' => 'GET']) !!}
                        <div class="row">     
                            <div class="col m5 s12">
                                @if(!Auth::user()->hasRequestedAccomodation())
                                    {!! Form::label('days', 'Number of days') !!}                             
                                    {!! Form::select('days', ['1' => 1, '2' => 2]) !!}
                                @else
                                    <p>
                                        You have requested accomodation for 
                                        <strong>
                                            {{ Auth::user()->accomodation->days }} {{ str_plural('day', Auth::user()->accomodation->days) }}
                                        </strong>
                                    </p>
                                @endif
                                {!! Form::submit('Send Request', ['class' => "btn waves-effect waves-light green " . (Auth::user()->hasRequestedAccomodation()||!Auth::user()->hasConfirmed()?'disabled':'')]) !!}
                            </div>                     
                        </div>
                    {!! Form::close() !!}
                </div>
            </li>
            <li class="step {{ (Auth::user()->hasRequestedAccomodation() && Auth::user()->accomodation->status == 'ack')?'active':'' }}">
                <div class="step-title waves-effect waves-dark">
                    Payment
                </div>
                <div class="step-content">
                    @if(Auth::user()->hasRequestedAccomodation())
                         <p><strong>Total Amount (Includes 4% transaction Fee): </strong><i class="fa fa-inr"></i> {{ Auth::user()->getAccomodationAmount() }}</p>
                    @endif
                    <p>
                        <p>
                            <i class="fa {{ Auth::user()->hasRequestedAccomodation() && Auth::user()->accomodation->status == 'ack'?'fa-check':'fa-times' }}"></i> You request acknowledgement
                        </p>
                         <i class="fa {{ Auth::user()->hasPaid()?'fa-check':'fa-times' }}"></i> Pay for your events to continue with payment for accomodation
                    </p>
                    @if(Auth::user()->hasRequestedAccomodation() && Auth::user()->accomodation->paid)
                        <p class="green-text">
                             <i class="fa {{ Auth::user()->accomodation->paid?'fa-check':'fa-times' }}"></i> Hurray! your payment for accomodation is confirmed
                        </p>
                    @endif
                    <button type="button" onclick="$('#frm-payment').submit()" class="btn waves-effect waves-light green {{ (Auth::user()->hasRequestedAccomodation() && Auth::user()->accomodation->status == 'ack' && Auth::user()->hasPaid() && !Auth::user()->accomodation->paid)?'':'disabled' }}"><i class="fa fa-credit-card"></i> Pay by PayUmoney</button>
                </div>
            </li>
        </ul>
    </div>
</div>
@if(Auth::user()->hasRequestedAccomodation() && Auth::user()->accomodation->status == 'ack' && Auth::user()->hasPaid() && !Auth::user()->accomodation->paid)
    <form action="{{ env('PAYU_URL') }}" id='frm-payment' method="post">
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