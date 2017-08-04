<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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
    <p class="header text-uppercase">Entry Ticket</p>
    <table class="table">
        <tbody>
            <tr>
                <th>Legacy ID</th>
                <td>
                    <strong>{{ $user->LGId() }}</strong>
                </td>
            </tr>
            <tr>
                <th>Name</th>
                <td>{{ $user->full_name }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $user->email }}</td>
            </tr>
            <tr>
                <th>Gender</th>
                <td>{{ $user->gender }}</td>
            </tr>
            <tr>
                <th>College</th>
                <td>{{ $user->college->getQualifiedName() }}</td>
            </tr>
            <tr>
                <th>Mobile No</th>
                <td>{{ $user->mobile }}</td>
            </tr>
        </tbody>
    </table>
    @if($user->events->count())
        <p class="header text-uppercase">Solo Event Details</p>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Event Name</th>
                </tr>
            </thead>
            <tbody>
                @foreach($user->events as $index => $event)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $event->title }}</td>                                        
                    </tr>
                @endforeach
            </tbody>
        </table>    
    @endif
        @if($user->teamEvents()->count())
        <p class="header text-uppercase">Team Event Details</p>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Event Type</th>
                    <th>Event Name</th>
                </tr>
            </thead>
            <tbody>
                @foreach($user->teamEvents() as $index => $event)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $event->category->name }}</td>                        
                        <td>{{ $event->title }}</td>                                        
                    </tr>
                @endforeach
            </tbody>
        </table>    
    @endif
    @if($user->hasTeams())
        <p class="text-uppercase header">Team Details</p>
        @foreach($user->teams as $team)
            <p>{{ $team->name }} - {{ $team->events->first()->title }}</p>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Gender</th>
                        <th>Mobile</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($team->teamMembers as $index => $teamMember)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $teamMember->user->full_name }}</td>
                            <td>{{ $teamMember->user->email }}</td>
                            <td>{{ $teamMember->user->gender }}</td>
                            <td>{{ $teamMember->user->mobile }}</td>           
                        </tr>                 
                    @endforeach
                </tbody>
            </table>
        @endforeach
    @endif
    <p class="text-uppercase header">Accompanying Staffs (To be filled by students)</p>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>S.No</th>
                <th>Name</th>
                <th>Email</th>
                <th>Gender</th>
                <th>Mobile</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>           
            </tr> 
            <tr>
                <td>2</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>           
            </tr>                  
        </tbody>
    </table>
    <p class="text-uppercase header">Certificate</p>
    <p style="text-indent: 0.5in">
         This is to certicy that <strong>{{ ($user->gender == 'male' ? 'Mr. ' : 'Ms. ').$user->full_name  }}</strong> is permitted to attend the events of Legacy17 on Sept 8,9 2017. {{ $user->gender == 'male' ? 'He' : 'She' }} is a bonafide student of this institute
    </p>
    <div class="row" style="margin-top: 70px">
        <div class="col-xs-7">
            <p>Place:</p>
            <p>Date:</p>  
        </div>  
        <div class="col-xs-3">
            <p class="text-center">
                Signature & Seal of Head of department/institute
            </p>
        </div>
    </div>
</body>
</html>