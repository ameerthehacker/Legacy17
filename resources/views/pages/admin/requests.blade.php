@extends('layouts.admin')

@section('content')
@include('pages.admin.partials.search_bar')
<div class="row">
    <div class="col s12">
        @if($requests->count() == 0)
            <h5><i class="fa fa-check-circle"></i> Nothing to show!</h5>
        @endif
        <ul class="collapsible popout" data-collapsible="accordion">
            @foreach($requests as $request)
                <li>
                    <div class="collapsible-header">
                        <strong>{{ $request->user->full_name }}</strong> From <strong>{{ $request->user->college->name }}</strong>
                        <a href="/uploads/tickets/{{ $request->user->confirmation->file_name }}" class= "right" target="_blank">View Ticket <i class="fa fa-eye"></i></a>
                    </div>
                    <div class="collapsible-body">
                        @include('pages.admin.partials.student_detail', ['user' => $request->user])
                        <p>
                            {!! Form::open(['url' => route('admin::requests')]) !!}
                                {!! Form::hidden('user_id', $request->user->id) !!}
                                <div class="input-field">
                                    {!! Form::label('message') !!}
                                    {!! Form::textarea('message', null, ['class' => 'materialize-textarea']) !!}
                                </div>
                                <div class="input-field">
                                    <?php 
                                        $accepted = $request->user->isConfirmed()?'disabled':'';
                                        $rejected = $request->user->isRejected()?'disabled':'';
                                    ?>
                                    {!! Form::submit('Accept', ['class' => "btn green $accepted", 'name' => 'submit']) !!}
                                    {!! Form::submit('Reject', ['class' => "btn red $rejected", 'name' => 'submit']) !!}
                                </div>
                            {!! Form::close() !!}
                        </p>    
                    </div>
                </li>
            @endforeach   
        </ul> 
    </div>
</div>
<div class="row">
    <div class="col s12">
        {{ $requests->render() }}        
    </div>
</div>
@endsection