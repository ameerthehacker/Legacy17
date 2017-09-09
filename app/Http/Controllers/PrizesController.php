<?php

namespace App\Http\Controllers;

use Request;
use App\Event;
use App\User;
use App\Prize;
use App\Http\Requests\PrizeRequest;

class PrizesController extends Controller
{
    function create($event_id){
        $event = Event::find($event_id);
        
        return view('prizes.create')->with('event', $event);
    }
    function store(PrizeRequest $request, $event_id){
        $inputs = $request->all();
        $event = Event::findOrFail($event_id);
        // Get user who won the prize
        $first_prize_user = $inputs['first_prize'];
        $second_prize_user = $inputs['second_prize'];
        $third_prize_user = $inputs['third_prize'];
        // Create new prizes objects
        $first_prize = new Prize();
        $second_prize = new Prize();
        $third_prize = new Prize();        
        // Assign the prizes to the users
        $first_prize->user_id = $first_prize_user;
        $second_prize->user_id = $second_prize_user;
        $third_prize->user_id = $third_prize_user;        
        // Assign the prize number to the user
        $first_prize->prize = 1;
        $second_prize->prize = 2;
        $third_prize->prize = 3;      
        // Save the prizes
        $event->prizes()->save($first_prize);
        $event->prizes()->save($second_prize);
        $event->prizes()->save($third_prize);        

        return redirect()->route('admin::events.index');
    }
    function edit($event){
        $event = Event::find($event);        
        $first_prize = Prize::where('event_id', $event->id)->where('prize', 1)->first();
        $second_prize = Prize::where('event_id', $event->id)->where('prize', 2)->first();
        $third_prize = Prize::where('event_id', $event->id)->where('prize', 3)->first();        
        return view('prizes.edit')->with('event', $event)->with('first_prize', $first_prize->user_id)->with('second_prize', $second_prize->user_id)->with('third_prize', $third_prize->user_id);
    }
    function update(PrizeRequest $request, $event){
        $inputs = $request->all();        
        $first_prize = Prize::where('event_id', $event)->where('prize', 1)->first();
        $second_prize = Prize::where('event_id', $event)->where('prize', 2)->first();
        $third_prize = Prize::where('event_id', $event)->where('prize', 3)->first();        
        $first_prize->user_id = $inputs['first_prize'];
        $second_prize->user_id = $inputs['second_prize'];
        $third_prize->user_id = $inputs['third_prize'];  
        $first_prize->save();
        $second_prize->save();      
        $third_prize->save();      

        return redirect()->route('admin::events.index');
    }
    function show($event_id){
        $event = Event::findOrFail($event_id);
        if($event->hasPrizes()){       
            return view('prizes.show')->with('event', $event);
        }  
        else{
            return redirect()->route('admin::events');
        }

    }
}
