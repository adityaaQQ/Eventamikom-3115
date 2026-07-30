<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    /**
     * Display a listing of the resource (Multi-Tenant).
     */
    public function index()
    {
        $user = auth()->user();

        // Jika Superadmin / Admin Utama: Tampilkan seluruh event dari semua organizer
        if (in_array($user->role, ['admin', 'superadmin'])) {
            $events = Event::with(['category', 'organizer'])->latest()->paginate(10);
        } else {
            // Jika Organizer / Panitia HIMA: Hanya tampilkan event miliknya sendiri
            $events = Event::where('organizer_id', $user->organizer_id)
                           ->with(['category', 'organizer'])
                           ->latest()
                           ->paginate(10);
        }

        return view('admin.events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.events.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'date'        => 'required|date',
            'location'    => 'required|string|max:255',
            'price'       => 'required|numeric',
            'stock'       => 'required|numeric',
            'poster'      => 'nullable|image|max:2048',
        ]);

        // Otomatis kuncikan organizer_id sesuai panitia/organizer yang sedang login
        $data['organizer_id'] = auth()->user()->organizer_id;

        if ($request->hasFile('poster')) {
            $data['poster_path'] = $request->file('poster')->store('posters', 'public');
        }

        Event::create($data);

        return redirect()->route('admin.events.index')->with('success', 'Data Event berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        $user = auth()->user();

        // Mencegah panitia mengedit event milik panitia lain
        if (!in_array($user->role, ['admin', 'superadmin']) && $event->organizer_id !== $user->organizer_id) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengubah event ini.');
        }

        $categories = Category::all();
        return view('admin.events.edit', compact('event', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $user = auth()->user();

        // Mencegah panitia meng-update event milik panitia lain
        if (!in_array($user->role, ['admin', 'superadmin']) && $event->organizer_id !== $user->organizer_id) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengubah event ini.');
        }

        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'date'        => 'required|date',
            'location'    => 'required|string|max:255',
            'price'       => 'required|numeric',
            'stock'       => 'required|numeric',
            'poster'      => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('poster')) {
            if ($event->poster_path) {
                Storage::disk('public')->delete($event->poster_path);
            }
            $data['poster_path'] = $request->file('poster')->store('posters', 'public');
        }

        $event->update($data);

        return redirect()->route('admin.events.index')->with('success', 'Rincian data event berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $user = auth()->user();

        // Mencegah panitia menghapus event milik panitia lain
        if (!in_array($user->role, ['admin', 'superadmin']) && $event->organizer_id !== $user->organizer_id) {
            abort(403, 'Anda tidak memiliki hak akses untuk menghapus event ini.');
        }

        if ($event->poster_path) {
            Storage::disk('public')->delete($event->poster_path);
        }

        $event->delete();

        return redirect()->route('admin.events.index')->with('success', 'Data event berhasil dihapus secara permanen.');
    }
}