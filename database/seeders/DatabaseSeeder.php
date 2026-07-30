<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Event;
use App\Models\Organizer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Insert Sample Organizers (Panitia / HIMA)
        $himaIF = Organizer::create([
            'name' => 'HIMA Informatika',
            'slug' => 'hima-informatika',
            'status' => 'approved',
        ]);

        $himaMusik = Organizer::create([
            'name' => 'UKM Musik Amikom',
            'slug' => 'ukm-musik-amikom',
            'status' => 'approved',
        ]);

        // 2. Insert Akun Superadmin & Panitia (Organizer)
        User::create([
            'name' => 'Superadmin Amikom',
            'email' => 'admin@amikom.ac.id',
            'password' => bcrypt('password'),
            'role' => 'superadmin',
        ]);

        User::create([
            'name' => 'Panitia HIMA IF',
            'email' => 'himaif@amikom.ac.id',
            'password' => bcrypt('password'),
            'role' => 'organizer',
            'organizer_id' => $himaIF->id,
        ]);

        User::create([
            'name' => 'Panitia UKM Musik',
            'email' => 'ukmmusik@amikom.ac.id',
            'password' => bcrypt('password'),
            'role' => 'organizer',
            'organizer_id' => $himaMusik->id,
        ]);

        // 3. Insert Kategori Event
        $categoryIT = Category::firstOrCreate([
            'name' => 'Seminar IT',
            'slug' => 'seminar-it',
        ]);

        $categoryEnt = Category::firstOrCreate([
            'name' => 'Entertainment',
            'slug' => 'entertainment',
        ]);

        // 4. Insert Sampel Events (Dikaitkan ke Organizer Masing-Masing)
        Event::create([
            'category_id'  => $categoryEnt->id,
            'organizer_id' => $himaMusik->id,
            'title'        => 'Jazz Night 2026',
            'description'  => 'Nikmati malam yang indah dengan alunan musik jazz yang merdu.',
            'date'         => '2026-05-10 19:00:00',
            'location'     => 'Amikom Baru',
            'price'        => 50000,
            'stock'        => 100,
            'poster_path'  => 'posters/event-1.png',
        ]);

        Event::create([
            'category_id'  => $categoryIT->id,
            'organizer_id' => $himaIF->id,
            'title'        => 'Hackathon - Unleash Your Inner Developer',
            'description'  => 'Ayo asah skill coding kamu dan ciptakan solusi inovatif untuk tantangan masa depan!',
            'date'         => '2026-05-05 10:00:00',
            'location'     => 'Inkubator Amikom',
            'price'        => 50000,
            'stock'        => 100,
            'poster_path'  => 'posters/event-2.png',
        ]);

        Event::create([
            'category_id'  => $categoryIT->id,
            'organizer_id' => $himaIF->id,
            'title'        => 'AI & FUTURE TECH SUMMIT 2026',
            'description'  => 'Jelajahi tren terkini dalam kecerdasan buatan dan teknologi masa depan bersama para ahli di bidangnya.',
            'date'         => '2026-05-01 13:00:00',
            'location'     => 'Cinema Unit 6',
            'price'        => 50000,
            'stock'        => 100,
            'poster_path'  => 'posters/event-3.png',
        ]);
    }
}