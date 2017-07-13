@extends('layouts.default')

@section('content')
    @if($errors->any())
        <div class="collection with-header">
            <ul>
                <li class="collection-header">
                    <h5 class="red-text">Fix the following errors to proceed</h5>
                </li>
                @foreach($errors->all() as $error)
                    <li class="collection-item">
                        {{ $error }}
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="card z-depth-2 rounded-box">
        <div class="card-content">
            <span class="card-title">
                <h4 class="center-align"> <i class="material-icons">perm_identity</i> Register</h4>
            </span>
            {!! Form::open(['url' => route('auth.register')]) !!}
                <div class="row">
                    <div class="col m6 s12 input-field">
                        <i class="material-icons prefix">account_circle</i>
                        {!! Form::label('full_name') !!}
                        {!! Form::text('full_name') !!}
                    </div>
                    <div class="col m6 s12 input-field">
                        <i class="material-icons prefix">email</i>                    
                        {!! Form::label('email') !!}
                        {!! Form::text('email') !!}
                    </div>
                     <div class="col m6 s12 input-field">
                        <i class="material-icons prefix">vpn_key</i>                        
                        {!! Form::label('password') !!}
                        {!! Form::password('password') !!}
                    </div>
                    <div class="col m6 s12 input-field">
                        <i class="material-icons prefix">dialpad</i>                                            
                        {!! Form::label('password_confirmation') !!}
                        {!! Form::password('password_confirmation') !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <i class="fa fa-2x fa-transgender prefix"></i> 
                        {!! Form::radio('gender', 'male', null, ['id' => 'male', 'checked' => 'true']) !!}
                        {!! Form::label('male') !!}                     
                        {!! Form::radio('gender', 'female', null, ['id' => 'female']) !!}       
                        {!! Form::label('female') !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col m6 s12 input-field">
                        <i class="fa fa-2x fa-graduation-cap prefix"></i>                     
                        {!! Form::label('college_name') !!}
                        {!! Form::text('college_name') !!}
                    </div>
                    <div class="col m6 s12 input-field">
                        <i class="material-icons prefix">call</i>
                        {!! Form::label('mobile_number') !!}
                        {!! Form::text('mobile_number') !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 input-field">
                        {!! Form::submit('Register', ['class' => 'btn waves-effect waves-light green']) !!}
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection