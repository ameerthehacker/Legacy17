@extends($layout)

@section('content')
    @if((Auth::check() && Auth::user()->type == 'admin') || (App\Event::where('show_prize', true)->count() > 0 && App\Prize::all()->count() > 0))
        @if(App\Prize::all()->count() == 0)
            <div class="row">
                <div class="col s12">
                    <p class="center-align"><i class="fa fa-smile-o" style="font-size: 200px;margin-top:60px;"></i></p>
                    <h4 class="center-align">
                        No events are updated with prizes!
                    </h4>
                </div>
            </div> 
        @endif
        @foreach($events as $event)
            @if(Auth::check() && Auth::user()->type == 'admin')
                @if($event->hasPrizes())
                        @include('prizes.partials.prize_details', ['event' => $event])
                @endif  
            @else
                @if($event->show_prize && $event->hasPrizes())
                    @include('prizes.partials.prize_details', ['event' => $event])
                @endif  
            @endif
        @endforeach
    @else
        <div class="row">
            <div class="col s12">
                <p class="center-align"><i class="fa fa-smile-o" style="font-size: 200px;margin-top:60px;"></i></p>
                <h4 class="center-align">
                    We will be posting the results soon!
                </h4>
            </div>
        </div>
    @endif
@endsection