<div class="row">
    <div class="col s6">
        {!! Form::open(['method' => 'GET']) !!}
            <div class="col s6">
                <div class="input-field">
                    {!! Form::label('search', 'Search Term') !!}
                    {!! Form::text('search') !!}   
                </div>
            </div>
            <div class="col s6">
                <div class="input-field">
                    {!! Form::submit('search', ['class' => 'btn']) !!}  
                </div>                  
            </div>    
        {!! Form::close() !!}
    </div>
</div>