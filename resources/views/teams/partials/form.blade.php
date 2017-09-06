<div class="row">
    <div class="col s12 input-field">
        {!! Form::label('name', 'Team Name') !!}            
        {!! Form::text('name') !!}
    </div>
</div>
<div class="row">
    <div class="col s12">
        {!! Form::label('team_members', 'Email ids of all team members') !!}
        <div class="chips-autocomplete">
        </div>
    </div>
    {!! Form::hidden('team_members', implode(',', App\User::whereIn('id', $team->teamMembers()->pluck('user_id'))->pluck('email')->toArray()), ['id' => 'team-members']) !!}
</div>
<div class="row">
    <div class="col s12 input-field">
        {!! Form::submit('Submit', ['class' => 'btn waves-effect waves-light green']) !!}
    </div>
</div>