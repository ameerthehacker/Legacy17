@extends('layouts.admin')

@section('content')

@if($requests->count())
    <table>
        <thead>
            <tr>
                <th>
                    Legacy ID
                </th> 
                <th>
                    Name
                </th>
                <th>
                    College
                </th>
                <th colspan="3">
                    Message
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($requests as $request)
                <tr>
                    <td>{{ $request->user->LGId() }}</td>
                    <td>{{ $request->user->full_name }}</td>
                    <td>{{ $request->user->college->name }}</td>
                    {!! Form::open(['url' => route('admin::accomodations')]) !!}   
                        <td>
                            <div class="input-field">
                                {!! Form::label('message') !!}
                                {!! Form::text('message') !!}
                                {!! Form::hidden('user_id', $request->user->id) !!}                            
                            </div>
                        </td>
                        <td>{!! Form::submit('Accept', ['class' => 'btn green', 'name' => 'submit']) !!}</td>
                        <td>{!! Form::submit('Reject', ['class' => 'btn red', 'name' => 'submit']) !!}</td>
                    {!! Form::close() !!}                          
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <h5>No new requests!</h5>
@endif
    
@endsection