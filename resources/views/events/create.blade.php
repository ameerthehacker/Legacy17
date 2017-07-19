@extends('layouts.admin')

@section('content')

<div class="row">
    <div class="col offset-m2 m8 s12">
        @include('partials.errors')    
        <div class="card rounded-box">
            <div class="card-content">
                <span class="card-title center-align">
                    New Event
                </span>
                {!! Form::model($event, ['url' => route('admin::events.store'), 'files' => true]) !!}
                    @include('events.partials.form')
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@endsection