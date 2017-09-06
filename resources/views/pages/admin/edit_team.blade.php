@extends('layouts.admin')

@section('content')

<div class="row">
    <div class="col s12 offset-m2 m8">
        @include('partials.errors')
        <div class="card rounded-box">
            <div class="card-content">
                <span class="card-title center-align">
                    Edit Team
                </span>
                {!! Form::model($team, ['url' => route('admin::registrations.teams.edit', ['id' => $team->id]), 'method' => 'PUT']) !!}
                    @include('teams.partials.form')
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
<script>
    $(function(){
        var chips = $(".chips-autocomplete");
        $.ajax({
            url: "{{ route('users.college_mate', ['user_id' => $team->user_id]) }}",
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