<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Partner;
use App\Models\Transaksi; 

class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();
        $partners = Partner::all();
        return view('layout.index', compact('events', 'partners'));
    }

    public function show($id)
    {
        $event = Event::findOrFail($id);
        return view('layout.event_detail', compact('event'));
    }

    public function checkout($id)
    {
        $event = Event::findOrFail($id);
        return view('layout.checkout', compact('event'));
    }

    public function proses(Request $request)
    {
        $request->validate([
            'event_id' => 'required',
            'nama'     => 'required|string|max:255',
            'email'    => 'required|email',
            'telepon'  => 'required',
        ]);

        $event = Event::findOrFail($request->event_id);

        $transaksi = new Transaksi();
        $transaksi->event_id = $event->id;
        $transaksi->pembeli  = $request->nama;
        $transaksi->email    = $request->email;
        $transaksi->telepon  = $request->telepon;  
        $transaksi->total    = $event->price + 5000;
        $transaksi->status   = 'SUCCESS';
        $transaksi->order_id = 'TRX-' . rand(10000, 99999); 

        $transaksi->save();

        return view('layout.ticket', [
            'event'     => $event,
            'transaksi' => $transaksi
        ]);
    }
}