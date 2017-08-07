@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col s12">
            {{ link_to_route('admin::users.create', 'New User', null, ['class' => 'btn waves-effect waves-light green']) }}
        </div>
    </div>
    <div class="row">
        @if($users->count() == 0)
            <div class="col sm-12">
                <h5><i class="fa fa-check-circle"></i> Nothing to show!</h5>
            </div>
        @else
            @foreach($users as $user)
                <div class="col m6 s12">
                    <div class="card rounded-box z-depth-4">
                        <div class="card-content">
                            <div class="card-title center-align">
                                {{ $user->full_name }}
                            </div>
                            <table>
                                <tbody>
                                    <tr>
                                        <th>Email</th>
                                        <td>{{ $user->email }}</td>
                                    </tr>
                                    <tr>
                                        <th>Roles</th>
                                        <td>{{ implode(",", $user->roles()->pluck('role_name')->toArray()) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            {{ link_to_route('admin::users.edit', 'Edit', ['id' => $user->id], ['class' => 'btn waves-effect waves-light green']) }}
                            {!! Form::open(['url' => route('admin::users.destroy', ['id' => $user->id]), 'method' => 'DELETE', 'style' => 'display: inline;']) !!}
                                {!! Form::submit('Remove', ['class' => 'btn waves-effect waves-light red']) !!}
                            {!! Form::close() !!}
                        </div>
                    </div> 
                </div>
            @endforeach
        @endif
    </div>
@endsection