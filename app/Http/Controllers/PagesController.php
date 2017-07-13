<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;

class PagesController extends Controller
{
    function about(){
        return view('pages.about');
    }
    function events(){
        $events = Event::all();
        return view('pages.events')->with('events', $events);
    }
}
