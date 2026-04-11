<?php

use Illuminate\Support\Facades\Route;

// Halaman Home
Route::get('/', function () {
    return view('welcome');
});

// Halaman Profil
Route::get('/profil', function () {
    return view('profil');
});

// Halaman Katalog
Route::get('/katalog', function () {
    return view('katalog');
});

// Halaman Bantuan
Route::get('/bantuan', function () {
    return view('bantuan');
});