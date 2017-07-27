@extends('layouts.admin')

@section('content')
    @if($requests->count() == 0)
        <h4>No new requests!</h4>
    @endif
    <ul class="collapsible popout" data-collapsible="accordion">
        @foreach($requests as $request)
            <li>
                <div class="collapsible-header">
                    <strong>{{ $request->user->full_name }}</strong> From <strong>{{ $request->user->college->name }}</strong>
                    <a href="/uploads/tickets/{{ $request->user->confirmation->file_name }}" class= "right" target="_blank">View Ticket <i class="fa fa-eye"></i></a>
                </div>
                <div class="collapsible-body">
                    <ul class="collection with-header">
                        <li class="collection-header"><h5>Student Details</h5></li>
                        <li class="collection-item">
                            <table>
                                <tbody>
                                    <tr>
                                        <th>Legacy ID</th>
                                        <td>{{ $request->user->LGId() }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>{{ $request->user->email }}</td>
                                    </tr>
                                    <tr>
                                        <th>Gender</th>
                                        <td>{{ $request->user->gender }}</td>
                                    </tr>
                                    <tr>
                                        <th>Mobile</th>
                                        <td>{{ $request->user->mobile }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </li>
                    </ul>
                    @if($request->user->events()->count())
                        <ul class="collection with-header">
                            <li class="collection-header">
                                <h5>Events Details</h5>                            
                            </li>
                            @foreach($request->user->events as $event)
                                <span class="badge blue" data-badge-caption="From Same college">{{ $request->user->college->noOfParticipantsForEvent($event->id) }}</span> 
                                <span class="badge green" data-badge-caption="Total Confirmed">{{ $event->noOfConfirmedRegistration() }}</span>
                                <li class="collection-item">
                                    {{ $event->title }}
                                </li>
                            @endforeach
                        </ul>
                    @endif
                    <ul class="collection with-header">
                        <li class="collection-header">
                            <h5>Teams Details</h5>
                        </li>
                        @foreach($request->user->teams as $team)
                            <span class="new badge blue" data-badge-caption="From Same college">{{ $request->user->college->noOfParticipantsForEvent($team->events->first()->id) }}</span> 
                            <span class="new badge green" data-badge-caption="Total Confirmed">{{ $team->events->first()->noOfConfirmedRegistration() }}</span>
                            <p>
                                <strong>{{ $team->events->first()->title }}</strong>                         
                            </p>
                            <p>
                                @include('partials.team_details', ['team' => $team])
                            </p>
                        @endforeach
                    </ul>
                    <p>
                        {!! Form::open(['url' => route('admin::requests')]) !!}
                            {!! Form::hidden('user_id', $request->user->id) !!}
                            <div class="input-field">
                                {!! Form::label('message') !!}
                                {!! Form::textarea('message', null, ['class' => 'materialize-textarea']) !!}
                            </div>
                            <div class="input-field">
                                {!! Form::submit('Accept', ['class' => 'btn green', 'name' => 'submit']) !!}
                                {!! Form::submit('Reject', ['class' => 'btn red', 'name' => 'submit']) !!}
                            </div>
                        {!! Form::close() !!}
                    </p>    
                </div>
            </li>
        @endforeach   
    </ul>
@endsection