@extends('layouts.default')

@section('content')
    <div class="row">
        <div class="col offset-m2 m8 s12">
            @include('partials.errors')
            <div class="card z-depth-2 rounded-box">
                <div class="card-content">
                    <span class="card-title center-align">
                        <i class="material-icons">perm_identity</i> Login
                    </span>
                    {!! Form::open(['url' => route('auth.login')]) !!}
                        <div class="row">
                            <div class="col s12 input-field">
                                <i class="material-icons prefix">email</i>                    
                                {!! Form::label('email') !!}
                                {!! Form::text('email') !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s12 input-field">
                                <i class="material-icons prefix">vpn_key</i>                        
                                {!! Form::label('password') !!}
                                {!! Form::password('password') !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s12">
                                {!! Form::checkbox('remember', true, 1, ['id' => 'remember']) !!}
                                {!! Form::label('remember', 'Remember Me!') !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s12">
                                {!! Form::submit('login', ['class' => 'btn waves-effect green']) !!}
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection