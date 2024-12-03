<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class GuestController extends Controller
{
    public function index()
    {
        $events = Event::all();
        return view('events.index', compact('events'));
    }

    // public function explore()
    // {
    //     $events = Event::all();
    //     return view('guest.explore', compact('events'));
    // }

    // public function show(Event $event)
    // {
    //     return view('guest.show', compact('event'));
    // }

    public function show(string $id)
    {
        $event = Event::findOrFail($id);
        return view('events.show', compact('event'));
    }
}
