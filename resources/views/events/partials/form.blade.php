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
        {!! Form::label('allow_gender_mixing') !!}
        {!! Form::radio('allow_gender_mixing', 1, $event->allow_gender_mixing, ['class' => 'with-gap', 'id' => 'rad-yes'] ) !!}
        {!! Form::label('rad-yes', 'Yes') !!}
        {!! Form::radio('allow_gender_mixing', 0, $event->allow_gender_mixing, ['class' => 'with-gap', 'id' => 'rad-no'] ) !!}
        {!! Form::label('rad-no', 'No') !!}
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
        <div class="col s12">
            {!! Form::label('organizers', 'Email ids of all organizers') !!}
            <div class="chips-autocomplete">
            </div>
        </div>
    </div>
    {!! Form::hidden('organizers', $organizers, ['id' => 'organizers']) !!}
    <div class="row">
        <div class="col-s12 input-fields">
            {!! Form::submit('Submit', ['class' => 'btn waves-effect waves-light green', 'id' => 'btn-create-event']) !!}
        </div>
    </div>
</div> 

<script>
    $(function(){
        var chips = $(".chips-autocomplete");
        $.ajax({
            url: "{{ route('admin::admins') }}",
            method: 'get',
            success: function(res){
                var suggestions = {};
                $.each(res, function(index, val){
                    suggestions[val.email] = null;
                });
                chips.material_chip({
                    placeholder: '+Organizers',
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
        function updateOrganizers(evt, chip){
            var data = chips.material_chip('data');
            var tags = [];
            $.each(data, function(index, val){
                tags.push(val.tag);
            });
            $("#organizers").val(tags.join(','));
        }
        function loadChips(){
            var teamMembers = $("#organizers").val().split(',');
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
        chips.on('chip.add', updateOrganizers);
        chips.on('chip.delete', updateOrganizers);        
    });
</script>
