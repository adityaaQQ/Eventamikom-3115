<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Menampilkan halaman detail event secara dinamis
     * Menggunakan Route Model Binding (Event $event) untuk membaca data dari URL
     */
    public function show(Event $event)
    {
        // Load relasi kategori, panitia/organizer, dan ulasan beserta data user pembuat ulasan
        $event->load(['category', 'organizer', 'reviews.user']);

        // Mengambil data kategori untuk navigasi header/footer jika dibutuhkan
        $categories = Category::all();

        // Mengirimkan data variabel ke view event-detail.blade.php
        return view('event-detail', compact('categories', 'event'));
    }

    /**
     * Menampilkan halaman checkout untuk event terkait
     */
    public function checkout(Event $event)
    {
        // Load relasi organizer dan category untuk informasi saat pembayaran
        $event->load(['category', 'organizer']);

        $categories = Category::all();
        
        return view('checkout', compact('categories', 'event'));
    }

    /**
     * Menampilkan halaman tiket milik user
     */
    public function ticket()
    {
        return view('my-ticket'); 
    }
}