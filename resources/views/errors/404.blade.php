@extends('layouts.default')

@section('content')
    <div class="col offset-m2 m8 s12">
        <p class="center-align"><i class="fa fa-meh-o" style="font-size: 200px;margin-top:60px;"></i></p>
        <h4 class="center-align">OOPS! thats a 404</h4>
        <p class="center-align">
            <a href="{{ route('pages.root') }}" class="btn btn-large green">Go to Home</a>
        </p>
    </div>
@endsection