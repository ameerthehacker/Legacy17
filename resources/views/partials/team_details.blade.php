<ul class="collapsible" data-collapsible="accordion">
    <li>
        <div class="collapsible-header">
            <strong>{{ $team->name }} Details</strong>
        </div>
        <div class="collapsible-body">
            <ul class="collection">
                <span class="new badge blue" data-badge-caption="Leader"></span>           
                <li class="collection-item">
                    {{ $team->user->full_name }} 
                </li>
                @foreach($team->teamMembers as $teamMember)
                    @if($teamMember->user->hasConfirmed())
                        <span class="new badge lighten-2 green" data-badge-caption="Confirmed"></span>
                    @else
                        <span class="new badge lighten-2 red" data-badge-caption="Not Confirmed"></span>
                    @endif
                    <li class="collection-item">
                        {{ $teamMember->user->full_name }}
                    </li>
                @endforeach
            </ul>
        </div>
    </li>
</ul>