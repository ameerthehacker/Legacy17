<div class="row">
    <div class="col-s12 input-field">
        {!! Form::label('title') !!}
        {!! Form::text('title') !!}
    </div>
    </div>
    <div class="row">
        <div class="col-s12 input-field">
            {!! Form::label('description') !!}
            {!! Form::textarea('description', null, ['class' => 'materialize-textarea']) !!}
        </div>
    </div>
    <div class="row">
        <div class="col-s12 input-field">
            {!! Form::select('category_id', $categories, null) !!}
        </div>
    </div>
    <div class="row">
        <div class="col-s12 input-field">
            {!! Form::label('rules') !!}
            {!! Form::textarea('rules', null, ['class' => 'materialize-textarea']) !!}
        </div>
    </div>
    <div class="row">
        <div class="col-s12 input-field">
            {!! Form::label('event_date', 'Date') !!}
            {!! Form::text('event_date') !!}
        </div>
    </div>
    <div class="row">
        <div class="col-s12 input-field">
            {!! Form::label('start_time') !!}
            {!! Form::text('start_time') !!}
        </div>
    </div>
    <div class="row">
        <div class="col-s12 input-field">
            {!! Form::label('end_time') !!}
            {!! Form::text('end_time') !!}
        </div>
    </div>
    <div class="row">
        <div class="col-s12 input-field">
            {!! Form::label('min_members', 'Minimum Participants') !!}
            {!! Form::text('min_members') !!}
        </div>
    </div>
    <div class="row">
        <div class="col-s12 input-field">
            {!! Form::label('max_members', 'Maximum Participants') !!}
            {!! Form::text('max_members') !!}
        </div>
    </div>
    <div class="row">
        <div class="col-s12 input-field">
            {!! Form::label('max_limit', 'Maximum Participations') !!}
            {!! Form::text('max_limit') !!}
        </div>
    </div>
    <div class="row">
        <div class="col-s12 input-field">
            {!! Form::label('contact_email') !!}
            {!! Form::text('contact_email') !!}
        </div>
    </div>
    <div class="row">
        {!! Form::label('event_image') !!}    
        <div class="col-s12 file-field input-field">
            <div class="btn">
                <span>Browse</span>
                {!! Form::file('event_image') !!}
                {!! Form::hidden('image_name') !!}
            </div>
            <div class="file-path-wrapper">
                <input type="text" class="file-path" placeholder="Browse a image file of type jpeg,png"> 
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-s12 input-fields">
            {!! Form::submit('Submit', ['class' => 'btn waves-effect waves-light green', 'id' => 'btn-create-event']) !!}
        </div>
    </div>
</div> 
