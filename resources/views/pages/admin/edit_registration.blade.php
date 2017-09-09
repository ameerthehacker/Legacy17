@extends('layouts.admin')

@section('content')

<ul class="collection with-header">
    <li class="collection-header">
        <strong>{{ $registration->full_name }}</strong> From {{ $registration->college->name }}
    </li>
    <li class="collection-item">
        @include('partials.errors')
        {!! Form::model($registration, ['url' => route('admin::registrations.edit', [ 'user_id' => $registration->id]), 'method' => 'PUT']) !!}
            @include('pages.admin.partials.registration_form')
        {!! Form::close() !!}
    </li>
    <li class="collection-header"><h5>Solo Events</h5></li>
    @if($registration->events->count() > 0)
        @foreach($registration->events as $event)
            <li class="collection-item">
                {{ $event->title }}
                <span class="right">
                    <a href="{{ route('admin::registrations.events.unregister', ['user_id' => $registration->id, 'event_id' => $event->id]) }}"><i class="fa fa-trash"></i> Remove</a>
                </span>
            </li>                
        @endforeach
    @endif
    <li class="collection-item">
        {!! Form::open(['url' => route('admin::registrations.events.register', ['user_id' => $registration->id]), 'method' => 'GET']) !!}
            <div class="input-field">
                {!! Form::select('event_id', $soloEvents) !!}               
                {!! Form::submit('Add', ['class' => 'btn waves-effect waves-light green']) !!} 
            </div>
        {!! Form::close() !!}
    </li>
    <li class="collection-header"><h5>Team Events</h5></li>
        @if($registration->teamEvents()->count() > 0)
            @foreach($registration->teamEvents() as $event)
                <li class="collection-item">
                    {{ $event->title }}
                    @if($registration->teamLeaderFor($event->id))
                        <span class="right">
                            <a href="{{ route('admin::registrations.teams.edit', ['id' => $registration->teamLeaderFor($event->id)]) }}"><i class="fa fa-pencil"></i> Edit</a>
                            <a href="{{ route('admin::registrations.teams.unregister', ['user_id' => $registration->id, 'event_id' => $event->id]) }}"><i class="fa fa-trash"></i> Remove</a>
                        </span>
                    @endif
                </li>                
            @endforeach
        @endif
        <li class="collection-item">
            {!! Form::model($team, ['url' => route('admin::registrations.teams.register', ['user_id' => $registration->id])]) !!}
                {!! Form::select('event_id', $teamEvents) !!}                           
                @include('teams.partials.form')
            {!! Form::close() !!}
        </li>
    </li>
    <li class="collection-item">
        <table>
            <tbody>
                <tr>
                    <th>Registration Status</th>
                    <td>
                        @if($registration->hasConfirmed())
                            {{ link_to_route('admin::registrations.unconfirm', 'Unconfirm', ['user_id' => $registration->id], ['class' => 'btn waves-effect waves-light red']) }}
                        @else
                            {{ link_to_route('admin::registrations.confirm', 'Confirm', ['user_id' => $registration->id], ['class' => 'btn waves-effect waves-light green']) }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Payment Status</th>
                    <td>
                        @if($registration->hasPaid())
                            {{ link_to_route('admin::registrations.payments.unconfirm', 'Remove Payments', ['user_id' => $registration->id], ['class' => 'btn waves-effect waves-light red']) }}
                        @else
                            {{ link_to_route('admin::registrations.payments.confirm', 'Add Payments', ['user_id' => $registration->id], ['class' => 'btn waves-effect waves-light green']) }}
                        @endif
                    </td>
                </tr>
                @if(!$registration->hasRequestedAccomodation())
                    <tr>
                        <th>Accomodation Status</th>
                        <td>
                            {{ link_to_route('admin::registrations.accomodations.register', 'Add Accomodation',  ['user_id' => $registration->id], ['class' => 'btn waves-light waves-effect green']) }}                            
                        </td>
                    </tr>
                @endif
                @if($registration->hasRequestedAccomodation() && $registration->accomodation->status == 'ack')
                    <tr>
                        <th>Accomodation Payment Status</th>
                        <td>
                            @if($registration->accomodation->paid)
                                {{ link_to_route('admin::registrations.payments.unconfirm', 'Remove Payment', ['user_id' => $registration->id, 'type' => 'accomodation'], ['class' => 'btn waves-effect waves-light red']) }}
                            @else
                                {{ link_to_route('admin::registrations.payments.confirm', 'Add Payment', ['user_id' => $registration->id, 'type' => 'accomodation'], ['class' => 'btn waves-effect waves-light green']) }}
                            @endif
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </li>
</ul>
<script>
    $(function(){
        var chips = $(".chips-autocomplete");
        $.ajax({
            url: "{{ route('users.college_mate', ['user_id' => $registration->id]) }}",
            method: 'get',
            success: function(res){
                var suggestions = {};
                $.each(res, function(index, val){
                    suggestions[val.email] = null;
                });
                chips.material_chip({
                    placeholder: '+Team Members',
                    data: loadChips(),
                    autocompleteOptions:{
                        data: suggestions,
                        limit: Infinity,
                        minLength: 1
                    }
                });
            },
            error: function(){
                Materialize.toast('Sorry! something went wrong please try again')
            }
        });
        // Update team members in the hidden field
        function updateTeamMembers(evt, chip){
            var data = chips.material_chip('data');
            var tags = [];
            $.each(data, function(index, val){
                tags.push(val.tag);
            });
            $("#team-members").val(tags.join(','));
        }
        function loadChips(){
            var teamMembers = $("#team-members").val().split(',');
            var initialChips  = [];
            $.each(teamMembers, function(index, val){
                if(val != ""){
                    var chip = { 'tag': val }
                    initialChips.push(chip);
                }
            });
            return initialChips;
        }
        // Update team members hidden field on changes to chips
        chips.on('chip.add', updateTeamMembers);
        chips.on('chip.delete', updateTeamMembers);        
    });
</script>

@endsection