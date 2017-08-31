@extends('layouts.admin')

@section('content')

<div class="row">
    <div class="col s12">
        <h4 class="center-align">Registrations Report</h4>
    </div>
</div>
<div class="row">
    {!! Form::open(['url' => route('admin::reports.registrations'), 'method' => 'GET']) !!}
        <div class="col s3">
            <label>College</label>
        </div>
        <div class="col s3">
            <label>Event</label>                       
        </div>
        <div class="col s3">
            <label>Gender</label>                       
        </div>
        <div class="col s3">
            <label>Payment</label>                       
        </div>
        <div class="col s3">
            {!! Form::select('college_id', $colleges) !!}
        </div>
        <div class="col s3">
            {!! Form::select('event_id', $events) !!}            
        </div>
        <div class="col s3">
            {!! Form::select('gender', ['all' => 'All', 'male' => 'Male', 'female' => 'Female']) !!}            
        </div>
        <div class="col s3">
            {!! Form::select('payment', ['all' => 'All', '1' => 'Paid', '0' => 'Not Paid']) !!}            
        </div>
        {!! Form::submit('View Report', ['class' => 'btn waves-effect waves-light green']) !!}        
    {!! Form::close() !!}    
</div>
<div class="row">
    <div class="col s12">
        <h4 class="center-align">Accomodations Report</h4>
    </div>
    {!! Form::open(['url' => route('admin::reports.accomodations'), 'method' => 'GET']) !!}
        <div class="col s3">
            <label>College</label>
        </div>
        <div class="col s3">
            <label>Status</label>                       
        </div>
        <div class="col s3">
            <label>Gender</label>                       
        </div>
        <div class="col s3">
            <label>Payment</label>                       
        </div>
        <div class="col s3">
            {!! Form::select('college_id', $colleges) !!}
        </div>
        <div class="col s3">
            {!! Form::select('status', ['all' => 'All', 'ack' => 'Accepted', 'nack' => 'Rejected']) !!}
        </div>
        <div class="col s3">
            {!! Form::select('gender', ['all' => 'All', 'male' => 'Male', 'female' => 'Female']) !!}            
        </div>
        <div class="col s3">
            {!! Form::select('payment', ['all' => 'All', '1' => 'Paid', '0' => 'Not Paid']) !!}            
        </div>
        {!! Form::submit('View Report', ['class' => 'btn waves-effect waves-light green']) !!}        
    {!! Form::close() !!}    
</div>

@endsection