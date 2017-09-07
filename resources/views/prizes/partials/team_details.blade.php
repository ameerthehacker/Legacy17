<ul class="collection">  
    <li class="collection-item">
        @include('prizes.partials.student_details', ['user' => $team->user])
    </li>      
    @foreach($team->teamMembers as $teamMember)
        <li class="collection-item">
            @include('prizes.partials.student_details', ['user' => $teamMember->user])
        </li>
    @endforeach
</ul>