<?php

namespace App\Http\Controllers\Backend;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class EventsController extends Controller
{

    public $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('admin')->user();
            return $next($request);
        });
    }



    public function list()
    {

        if (is_null($this->user) || !$this->user->can('events.update')) {
            abort(403, 'Sorry !! You are Unauthorized to update any events !');
        }


        $events = Event::all();
        return view('backend.pages.events.list', compact('events'));
    }

    public function index()
    {

        if (is_null($this->user) || !$this->user->can('events.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any events !');
        }


        return view('backend.pages.events.index');
    }

    public function refetchEvents(Request $request)
    {
        $events = Event::all();
        return response()->json($events);
    }

    public function store(Request $request)
    {

        if (is_null($this->user) || !$this->user->can('events.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any events !');
        }


        try {
            Log::info('Store event request', $request->all());

            $validatedData = $this->validateEventRequest($request);

            $event = new Event();
            $this->fillEventData($event, $validatedData);
            $event->save();

            return response()->json(['success' => 'Event saved successfully.']);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error('Error saving event', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to save event.'], 500);
        }
    }

    public function show(Event $event)
    {
        return response()->json($event);
    }

    public function edit(Event $event)
    {
        // $this->authorize('view', $event);
        return response()->json($event);
    }

    public function update(Request $request, Event $event)
    {

        if (is_null($this->user) || !$this->user->can('events.update')) {
            abort(403, 'Sorry !! You are Unauthorized to update any events !');
        }

        try {
            Log::info('Update event request', $request->all());

            $validatedData = $this->validateEventRequest($request);

            $this->fillEventData($event, $validatedData);
            $event->save();

            return response()->json(['success' => 'Event updated successfully.']);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error('Error updating event', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to update event.'], 500);
        }
    }

    public function destroy(Event $event)
    {

        if (is_null($this->user) || !$this->user->can('events.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete any events !');
        }

        try {
            $event->delete();
            return response()->json(['success' => 'Event deleted successfully.']);
        } catch (\Exception $e) {
            Log::error('Error deleting event', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to delete event.'], 500);
        }
    }

    protected function validateEventRequest(Request $request)
    {
        $isAllDay = $request->input('is_all_day');
        $startDateFormat = $isAllDay ? 'Y-m-d' : 'Y-m-d H:i';
        $endDateFormat = $isAllDay ? 'Y-m-d' : 'Y-m-d H:i';

        return $request->validate([
            'title' => 'required|string|max:255',
            'startDate' => ['required', 'date_format:' . $startDateFormat],
            'endDate' => ['required', 'date_format:' . $endDateFormat, 'after_or_equal:startDate'],
            'is_all_day' => 'required|boolean',
            'description' => 'nullable|string',
            'countdown' => 'boolean',
        ], [
            'endDate.after_or_equal' => 'The end date must be a date after or equal to start date.',
        ]);
    }

    protected function fillEventData(Event $event, array $validatedData)
    {
        $event->title = $validatedData['title'];
        $event->start = $validatedData['startDate'];
        $event->end = $validatedData['endDate'];
        $event->is_all_day = $validatedData['is_all_day'];
        $event->description = $validatedData['description'];
        $event->countdown = $validatedData['countdown'] ?? 0;
    }

    public function updateCountdown(Request $request, Event $event)
    {
        if (is_null($this->user) || !$this->user->can('events.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any events !');
        }

        try {
            // Update countdown status
            $event->countdown = $request->input('countdown') ? 1 : 0;
            $event->save();

            // Return the view with success message
            return view('events.showDetails', [
                'event' => $event,
                'message' => 'Countdown status updated successfully.',
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating countdown status', ['error' => $e->getMessage()]);

            // Return the view with an error message
            return view('events.showDetails', [
                'event' => $event,
                'error' => 'Failed to update countdown status.',
            ]);
        }
    }

    public function editDetails(Event $event)
    {




        return view('backend.pages.events.edit-details', compact('event'));
    }

    public function showDetails(Event $event)
    {
        return view('backend.pages.events.details', compact('event'));
    }
}
