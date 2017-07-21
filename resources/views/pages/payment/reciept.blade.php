<!DOCTYPE html>
<html lang="en">
    <head>
        <title></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col s12">
                    <h4 class="center-align">Your payment is confirmed for the following students</h4>
                </div>
            </div>
            <div class="row">
                <div class="col s12">
                    <table class="bordered highlight responsive-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ Auth::user()->full_name }}</td>
                                <td>{{ Auth::user()->email }}</td>
                                <td>{{ Auth::user()->mobile }}</td>
                                <td><i class="fa fa-inr"></i> 200</td>
                            </tr>
                            {{-- Get all teams   --}}
                            @foreach(Auth::user()->teams as $team)
                                {{-- Get all team members  --}}
                                @foreach($team->teamMembers as $teamMember)
                                    @if(!$teamMember->user->hasPaid())
                                        <tr>
                                            <td>{{ $teamMember->user->full_name }}</td>
                                            <td>{{ $teamMember->user->email }}</td>
                                            <td>{{ $teamMember->user->mobile }}</td>
                                            <td><i class="fa fa-inr"></i> 200</td>
                                        </tr>
                                    @endif
                                @endforeach
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3">Total Amount Paid (Includes 4% transaction fee)</th>
                                <th><i class="fa fa-inr"></i> {{ Auth::user()->getTotalAmount() }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>