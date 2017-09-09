<div class="input-field">
    {!! Form::label('first_prize', 'First Prize LGID') !!}        
    {!! Form::text('first_prize', isset($first_prize)? $first_prize:'') !!}
</div>
<div class="input-field">
    {!! Form::label('second_prize', 'Second Prize LGID') !!}        
    {!! Form::text('second_prize', isset($second_prize)? $second_prize:'') !!}
</div>
<div class="input-field">
    {!! Form::label('third_prize', 'Third Prize LGID') !!}        
    {!! Form::text('third_prize', isset($third_prize)? $third_prize:'') !!}
</div>
<div class="input-field">
    {!! Form::submit('Submit', ['class' => 'btn waves-light waves-effect green']) !!}
</div>