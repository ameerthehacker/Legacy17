@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col offset-m2 m8 s12">
            @include('partials.errors')
            <div class="card rounded-box">
                <div class="card-content">
                    <div class="center-align card-title">
                        Edit User
                    </div>
                    {!! Form::model($user, ['url' => route('admin::users.update', ['id' => $user->id]), 'method' => 'PUT']) !!}
                        @include('users.partials.form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection