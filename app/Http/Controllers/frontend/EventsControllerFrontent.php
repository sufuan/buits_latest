<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventsControllerFrontent extends Controller
{

    public function viewAll()
    {
        $events = Event::all();
        return view('Events.index', compact('events'));
    }


    public function previousEvents()
    {
        $events = Event::where('start', '<', now())->get();
        return view('Events.previous', compact('events'));
    }

    public function upcomingEvents()
    {
        $events = Event::where('start', '>', now())->get();
        return view('Events.upcoming', compact('events'));
    }
}
