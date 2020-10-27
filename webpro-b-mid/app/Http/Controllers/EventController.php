<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::latest()->paginate(5);

        return view('event.index', compact('events'))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('event.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        Event::create([
            'event_organizer' => $user->id,
            'event_name' => $request->event_name,
            'event_place' => $request->event_place,
            'event_price' => $request->event_price,
            'event_start' => $request->event_start,
            'event_end' => $request->event_end,
            'event_description' => $request->event_description,
        ]);

        return redirect()->route('my-events.index')->with('success', 'Event created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $event = Event::where('event_id', $id)->first();
        return view('event.show', compact('event'));
    }

    public static function eventOrganizer($id){
        $organizer = DB::table('events')
                        ->join('users', 'events.event_organizer','=','users.id')
                        ->select('users.name')
                        ->where('events.event_id', $id);
        $organizer = $organizer->value('name');
        return $organizer;
    }

    public function myEvent(){
        $user = Auth::user();
        $my_event = DB::table('events')
                        ->join('users', 'events.event_organizer','=','users.id')
                        ->select('events.*', 'events.event_name')
                        ->where('events.event_organizer', $user->id);
        $my_event = $my_event->get();
        return view('event.myEvent', compact('my_event'));
    }

    // public function notMyEvent(){
    //     $user = Auth::user();
    //     $not_my_event = DB::table('events')
    //                     ->join('users', 'events.event_organizer','=','users.id')
    //                     ->select('events.*', 'events.event_name')
    //                     ->where('events.event_organizer', '!=', $user->id);
    //     $not_my_event = $not_my_event->get();
    //     return view('event\notMyEvent', compact('not_my_event'));
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $event = Event::where('event_id', $id)->first();
        return view('event.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Event::where('event_id', $id)->update([
            'event_name' => $request->event_name,
            'event_price' => $request->event_price,
            'event_place' => $request->event_place,
            'event_description' => $request->event_description,
            'event_start' => $request->event_start,
            'event_end' => $request->event_end,
        ]);
        return redirect()->route('my-events.index')->with('success', 'Event updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Event::where('event_id', $id)->delete();
        return redirect()->route('my-events.index')->with('success', 'Event deleted successfully');
    }
}
