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
                    <td>{{ $user->college->name }}</td>
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
            <span class="badge blue" data-badge-caption="From Same college">{{ $user->college->noOfParticipantsForEvent($event->id) }}</span> 
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
    @foreach($user->teams as $team)
        <span class="new badge blue" data-badge-caption="From Same college">{{ $user->college->noOfParticipantsForEvent($team->events->first()->id) }}</span> 
        <span class="new badge green" data-badge-caption="Total Confirmed">{{ $team->events->first()->noOfConfirmedRegistration() }}</span>
        <p>
            <strong>{{ $team->events->first()->title }}</strong>                         
        </p>
        <p>
            @include('partials.team_details', ['team' => $team])
        </p>
    @endforeach
</ul>