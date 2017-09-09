@extends('layouts.admin')

@section('content')

@include('pages.admin.partials.search_bar')
<div class="col s12">
    <p class="flow-text">{{ $registrations_count }} results <i class="fa fa-users"></i></p>
</div>
<div class="row">
    <div class="col s12">
        @if($registrations->count() == 0)
            <h5><i class="fa fa-check-circle"></i> Nothing to show!</h5>
        @endif
        <ul class="collapsible popout" data-collapsible="accordion">
            @foreach($registrations as $registration)
                <li>
                    <div class="collapsible-header">
                        <strong>{{ $registration->full_name }}</strong> From <strong>{{ $registration->college->name }}</strong>
                        @if(Auth::user()->hasRole('root') || Auth::user()->hasRole('registration'))
                            <a class="right" href="{{ route('admin::registrations.edit', ['user_id' => $registration->id]) }}"><i class="fa fa-pencil"></i> Edit</a>
                        @endif
                    </div>
                    <div class="collapsible-body">
                        @include('pages.admin.partials.student_detail', ['user' => $registration])
                    </div>
                </li>
            @endforeach   
        </ul> 
    </div>
</div>
<div class="row">
    <div class="col s12">
        {{ $registrations->appends(Request::capture()->except('page'))->render() }}        
    </div>
</div>

@endsection