@extends('layouts.default')

@section('content')

<ul class="collection with-header z-depth-2">
    <li class="collection-header">
        <h5>Accomodation</h5>
    </li>
    <li class="collection-item"><strong>Step 1: Request For Accomadation</strong></li>
    <li class="collection-item">
        <p>
            <i class="fa {{ Auth::user()->hasConfirmed()?'fa-check':'fa-times' }}"></i> Confirm your registration
        </p>
        {{ link_to_route('pages.hospitality.request', 'Send Request', null, ['class' => "btn waves-effect waves-light green " . (Auth::user()->hasRequestedAccomodation()||!Auth::user()->hasConfirmed()?'disabled':'')]) }}
        @if(Auth::user()->hasRequestedAccomodation())
            @if(Auth::user()->hasAccomodationAcknowledged())
                @if(Auth::user()->accomodation->status == 'ack')
                    <p>Hurray! your request has been confirmed</p>
                @else
                    <p class="red-text">Sorry! your request has been rejected</p>
                    @if(Auth::user()->accomodation->message)
                        <p class="red-text">{{ Auth::user()->accomodation->message }}</p>
                    @endif
                @endif
            @else
                <p>Sit back and relax we will be confirming your accomodation within a day, <strong>dont forget to check back</strong></p>                
            @endif
        @endif
    </li>

    <li class="collection-item"><strong>Step 2: Payment Process</strong></li>  
    @if(Auth::user()->hasAccomodationAcknowledged())
        @if(Auth::user()->accomodation->status == 'ack')
            @unless(Auth::user()->accomodation->paid)
                <li class="collection-item">
                    <form action="https://test.payu.in/_payment" method="post">
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
                        <button type="submit" class="btn waves-effect waves-light green"><i class="fa fa-credit-card"></i> Pay by PayUmoney</button>
                    </form>
                </li>
            @else
                <li class="collection-item">
                    <p class="green-text">Hurray! your payment was successful</p>
                </li>
            @endif
        @endif
    @endif  
</ul>

@endsection