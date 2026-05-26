<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\EventController;
use App\Models\Event;
use App\Models\Partner;
use App\Models\Transaksi;
use App\Models\Category;
use Illuminate\Http\Request;

Route::get('/', function () {
    $events = Event::latest()->get();
    $partners = Partner::latest()->get();
    $categories = Category::all();
    return view('layout.index', compact('events', 'partners', 'categories'));
});

Route::get('/event/{id}', function ($id) {
    $event = Event::findOrFail($id);
    return view('layout.event_detail', compact('event'));
});

Route::get('/event/{id}/checkout', function ($id) {
    $event = Event::findOrFail($id);
    return view('layout.checkout', compact('event'));
});

Route::post('/checkout/proses', function (Request $request) {
    $request->validate([
        'event_id' => 'required',
        'nama'     => 'required|string|max:255',
        'email'    => 'required|email',
        'telepon'  => 'required',
    ]);

    $event = Event::findOrFail($request->event_id);

    $transaksi = new Transaksi();
    $transaksi->event_id    = $event->id;
    $transaksi->user_id     = 1;
    $transaksi->pembeli     = $request->nama;
    $transaksi->email       = $request->email;
    $transaksi->telepon     = $request->telepon;
    $transaksi->quantity    = 1;
    $transaksi->total_price = $event->price + 5000;
    $transaksi->status      = 'success';
    $transaksi->order_id    = 'TRX-' . rand(10000, 99999);
    $transaksi->save();

    return redirect('/tiket-sukses')->with('transaksi_id', $transaksi->id);
});

Route::get('/tiket-sukses', function () {
    $transaksi_id = session('transaksi_id');

    if (!$transaksi_id) {
        return redirect('/');
    }

    $transaksi = Transaksi::findOrFail($transaksi_id);
    $event = Event::findOrFail($transaksi->event_id);

    return view('layout.ticket', compact('transaksi', 'event'));
});
Route::get('/adminkelola', [EventController::class, 'index'])->name('admin.events.index');
Route::get('/adminkelola/create', [EventController::class, 'create'])->name('admin.events.create');
Route::post('/adminkelola/store', [EventController::class, 'store'])->name('admin.events.store');
Route::get('/adminkelola/{id}/edit', [EventController::class, 'edit'])->name('admin.events.edit');
Route::put('/adminkelola/{id}/update', [EventController::class, 'update'])->name('admin.events.update');
Route::delete('/adminkelola/{id}/destroy', [EventController::class, 'destroy'])->name('admin.events.destroy');
Route::get('/admin', function () {
    $transaksi_terakhir = Transaksi::with('event')
        ->latest()
        ->take(5)
        ->get();

    $total_pendapatan = Transaksi::where('status', 'success')->sum('total_price');
    $total_tiket      = Transaksi::count();
    $total_event      = Event::count();
    $total_pending    = Transaksi::where('status', 'pending')->count();

    return view('admin.dashboard', compact(
        'transaksi_terakhir',
        'total_pendapatan',
        'total_tiket',
        'total_event',
        'total_pending'
    ));
});

Route::get('/adminlaporan', function () {
    return view('admin.transaction');
});
Route::resource('admin/categories', App\Http\Controllers\Admin\CategoryController::class)->names('admin.categories');
Route::resource('admin/partners', App\Http\Controllers\Admin\PartnerController::class)->names('admin.partners');