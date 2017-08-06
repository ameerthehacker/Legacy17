@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col s6">
            <div class="card hoverable">
                <div class="card-content green lighten-1">
                    <div class="card-title">
                        <h5 class="white-text"><i class="fa fa-users"></i> {{ $registered_count }} {{ str_plural('Registration', $registered_count) }}</h5>
                    </div>
                </div>
                <div class="card-action">
                    {{ link_to_route('admin::registrations', 'View all Registrations') }}
                </div>
            </div>
        </div>
        <div class="col s6">
            <div class="card hoverable">
                <div class="card-content green lighten-1">
                    <div class="card-title">
                        <h5 class="white-text"><i class="fa fa-thumbs-up"></i> {{ $confirmed_registrations }} Confirmed</h5>
                    </div>
                </div>
                <div class="card-action">
                    {{ link_to_route('admin::requests.all', 'View all Requests') }}
                </div>
            </div>
        </div>
        <div class="col s6">
            <div class="card hoverable">
                <div class="card-content green lighten-1">
                    <div class="card-title">
                        <h5 class="white-text"><i class="fa fa-bed"></i> {{ $accomodation_count }} {{ str_plural('Accomodation Request', $accomodation_count) }}</h5>
                    </div>
                </div>
                <div class="card-action">
                    {{ link_to_route('admin::accomodations.all', 'View all Accomodations') }}
                </div>
            </div>
        </div>
        <div class="col s6">
            <div class="card hoverable">
                <div class="card-content green lighten-1">
                    <div class="card-title">
                        <h5 class="white-text"><i class="fa fa-bed"></i> {{ $confirmed_accomodation }} {{ str_plural('Confirmed Accomodation', $confirmed_accomodation) }}</h5>
                    </div>
                </div>
                <div class="card-action">
                    {{ link_to_route('admin::accomodations', 'View New Accomodation Requests') }}
                </div>
            </div>
        </div>
        <div class="col s6">
            <div class="card hoverable">
                <div class="card-content green lighten-1">
                    <div class="card-title">
                        <h5 class="white-text"><i class="fa fa-money"></i> {{ $payment_count }} {{ str_plural('Payment', $payment_count) }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection