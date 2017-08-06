<div class="input-field">
    {!! Form::label('full_name') !!}
    {!! Form::text('full_name') !!}
</div>
<div class="input-field">
    {!! Form::label('email') !!}
    {!! Form::text('email') !!}
</div>
<div class="input-field">
    {!! Form::label('password') !!}
    {!! Form::password('password') !!}
</div>
<div class="input-field">
    @foreach($roles as $role)
        {!! Form::checkbox('roles[]', $role->id, $user->hasRole($role->role_name),  ['id' => 'role' . $role->id, 'class' => 'filled-in']) !!}
        {!! Form::label('role'.$role->id, $role->role_name) !!}
    @endforeach
</div>
<div class="input-field">
    {!! Form::submit('Submit', ['class' => 'btn waves-effect waves-light green']) !!}
</div>