<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Event;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Admin Utama
        User::create([
            'name' => 'Admin Amikom',
            'email' => 'admin@amikom.ac.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // 2. Insert 4 Kategori Event
        $catSeminar = Category::create(['name' => 'Seminar IT', 'slug' => 'seminar-it']);
        $catMusic = Category::create(['name' => 'Entertainment', 'slug' => 'entertainment']);
        $catSport = Category::create(['name' => 'Sport', 'slug' => 'sport']);
        $catWorkshop = Category::create(['name' => 'Workshop', 'slug' => 'workshop']);

        // 3. Insert 7 Sampel Events
        
        // --- Kategori Seminar IT ---
        Event::create([
            'category_id' => $catSeminar->id,
            'title' => 'AI & FUTURE TECH SUMMIT 2026',
            'description' => 'Jelajahi tren terkini dalam kecerdasan buatan bersama para ahli.',
            'date' => '2026-05-01 13:00:00',
            'location' => 'Cinema Unit 6',
            'price' => 50000, 'stock' => 100, 'poster_path' => 'posters/event-1.png',
        ]);

        Event::create([
            'category_id' => $catSeminar->id,
            'title' => 'Hackaton Amikom 2026',
            'description' => 'Ayo asah skill coding kamu dan ciptakan solusi inovatif.',
            'date' => '2026-05-15 08:00:00',
            'location' => 'Inkubator Amikom',
            'price' => 0, 'stock' => 50, 'poster_path' => 'posters/event-2.png',
        ]);

        // --- Kategori Entertainment ---
        Event::create([
            'category_id' => $catMusic->id,
            'title' => 'Jazz Night 2025',
            'description' => 'Nikmati malam yang indah dengan alunan musik jazz yang merdu.',
            'date' => '2026-05-10 19:00:00',
            'location' => 'Amikom Baru',
            'price' => 75000, 'stock' => 150, 'poster_path' => 'posters/event-3.png',
        ]);

        Event::create([
            'category_id' => $catMusic->id,
            'title' => 'Amikom Soundfest',
            'description' => 'Konser musik spektakuler menghadirkan artis nasional.',
            'date' => '2026-08-25 18:30:00',
            'location' => 'Halaman Parkir Utara',
            'price' => 150000, 'stock' => 1000, 'poster_path' => 'posters/event-4.png',
        ]);

        // --- Kategori Sport ---
        Event::create([
            'category_id' => $catSport->id,
            'title' => 'E-Sport Championship',
            'description' => 'Buktikan tim kamu yang terkuat di turnamen Mobile Legends.',
            'date' => '2026-06-20 10:00:00',
            'location' => 'Basement Unit 3',
            'price' => 35000, 'stock' => 64, 'poster_path' => 'posters/event-5.png',
        ]);

        // --- Kategori Workshop ---
        Event::create([
            'category_id' => $catWorkshop->id,
            'title' => 'UI/UX Design for Pro',
            'description' => 'Belajar mendesain aplikasi yang user-friendly dari ahlinya.',
            'date' => '2026-07-05 09:00:00',
            'location' => 'Lab Komputer 4',
            'price' => 60000, 'stock' => 30, 'poster_path' => 'posters/event-6.png',
        ]);

        Event::create([
            'category_id' => $catWorkshop->id,
            'title' => 'Digital Marketing Mastery',
            'description' => 'Strategi jitu meningkatkan penjualan di era digital.',
            'date' => '2026-07-15 13:00:00',
            'location' => 'Ruang Seminar Gedung 5',
            'price' => 45000, 'stock' => 50, 'poster_path' => 'posters/event-7.png',
        ]);
    }
}