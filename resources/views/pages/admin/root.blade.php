@extends('layouts.admin')

@section('content')
    @if(Auth::user()->hasRole('root'))
        <div class="row">
            <div class="col s12">
                <div class="card hoverable">
                    <div class="card-content">
                        <div class="card-title center-align">Setttings</div>
                        <table>
                            <tbody>
                                <tr>
                                    <th>Registration</th>
                                    <td>
                                        @if(App\Config::getConfig('registration_open'))
                                            {{ link_to_route('admin::registrations.close', 'Close Registration', null, ['class' => 'btn waves-effect waves-light red']) }}
                                        @else
                                            {{ link_to_route('admin::registrations.open', 'Open Registration', null, ['class' => 'btn waves-effect waves-light green']) }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Offline Registration</th>
                                    <td>
                                        @if(App\Config::getConfig('offline_link'))
                                            {{ link_to_route('admin::registrations.offline.disable', 'Disable', null, ['class' => 'btn waves-effect waves-light red']) }}
                                        @else
                                            {{ link_to_route('admin::registrations.offline.enable', 'Enable', null, ['class' => 'btn waves-effect waves-light green']) }}
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col s6">
            <div class="card hoverable">
                <div class="card-content green lighten-1">
                    <div class="card-title">
                        <h5 class="white-text"><i class="fa fa-child"></i> {{ $present_count }} {{ str_plural('Attende', $present_count) }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col s6">
            <div class="card hoverable">
                <div class="card-content green lighten-1">
                    <div class="card-title">
                        <h5 class="white-text"><i class="fa fa-users"></i> {{ $registered_count }} {{ str_plural('Registration', $registered_count) }}</h5>
                    </div>
                </div>
                @if(Auth::user()->hasRole('root'))
                    <div class="card-action">
                        {{ link_to_route('admin::registrations', 'View all Registrations') }}
                    </div>
                @endif
            </div>
        </div>
        <div class="col s6">
            <div class="card hoverable">
                <div class="card-content green lighten-1">
                    <div class="card-title">
                        <h5 class="white-text"><i class="fa fa-thumbs-up"></i> {{ $confirmed_registrations }} Confirmed</h5>
                    </div>
                </div>
                @if(Auth::user()->hasRole('root'))
                    <div class="card-action">
                        {{ link_to_route('admin::requests.all', 'View all Requests') }}                        
                    </div>
                @endif
            </div>
        </div>
        <div class="col s6">
            <div class="card hoverable">
                <div class="card-content green lighten-1">
                    <div class="card-title">
                        <h5 class="white-text"><i class="fa fa-bed"></i> {{ $accomodation_count }} {{ str_plural('Accomodation Request', $accomodation_count) }}</h5>
                    </div>
                </div>
                @if(Auth::user()->hasRole('hospitality'))
                    <div class="card-action">
                        {{ link_to_route('admin::accomodations.all', 'View all Accomodations') }}
                    </div>
                @endif
            </div>
        </div>
        <div class="col s6">
            <div class="card hoverable">
                <div class="card-content green lighten-1">
                    <div class="card-title">
                        <h5 class="white-text"><i class="fa fa-bed"></i> {{ $confirmed_accomodation }} {{ str_plural('Confirmed Accomodation', $confirmed_accomodation) }}</h5>
                    </div>
                </div>
                @if(Auth::user()->hasRole('hospitality'))
                    <div class="card-action">
                        {{ link_to_route('admin::accomodations', 'View New Accomodation Requests') }}
                    </div>
                @endif
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
        <div class="col s6">
            <div class="card hoverable">
                <div class="card-content green lighten-1">
                    <div class="card-title">
                        <h5 class="white-text"><i class="fa fa-money"></i> {{ $accomodation_payment }} {{ str_plural('Accomodation Payment', $accomodation_payment) }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection