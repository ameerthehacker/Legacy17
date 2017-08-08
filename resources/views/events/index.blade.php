@extends('layouts.admin')

@section('content')

<div class="row">
    <div class="col s12">
        {{ link_to_route('admin::events.create', 'New Event', null, ['class' => 'btn waves-effect waves-light green']) }}
    </div>
</div>
<div class="row">
    @foreach($events as $event)
        <div class="col m6 s12">
            @include('partials.event', ['event' => $event])
        </div>
    @endforeach
</div>
<div class="row"> 
    <div class="col s12">
        {{ $events->render() }}
    </div>
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