@extends('layouts.admin')

@section('content')

<div class="row">
    @foreach($events as $event)
        <div class="col m6 s12">
            @include('partials.event', ['event' => $event])
        </div>
    @endforeach
</div>
<script>
    $(function(){
        $(".btn-delete-event").on('click', function(evt){
            var confimation = confirm('Are you sure to delete this event?');
            if(!confimation){
                return false;
            }
        });
    });
</script>
@endsection