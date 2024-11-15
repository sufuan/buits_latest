<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventsControllerFrontent extends Controller
{

    public function viewAll()
    {
        $events = Event::all()->map(function ($event) {
            return [
                'title' => $event->title,
                'start' => $event->start_date,
                'end' => $event->end_date,
            ];
        });
        
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
