@extends('layouts.default')

@section('content')

<div class="row">
    <div class="row">
        <div class="col s12">
            <ul class="tabs">
                <li class="col s6 tab">
                    <a href="#tab-solo-events">Solo Events</a>
                </li>
                <li class="col s6 tab">
                    <a href="#tab-team-events">Team Events</a>
                </li>
            </ul>
        </div>
    </div>
    <div id="tab-solo-events" class="row">
        @foreach($events as $event)
            <div class="col m6 s12">
                @include('partials.event', ['event' => $event])
            </div>
        @endforeach
    </div>
    <div id="tab-team-events" class="row">
        @foreach($teamEvents as $event)
            <div class="col m6 s12">
                @include('partials.event', ['event' => $event])
            </div>
        @endforeach
    </div>
</div>

@endsection