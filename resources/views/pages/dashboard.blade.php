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
<div class="row">
    <div class="col s12">
        <ul class="collection z-depth-4">
            <li class="collection-item"><strong>Step 1: Confirm your event registrations</strong></li>
            <li class="collection-item">
                <p>
                    <ul>
                        <li>
                            <i class="fa {{ Auth::user()->isParticipating()?'fa-check':'fa-times' }}"></i> Participate in atleast one single or team event
                        </li>
                    </ul>
                </p>
                @if(Auth::user()->hasConfirmed())
                    {{ link_to_route('pages.ticket.download', 'Download Ticket', null, ['class' => 'btn waves-effect waves-light green']) }}
                @else
                    <a class="btn waves-effect waves-light green modal-trigger {{ Auth::user()->canConfirm()?'':'disabled' }}" href="#modal-confirm">Confirm and generate ticket</a>
                @endif
            </li>
            @if(Auth::user()->needApproval())
                <li class="collection-item"><strong>Step 2: Upload ticket for acknowledgement</strong></li>        
                @if(Auth::user()->hasConfirmed())
                    <li class="collection-item">
                        @include('partials.errors')
                        {!! Form::open(['url' => route('pages.ticket.upload'), 'files' => true, 'id' => 'form-upload-ticket']) !!}
                            {!! Form::file('ticket', ['class' => 'hide', 'id' => 'file-ticket']) !!}
                        {!! Form::close() !!}
                        <button class="btn waves-effect waves-light green" id="btn-upload-ticket">Upload Ticket</button>
                        @if(Auth::user()->hasUploadedTicket())                     
                            @if(!Auth::user()->isAcknowledged())
                                <p>Sit back and relax we will be verifying your ticket within a day, <strong>dont forget to check back!</strong></p>
                            @else
                                <p><i class="fa fa-check"></i> Hurray! your ticket has been verified</p>
                            @endif
                        @endif
                    </li>
                @endif    
                <li class="collection-item"><strong>Step 3: Payment Process</strong></li> 
                @if(Auth::user()->isAcknowledged())
                    <li class="collection-item">                    
                        @if(Auth::user()->hasTeams())
                            <i class="fa {{ Auth::user()->hasConfirmedTeams()?'fa-check':'fa-times' }}"></i> All your team members have confirmed their registration
                        @endif
                        @if(!Auth::user()->hasPaidForTeams() || !Auth::user()->hasPaid())
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
                                    @if(!Auth::user()->hasPaid())
                                        <tr>
                                            <td>{{ Auth::user()->full_name }}</td>
                                            <td>{{ Auth::user()->email }}</td>
                                            <td>
                                                @if(Auth::user()->hasConfirmed())
                                                    <span class="green-text">Confirmed</span>
                                                @else
                                                    <span class="red-text">Not Confirmed</span>
                                                @endif
                                            </td>
                                            <td><i class="fa fa-inr"></i> 200</td>
                                        </tr>
                                    @endif
                                    {{-- Get all teams   --}}
                                    @foreach(Auth::user()->teams as $team)
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
                                        <th><i class="fa fa-inr"></i> {{ Auth::user()->getTotalAmount() }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                            @if(Auth::user()->hasConfirmedTeams())
                                <form action="https://test.payu.in/_payment" method="post">
                                    <input type="hidden" name="key" value="{{ Auth::user()->getKey() }}">
                                    <input type="hidden" name="txnid" value="{{ Auth::user()->getTransactionId() }}">    
                                    <input type="hidden" name="amount" value="{{ Auth::user()->getTotalAmount() }}">   
                                    <input type="hidden" name="productinfo" value="{{ Auth::user()->getProductInfo() }}">
                                    <input type="hidden" name="firstname" value="{{ Auth::user()->full_name }}">
                                    <input type="hidden" name="email" value="{{ Auth::user()->email }}">
                                    <input type="hidden" name="phone" value="{{ Auth::user()->mobile }}">            <input type="hidden" name="surl" value="{{ route('pages.payment.success') }}">   <input type="hidden" name="furl" value="{{ route('pages.payment.failure') }}">
                                    <input type="hidden" name="hash" value="{{ Auth::user()->getHash() }}">
                                    <button type="submit" class="btn waves-effect waves-light green"><i class="fa fa-credit-card"></i> Pay by PayUmoney</button>
                                </form>
                            @else
                                <button type="submit" class="btn waves-effect waves-light green disabled"><i class="fa fa-credit-card"></i> Pay by PayUmoney</button>
                            @endif
                        @else
                            <p><i class="fa fa-check"></i> Hurray! your payment is confirmed, we are excited to see you at Legacy17</p>
                        @endif
                    </li>
                @endif
            @else
                <li class="collection-item">
                    <strong>Your verification and payment will be done by one of your team leaders</strong>
                </li>
            @endif
            @if(Auth::user()->hasPaid() && Auth::user()->payment->paidBy->id != Auth::user()->id)
                <li class="collection-item">
                    <div class="chip">
                        You have been paid by {{ Auth::user()->payment->paidBy->full_name }} [ {{ Auth::user()->payment->paidBy->email }} ]
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