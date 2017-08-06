@extends('layouts.admin')

@section('content')

<ul class="collection with-header">
    <li class="collection-header">
        <strong>{{ $registration->full_name }}</strong> From {{ $registration->college->name }}
    </li>
    <li class="collection-item">
        <table>
            <tbody>
                <tr>
                    <th>Registration Status</th>
                    <td>
                        @if($registration->hasConfirmed())
                            {{ link_to_route('admin::registrations.unconfirm', 'Unconfirm', ['user_id' => $registration->id], ['class' => 'btn waves-effect waves-light red']) }}
                        @else
                            {{ link_to_route('admin::registrations.confirm', 'Confirm', ['user_id' => $registration->id], ['class' => 'btn waves-effect waves-light green']) }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Payment Status</th>
                    <td>
                        @if($registration->hasPaid())
                            {{ link_to_route('admin::registrations.payments.unconfirm', 'Remove Payments', ['user_id' => $registration->id], ['class' => 'btn waves-effect waves-light red']) }}
                        @else
                            {{ link_to_route('admin::registrations.payments.confirm', 'Add Payments', ['user_id' => $registration->id], ['class' => 'btn waves-effect waves-light green']) }}
                        @endif
                    </td>
                </tr>
                @if($registration->accomodation && $registration->accomodation->status == 'ack')
                    <tr>
                        <th>Accomodation Payment Status</th>
                        <td>
                            @if($registration->accomodation->paid)
                                {{ link_to_route('admin::registrations.payments.unconfirm', 'Remove Payment', ['user_id' => $registration->id, 'type' => 'accomodation'], ['class' => 'btn waves-effect waves-light red']) }}
                            @else
                                {{ link_to_route('admin::registrations.payments.confirm', 'Add Payment', ['user_id' => $registration->id, 'type' => 'accomodation'], ['class' => 'btn waves-effect waves-light green']) }}
                            @endif
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </li>
</ul>

@endsection