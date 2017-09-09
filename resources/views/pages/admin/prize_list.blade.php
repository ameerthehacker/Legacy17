@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col offset-m2 m8 s12">
            @include('partials.errors')
            <div class="card z-depth-2 rounded-box">
                <div class="card-content">
                    <span class="card-title center-align">
                        <i class="fa fa-gift"></i> Edit Prizes List
                    </span>
                    {!! Form::open(['url' => route('admin::prizes.list')]) !!}
                        <table>
                            @foreach($events as $event)
                                <tr>
                                    <td>{{ $event->title }}</td>
                                    <td>
                                        <div class="switch"> 
                                            <label>
                                                On
                                                <input type="checkbox" name="prize-list[]" {{ $event->show_prize? 'checked':'' }} value="{{ $event->id }}">
                                                <span class="lever"></span>
                                                Off
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        {!! Form::submit('Submit', ['class' => 'btn waves-light waves-effect green']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection