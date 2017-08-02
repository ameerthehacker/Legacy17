@extends('layouts.default')

@section('content')
    <div class="col offset-m2 m8 s12">
        <p class="center-align"><i class="fa fa-thumbs-o-up" style="font-size: 200px;margin-top:60px;"></i></p>
        <h4 class="center-align">{{ $info }}</h4>
        <p class="center-align">
            {{ link_to_route('auth.login', 'Login', null, ['class' => 'btn btn-large waves-light waves-effect green']) }}
        </p>
    </div>
@endsection