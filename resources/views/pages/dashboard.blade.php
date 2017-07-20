@extends('layouts.default')

@section('content')

<div class="row">
    <div class="col s12">
        <ul class="tabs">
            <li class="col s6 tab">
                <a href="#tab-solo-events">Solo Events</a>
            </li>
            <li class="col s6 tab">
                <a href="#tab-team-events">Team Events</a>
            </li>
        </ul>
    </div>
    <div class="col s12">
        <div id="tab-solo-events" class="row">
            @foreach($events as $event)
                <div class="col m6 s12">
                    @include('partials.event', ['event' => $event])
                </div>
            @endforeach
        </div>
        <div id="tab-team-events" class="row">
            @foreach($teamEvents as $event)
                <div class="col m6 s12">
                    @include('partials.event', ['event' => $event])
                </div>
            @endforeach
        </div>
    </div>
</div>
<div class="row">
    <div class="col s12">
        <ul class="collection z-depth-4">
            <li class="collection-item"><strong>Step 1: Confirm your event registrations</strong></li>
            <li class="collection-item">
                @if(Auth::user()->hasConfirmed())
                    {{ link_to_route('pages.ticket.download', 'Download Ticket', null, ['class' => 'btn waves-effect waves-light green']) }}
                @else
                    <a class="btn waves-effect waves-light green modal-trigger" href="#modal-confirm">Confirm and generate ticket</a>
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
                            <p>Sit back and relax we will be verifying your ticket within a day, <strong>dont forget to check back!</strong></p>
                        @endif
                    </li>
                @endif    
                <li class="collection-item"><strong>Step 3: Payment Process</strong></li> 
            @else
                <li class="collection-item">
                    <strong>Your verification and payment will be done by one of your team leaders</strong>
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