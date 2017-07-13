@extends('layouts.default')

@section('content')

<div class="row">
    @foreach($events as $event)
        <div class="col m6 s12">
            @include('pages.partials.event', ['event' => $event])
        </div>
    @endforeach
</div>

@endsection