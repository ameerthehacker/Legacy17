@extends('layouts.admin')

@section('content')

<div class="row">
    <div class="col s12">
        <p class="flow-text">{{ $users_count }} results <i class="fa fa-users"></i></p>                
        @if($users->count() == 0)
            <h5><i class="fa fa-check-circle"></i> Nothing to show!</h5>            
        @else
            <table>
                <thead>
                    <tr>
                        <th>
                            LG ID
                        </th>
                        <th>
                            Full Name
                        </th>
                        <th>
                            Email
                        </th>
                        <th>
                            College
                        </th>
                        <th>
                            Gender
                        </th>
                        <th>
                            Mobile
                        </th>
                        <th>
                            Status
                        </th>
                        <th>
                            Days
                        </th>
                        <th>
                            Payment
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->LGId() }}</td>
                            <td>{{ $user->full_name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->college->name }}</td>
                            <td>{{ $user->gender }}</td>                            
                            <td>{{ $user->mobile }}</td>    
                            <td>
                                @if($user->accomodation->status != null)
                                    {{ $user->accomodation->status == 'ack'?'Accepted':'Rejected' }}
                                @else
                                    Not yet acknwoledged
                                @endif
                            </td> 
                            <td>{{ $user->accomodation->days  }}</td> 
                            <td>
                                {{ $user->accomodation->paid?'Paid': 'Not Paid' }}
                            </td>                       
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
<div class="row">
    <div class="col s12">
        {{ $users->appends(Request::capture()->except('page'))->render() }}        
    </div>
</div>

@endsection