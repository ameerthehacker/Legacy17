@extends('layouts.default')

@section('content')

<div class="row">
    @foreach($events as $event)
        <div class="col m6 s12">
            @include('partials.event', ['event' => $event])
        </div>
    @endforeach
    @foreach($teamEvents as $event)
        <div class="col m6 s12">
            @include('partials.event', ['event' => $event])
        </div>
    @endforeach
</div>
@if($user->rejections()->count())
    <div class="row">
        <div class="col s12">
            <ul class="collection with-header z-depth-4">
                <li class="collection-header">
                    <strong>Your registrations for following events are rejected as maximum participants have already been confirmed</strong>
                </li>
                @foreach($user->rejections as $rejection)
                    <li class="collection-item">{{ $rejection->event->title }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
<div class="row">
    <ul class="stepper">
        <li class="step {{ $user->hasConfirmed()?'':'active' }}">
            <div class="step-title waves-effect waves-dark">Confirm Registration</div>
            <div class="step-content">
                <p>
                    <ul>
                        <li>
                            <p>
                                <i class="fa {{ $user->isParticipating()?'fa-check':'fa-times' }}"></i> Participate in atleast one single or team event
                            </p>
                            @if($user->hasOnlyTeamEvents())
                                <p>
                                    <i class="fa {{ $user->hasSureEvents()?'fa-check':'fa-times' }}"></i> Atleast one of your team leaders has confirmed your participation in their team
                                </p>
                            @endif
                        </li>
                    </ul>
                </p>
                @if($user->isParticipating())
                    <p class="red-text">After clicking on confirm and generate ticket you wont be able to further add or remove any other events</p>
                @endif
                <a class="btn waves-effect waves-light green modal-trigger {{ ($user->hasConfirmed()|| !$user->canConfirm())?'disabled':'' }}" href="#modal-confirm">Confirm and generate ticket</a>
            </div>
        </li>
        @if($user->needApproval())        
            <li class="step {{ ($user->hasConfirmed() && !$user->isConfirmed())?'active':'' }}">
                <div class="step-title waves-effect waves-dark">Attestation Of Participation</div>
                <div class="step-content">
                    <p>
                         <a class="btn waves-effect waves-light green {{ $user->hasConfirmed()?'':'disabled' }}" href="{{ route('pages.ticket.download') }}">Download Ticket</a>
                    </p>
                    <p>
                        @include('partials.errors')                        
                        {!! Form::open(['url' => route('pages.ticket.upload'), 'files' => true, 'id' => 'form-upload-ticket', 'style' => 'display:inline']) !!}
                            {!! Form::file('ticket', ['class' => 'hide', 'id' => 'file-ticket']) !!}
                        {!! Form::close() !!}
                        <button type="button" class="btn waves-effect waves-light green {{ $user->hasConfirmed()?'':'disabled' }}" id="btn-upload-ticket">Upload Ticket</button>
                    </p>
                    @if($user->hasUploadedTicket())                     
                        @unless($user->isAcknowledged())
                            <p>Sit back and relax we will be verifying your ticket within a day, <strong>dont forget to check back!</strong></p>
                        @else
                            @if($user->isConfirmed())
                                <p><i class="fa fa-check"></i> Hurray! your ticket has been verified</p>
                            @else
                                <p class="red-text">Sorry your request has been rejected!</p>
                                @if($user->confirmation->message)
                                    <p class="red-text">{{ $user->confirmation->message }}</p>
                                @endif
                            @endif
                        @endif
                    @endif
                </div>
            </li>
        @endif        
        <li class="step {{ $user->isConfirmed()?'active':'' }}">
            <div class="step-title waves-effect waves-dark">Payment</div>
            <div class="step-content">
                @if($user->needApproval())
                    @if($user->isAcknowledged())
                        @if($user->confirmation->status == 'ack')       
                            @if($user->hasTeams())
                                <i class="fa {{ $user->hasConfirmedTeams()?'fa-check':'fa-times' }}"></i> All your team members have confirmed their registration
                            @endif
                            @if(!$user->hasPaidForTeams() || !$user->hasPaid())
                                <p><strong>You will be paying for the following!</strong></p>
                                <table class="bordered highlight responsive-table">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Registration Status</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- Get all users to pay   --}}
                                        @foreach($user->getUsersToPay() as $userToPay)
                                            <tr>
                                                <td>{{ $userToPay->full_name }}</td>
                                                <td>{{ $userToPay->email }}</td>
                                                <td>
                                                    @if($userToPay->hasConfirmed())
                                                        <span class="green-text">Confirmed</span>
                                                    @else
                                                        <span class="red-text">Not Confirmed</span>
                                                    @endif
                                                </td>
                                                <td><i class="fa fa-inr"></i> 200</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="3">Total Amount (Includes 4% transaction fee)</th>
                                            <th><i class="fa fa-inr"></i> {{ $user->getTotalAmount() }}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                                @if($user->hasConfirmedTeams())
                                    <button type="button" onclick="$('#frm-payment').submit()" class="btn waves-effect waves-light green"><i class="fa fa-credit-card"></i> Pay by PayUmoney</button>
                                @else
                                    <button type="submit" class="btn waves-effect waves-light green disabled"><i class="fa fa-credit-card"></i> Pay by PayUmoney</button>
                                @endif
                            @else
                                <p class="green-text"><i class="fa fa-check"></i> Hurray! your payment is confirmed, we are excited to see you at Legacy17</p>
                                <p>
                                    {{ link_to_route('pages.payment.reciept', 'Download Payment Reciept', null, ['class' => 'waves-effect waves-light btn green']) }}
                                </p>
                            @endif
                        @else
                            <button type="submit" class="btn waves-effect waves-light green disabled"><i class="fa fa-credit-card"></i> Pay by PayUmoney</button>   
                        @endif
                    @else
                        <button type="submit" class="btn waves-effect waves-light green disabled"><i class="fa fa-credit-card"></i> Pay by PayUmoney</button>
                    @endif
                @else
                    <strong>Your verification and payment will be done by one of your team leaders</strong>
                @endif
                @if($user->hasPaid() && $user->payment->paidBy->id != $user->id)
                    <div class="chip">
                        You have been paid by {{ $user->payment->paidBy->full_name }} [ {{ $user->payment->paidBy->email }} ]
                    </div>
                @endif
            </div>
        </li>
    </ul>
</div>
<div class="modal" id="modal-confirm">
    <div class="modal-content">
        <h4>Are you sure?</h4>
        <p>
            After confimration you wont be able to add or remove events from your wishlist!
        </p>
    </div>
    <div class="modal-footer">
        <a class="btn-flat waves-effect waves-red modal-action modal-close">No not now!</a>
        {{ link_to_route('pages.confirm', 'Got it!', null, ['class' => 'btn-flat waves-effect waves-green modal-action modal-close']) }}        
    </div>
</div>
@if($user->hasConfirmedTeams())
    <form action="{{ env('PAYU_URL') }}" id="frm-payment" method="post">
        <input type="hidden" name="key" value="{{ App\Payment::getPaymentKey() }}">
        <input type="hidden" name="txnid" value="{{ $user->getTransactionId() }}">    
        <input type="hidden" name="amount" value="{{ $user->getTotalAmount() }}">
        <input type="hidden" name="productinfo" value="{{ App\Payment::getProductInfo() }}">
        <input type="hidden" name="firstname" value="{{ $user->full_name }}">
        <input type="hidden" name="email" value="{{ $user->email }}">
        <input type="hidden" name="phone" value="{{ $user->mobile }}">            <input type="hidden" name="surl" value="{{ route('pages.payment.success') }}">   
        <input type="hidden" name="furl" value="{{ route('pages.payment.failure') }}">
        <input type="hidden" name="hash" value="{{ $user->getHash($user->getTotalAmount()) }}">
    </form>
@endif
<script>
    $('#btn-upload-ticket').on('click', function(){
        $('#file-ticket').trigger('click');
    });
    $('#file-ticket').on('change', function(){
        $('#form-upload-ticket').submit();
    });
</script>

@endsection