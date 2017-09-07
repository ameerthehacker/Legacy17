@extends('layouts.admin')

@section('content')

<div class="row">
    <div class="col offset-m2 m8 s12">
        @include('partials.errors')
        <div class="card">
            <div class="card-content">
                <div class="card-title center-align">
                    Add Prizes For {{ $event->title }}
                </div>
                {!! Form::open(['url' => route('admin::events.prizes.store', ['event' => $event->id])]) !!}
                    @include('prizes.partials.form')
                {!! Form::close() !!}  
            </div>
        </div>
    </div>
</div>

@endsection