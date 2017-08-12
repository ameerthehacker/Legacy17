@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col offset-m2 m8 s12">
        @include('partials.errors')
        {!! Form::open(['url' => route('admin::terminal')]) !!}
            <div class="input-field">
                {!! Form::label('command') !!}                
                {!! Form::text('command') !!}
            </div>
            <div class="input-field">
                {!! Form::submit('Execute', ['class' => 'btn red']) !!}
            </div>
        {!! Form::close() !!}
    </div>
</div>
@if(isset($output))
    <div class="row">
        <div class="col offset-m2 m8 s12">
            <div class="card">
                <div class="card-content">
                    <div class="card-title center align">
                        Output
                    </div>
                    {!! $output !!}
                </div>
            </div>
        </div>
    </div>
@endif
@endsection