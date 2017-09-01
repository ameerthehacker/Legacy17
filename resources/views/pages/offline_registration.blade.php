@extends('layouts.default')

@section('content')

<div class="row">
    <div class="col offset-m2 m8 s12">
        <div class="card">
            <div class="card-content">
                <div class="card-title center-align">
                    Forms
                </div>
                <div class="center-align">
                    <div class="row">
                        <div class="col s12">
                            <a href="{{ env('APP_URL') }}/uploads/reg.pdf" class="btn waves-effect waves-light green"><i class="fa fa-download"></i> Download Registration Form</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12">
                            <a href="{{ env('APP_URL') }}/uploads/acc.pdf" class="btn waves-effect waves-light green"><i class="fa fa-download"></i> Download Accomodation Form</a> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

 
    
@endsection