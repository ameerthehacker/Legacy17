@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col offset-m2 m8 s12">
            @include('partials.errors')
            <div class="card z-depth-2 rounded-box">
                <div class="card-content">
                    <span class="card-title center-align">
                        <i class="material-icons">perm_identity</i> New Registration
                    </span>
                    {!! Form::open(['url' => route('admin::registrations.create')]) !!}
                      @include('pages.admin.partials.registration_form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection