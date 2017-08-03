<!DOCTYPE html>
<html lang="en">
    <head>
        <title></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Legacy17 Ticket</title>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <style>
            .header{
                padding: 5px;
                text-align: center;
                border-top: 1px solid #000;
                border-bottom: 1px solid #000;                
            }
            body{
                border: 1px solid #000;
                padding: 5px;
        
            }
        </style>    
    </head>
    <body>
        <img src="images/header.png" class="img-responsive" alt="Header Image">
        <p class="header text-uppercase">Payment Details</p>
        <p>You have paid for the following student(s)</p>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($user->payments as $index => $payment)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $payment->user->full_name }}</td>
                        <td>{{ $payment->user->email }}</td>
                        <td>{{ $payment->user->mobile }}</td>
                        <td><i class="fa fa-inr"></i> {{ App\Payment::getEventAmount() }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4">Total Amount Paid (Includes 4% transaction fee)</th>
                    <th><i class="fa fa-inr"></i> {{ Auth::user()->getTotalAmountPaid() }}</th>
                </tr>
            </tfoot>
        </table>
    </body>
</html>