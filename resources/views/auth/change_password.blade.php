@extends($layout)      

@section('content')

<div class="row">
    <div class="col offset-m2 m8 s12">
        @include('partials.errors')
        <div class="card z-depth-4 rounded-box">
            <div class="card-content">
                <div class="card-title center-align">
                    Change Password
                </div>
                {!! Form::open(['url' => route('auth.changePassword')]) !!}
                    <div class="input-field">
                        {!! Form::label('old_password') !!}
                        {!! Form::password('old_password') !!}                        
                    </div>
                    <div class="input-field">
                        {!! Form::label('new_password') !!}
                        {!! Form::password('new_password') !!}                        
                    </div>
                    <div class="input-field">
                        {!! Form::label('new_password_confirmation') !!}
                        {!! Form::password('new_password_confirmation') !!}                        
                    </div>
                    <div class="input-field">
                        {!! Form::submit('Change Password', ['class' => 'btn waves-effect waves-light green']) !!}                        
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@endsection