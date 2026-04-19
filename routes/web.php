<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('layout.index'); 
});

Route::get('/detail', function () {
    return view('layout.event_detail'); 
});

Route::get('/checkout', function () {
    return view('layout.checkout');
});
Route::get('/ticket', function () {
    return view('layout.ticket'); 
});


Route::get('/admin', function () {
    return view('admin.dashboard'); 
});

Route::get('/adminkelola', function () {
    return view('admin.event'); 
});

Route::get('/adminlaporan', function () {
    return view('admin.transaction'); 
});