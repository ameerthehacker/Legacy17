@extends('layouts.admin')

@section('content')

<div class="row">
    <div class="col s12 offset-m2 m8">
        <div class="card">
            <div class="card">
                <div class="card-content">
                    <div class="card-title center-align">
                        Prizes For {{ $event->title }}
                    </div>
                    <ul class="collapsible" data-collapsible="accordion">
                        <li>
                            <div class="collapsible-header">
                                <i class="fa fa-gift "></i>
                                @if($event->isGroupEvent())
                                    {{ $first_prize_user->teamLeaderFor($event->id)->name }} From {{ $first_prize_user->college->name }}
                                @else
                                    {{ $first_prize_user->full_name }} From {{ $first_prize_user->college->name }}                                    
                                @endif 
                            </div>
                            <div class="collapsible-body">
                                @if($event->isGroupEvent())
                                    @include('prizes.partials.team_details', ['team' => $first_prize_user->teamLeaderFor($event->id)])
                                @else
                                    @include('prizes.partials.student_details', ['user' => $first_prize_user]) 
                                @endif
                            </div>
                        </li>
                        <li>
                            <div class="collapsible-header">
                                <i class="fa fa-gift "></i>                            
                                @if($event->isGroupEvent())
                                    {{ $second_prize_user->teamLeaderFor($event->id)->name }} From {{ $second_prize_user->college->name }}
                                @else
                                    {{ $second_prize_user->full_name }} From {{ $second_prize_user->college->name }}                                    
                                @endif 
                            </div>
                            <div class="collapsible-body">
                                @if($event->isGroupEvent())
                                    @include('prizes.partials.team_details', ['team' => $second_prize_user->teamLeaderFor($event->id)])
                                @else
                                    @include('prizes.partials.student_details', ['user' => $first_prize_user])
                                @endif
                            </div>
                        </li>
                        <li>
                            <div class="collapsible-header">
                                <i class="fa fa-gift "></i>                                
                                @if($event->isGroupEvent())
                                    {{ $third_prize_user->teamLeaderFor($event->id)->name }} From {{ $third_prize_user->college->name }}
                                @else
                                    {{ $third_prize_user->full_name }} From {{ $third_prize_user->college->name }}                                    
                                @endif 
                            </div>
                            <div class="collapsible-body">
                                @if($event->isGroupEvent())
                                    @include('prizes.partials.team_details', ['team' => $third_prize_user->teamLeaderFor($event->id)])
                                @else
                                    @include('prizes.partials.student_details', ['user' => $first_prize_user])
                                @endif
                            </div>
                        </li>
                    </ul> 
                </div>
            </div>
        </div>
    </div>
</div>
    
@endsection