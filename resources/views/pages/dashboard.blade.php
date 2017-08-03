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
                    <strong>Your registration for following events is rejected as maximum participants have already been confirmed</strong>
                </li>
                @foreach($user->rejections as $rejection)
                    <li class="collection-item">{{ $rejection->event->title }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
<div class="row">
    <div class="col s12">
        <ul class="collection z-depth-4">
            <li class="collection-item"><strong>Step 1: Confirm your event registrations</strong></li>
            <li class="collection-item">
                <p>
                    <ul>
                        <li>
                            <i class="fa {{ $user->isParticipating()?'fa-check':'fa-times' }}"></i> Participate in atleast one single or team event
                        </li>
                    </ul>
                </p>
                @if($user->hasConfirmed())
                    {{ link_to_route('pages.ticket.download', 'Download Ticket', null, ['class' => 'btn waves-effect waves-light green']) }}
                @else
                    <a class="btn waves-effect waves-light green modal-trigger {{ $user->canConfirm()?'':'disabled' }}" href="#modal-confirm">Confirm and generate ticket</a>
                @endif
            </li>
            @if($user->needApproval())
                <li class="collection-item"><strong>Step 2: Upload ticket for acknowledgement</strong></li>        
                @if($user->hasConfirmed())
                    <li class="collection-item">
                        @include('partials.errors')
                        {!! Form::open(['url' => route('pages.ticket.upload'), 'files' => true, 'id' => 'form-upload-ticket']) !!}
                            {!! Form::file('ticket', ['class' => 'hide', 'id' => 'file-ticket']) !!}
                        {!! Form::close() !!}
                        <button class="btn waves-effect waves-light green" id="btn-upload-ticket">Upload Ticket</button>
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
                    </li>
                @endif    
                <li class="collection-item"><strong>Step 3: Payment Process</strong></li> 
                @if($user->isAcknowledged())
                    @if($user->confirmation->status == 'ack')
                        <li class="collection-item">                    
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
                                        @if(!$user->hasPaid())
                                            <tr>
                                                <td>{{ $user->full_name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>
                                                    @if($user->hasConfirmed())
                                                        <span class="green-text">Confirmed</span>
                                                    @else
                                                        <span class="red-text">Not Confirmed</span>
                                                    @endif
                                                </td>
                                                <td><i class="fa fa-inr"></i> 200</td>
                                            </tr>
                                        @endif
                                        {{-- Get all teams   --}}
                                        @foreach($user->teams as $team)
                                            {{-- Get all team members  --}}
                                            @foreach($team->teamMembers as $teamMember)
                                                @if(!$teamMember->user->hasPaid())
                                                    <tr>
                                                        <td>{{ $teamMember->user->full_name }}</td>
                                                        <td>{{ $teamMember->user->email }}</td>
                                                        <td>
                                                            @if($teamMember->user->hasConfirmed())
                                                                <span class="green-text">Confirmed</span>
                                                            @else
                                                                <span class="red-text">Not Confirmed</span>
                                                            @endif
                                                        </td>
                                                        <td><i class="fa fa-inr"></i> 200</td>
                                                    </tr>
                                                @endif
                                            @endforeach
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
                                    <form action="https://test.payu.in/_payment" method="post">
                                        <input type="hidden" name="key" value="{{ App\Payment::getPaymentKey() }}">
                                        <input type="hidden" name="txnid" value="{{ $user->getTransactionId() }}">    
                                        <input type="hidden" name="amount" value="{{ $user->getTotalAmount() }}">   
                                        <input type="hidden" name="productinfo" value="{{ App\Payment::getProductInfo() }}">
                                        <input type="hidden" name="firstname" value="{{ $user->full_name }}">
                                        <input type="hidden" name="email" value="{{ $user->email }}">
                                        <input type="hidden" name="phone" value="{{ $user->mobile }}">            <input type="hidden" name="surl" value="{{ route('pages.payment.success') }}">   
                                        <input type="hidden" name="furl" value="{{ route('pages.payment.failure') }}">
                                        <input type="hidden" name="hash" value="{{ $user->getHash($user->getTotalAmount()) }}">
                                        <button type="submit" class="btn waves-effect waves-light green"><i class="fa fa-credit-card"></i> Pay by PayUmoney</button>
                                    </form>
                                @else
                                    <button type="submit" class="btn waves-effect waves-light green disabled"><i class="fa fa-credit-card"></i> Pay by PayUmoney</button>
                                @endif
                            @else
                                <p class="green-text"><i class="fa fa-check"></i> Hurray! your payment is confirmed, we are excited to see you at Legacy17</p>
                                <p>
                                    {{ link_to_route('pages.payment.reciept', 'Download Payment Reciept', null, ['class' => 'waves-effect waves-light btn green']) }}
                                </p>
                            @endif
                        </li>
                    @endif
                @endif
            @else
                <li class="collection-item">
                    <strong>Your verification and payment will be done by one of your team leaders</strong>
                </li>
            @endif
            @if($user->hasPaid() && $user->payment->paidBy->id != $user->id)
                <li class="collection-item">
                    <div class="chip">
                        You have been paid by {{ $user->payment->paidBy->full_name }} [ {{ $user->payment->paidBy->email }} ]
                    </div>
                </li>
            @endif
        </ul>
    </div>
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
<script>
    $('#btn-upload-ticket').on('click', function(){
        $('#file-ticket').trigger('click');
    });
    $('#file-ticket').on('change', function(){
        $('#form-upload-ticket').submit();
    });
</script>

@endsection