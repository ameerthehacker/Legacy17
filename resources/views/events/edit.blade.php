@extends('layouts.admin')

@section('content')

<div class="row">
    <div class="col offset-m2 m8 s12">
        @include('partials.errors')    
        <div class="card">
            <div class="card-content">
                <span class="card-title">
                    <h4 class="center-align">Edit Event</h4>
                </span>
                {!! Form::model($event, ['url' => route('admin::events.update', ['id' => $event->id]), 'method' => 'put', 'files' => true]) !!}
                    @include('events.partials.form')
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@endsection