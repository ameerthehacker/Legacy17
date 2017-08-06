<ul class="collection with-header">
    <li class="collection-header"><h5>Student Details</h5></li>
    <li class="collection-item">
        <table>
            <tbody>
                <tr>
                    <th>Legacy ID</th>
                    <td>{{ $user->LGId() }}</td>
                </tr>
                <tr>
                    <th>Name</th>
                    <td>{{ $user->full_name }}</td>
                </tr>
                <tr>
                    <th>College</th>
                    <td>{{ $user->college->getQualifiedName() }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $user->email }}</td>
                </tr>
                <tr>
                    <th>Gender</th>
                    <td>{{ $user->gender }}</td>
                </tr>
                <tr>
                    <th>Mobile</th>
                    <td>{{ $user->mobile }}</td>
                </tr>
                <tr>
                    <th>Registration Confimation</th>
                    <td>
                        @if($user->hasConfirmed())
                            <span class="green-text">Confirmed</span>
                        @else
                            <span class="red-text">Not Confimed</span>
                        @endif
                    </td>
                </tr>
                @if($user->confirmation)
                    <tr>
                        <th>Registration Request</th>
                        <td>
                            @if($user->confirmation->status == 'ack')
                                <span class="green-text">Accepted</span>
                            @elseif($user->confirmation->status == 'nack')
                                <span class="red-text">Rejected</span>    
                            @else
                                Yet to be acknowledged
                            @endif
                        </td>
                    </tr>
                @endif
                <tr>
                    <th>Payment Status</th>
                    <td>
                        @if($user->hasPaid())
                            <span class="green-text">Paid</span>
                        @else
                            <span class="red-text">Not Paid</span>
                        @endif
                    </td>
                </tr>
                @if($user->hasPaid())
                    <tr>
                        <th>Paid By</th>
                        <td>{{ $user->payment->paidBy->full_name }} [{{ $user->payment->paidBy->email }}]</td>
                    </tr>
                @endif
                @if($user->accomodation)
                    <tr>
                        <th>Accomodation Request</th>
                        <td>
                            @if($user->accomodation->status == 'ack')
                                <span class="green-text">Accepted</span>
                            @elseif($user->accomodation->status == 'nack')
                                <span class="red-text">Rejected</span>    
                            @else
                                Yet to be acknowledged
                            @endif
                        </td>
                    </tr>
                @endif
                @if($user->accomodation && $user->accomodation->status == 'ack')
                    <tr>
                        <th>Accomodation Payment Status</th>
                        <td>
                            @if($user->accomodation->paid)
                                <span class="green-text">Paid</span>
                            @else
                                <span class="red-text">Not Paid</span>                                
                            @endif
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </li>
</ul>
@if($user->events()->count())
    <ul class="collection with-header">
        <li class="collection-header">
            <h5>Events Details</h5>                            
        </li>
        @foreach($user->events as $event)
            <span class="new badge blue" data-badge-caption="From Same college">{{ $user->college->noOfParticipantsForEvent($event->id) }}</span> 
            <span class="new badge green" data-badge-caption="Total Confirmed">{{   $event->noOfConfirmedRegistration() }}</span>
            <li class="collection-item">
                {{ $event->title }}
            </li>
        @endforeach
    </ul>
@endif
@if($user->teams()->count())
    <ul class="collection with-header">
        <li class="collection-header">
            <h5>Teams Details</h5>
        </li>
        @foreach($user->teams as $team)
            <li class="collection-item">
                <span class="new badge blue" data-badge-caption="From Same college">{{ $user->college->noOfParticipantsForEvent($team->events->first()->id) }}</span> 
                <span class="new badge green" data-badge-caption="Total Confirmed">{{ $team->events->first()->noOfConfirmedRegistration() }}</span>
                <p>
                    <strong>{{ $team->events->first()->title }}</strong>                         
                </p>
                <p>
                    @include('partials.team_details', ['team' => $team])
                </p>
            </li>
        @endforeach
    </ul>
@endif