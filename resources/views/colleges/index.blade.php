@extends('layouts.admin')

@section('content')

<div class="row">
    <div class="col s12">
        {{ link_to_route('admin::colleges.create', 'Add College', null, ['class' => 'btn green waves-effect waves-light ']) }}
    </div>
</div>
<div class="row">
    <div class="col s12">
        @if($colleges->count() == 0)
            <h5><i class="fa fa-check-circle"></i> Nothing to show!</h5>
        @endif
        <ul class="collection with-header z-depth-4 rounded-box">
            <li class="collection-header center-align"><h4>Colleges</h4></li>
            @foreach($colleges as $college)
                <li class="collection-item">
                    {{ $college->getQualifiedName() }}
                    <div class="span right">
                        <a href="{{ route('admin::colleges.edit', ['id' => $college->id]) }}"><i class="fa fa-pencil"></i> Edit</a>
                        {!! Form::open(['url' => route('admin::colleges.destroy', ['id' => $college->id]), 'method' => 'DELETE', 'style' => 'display:inline', 'id' => 'frm-delete-college']) !!}
                            <a class="btn-delete-college" href="#"><i class="fa fa-trash"></i> Delete</a> 
                        {!! Form::close() !!}
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>
<div class="row">
    <div class="col s12">
        {{ $colleges->render() }}        
    </div>
</div>
<script>
    $('body').on('click', 'a.btn-delete-college', function(evt){
        evt.preventDefault();
        $(this).parent('#frm-delete-college').submit();
    });
</script>

@endsection