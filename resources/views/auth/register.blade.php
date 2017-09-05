@extends('layouts.default')

@section('content')
    <div class="row">
        <div class="col offset-m2 m8 s12">
            @include('partials.errors')
            <div class="card z-depth-2 rounded-box">
                <div class="card-content">
                    <span class="card-title center-align">
                        <i class="material-icons">perm_identity</i> Register
                    </span>
                    @if(App\Config::getConfig('registration_open'))
                        {!! Form::open(['url' => route('auth.register')]) !!}
                            @include('auth.partials.form')
                        {!! Form::close() !!}
                    @else
                        <p class="flow-text  center-align red-text">Sorry! Registrations are closed</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection