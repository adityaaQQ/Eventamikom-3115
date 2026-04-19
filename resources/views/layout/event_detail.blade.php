@extends('layout.nav') @section('content')

<div class="max-w-7xl mx-auto px-6 py-20">
    <div class="flex flex-col md:flex-row gap-12">
        <div class="flex-1">
            <img src="{{ asset('assets/concert.png') }}" class="w-full rounded-[2rem] shadow-2xl" alt="Event">
        </div>

        <div class="flex-1 space-y-6">
            <span class="px-4 py-1.5 bg-indigo-100 text-indigo-700 rounded-full text-sm font-bold uppercase">
                Musik
            </span>
            <h1 class="text-4xl font-extrabold">Jazz Night 2024: A Celebration</h1>
            <p class="text-slate-500 leading-relaxed">
                Nikmati malam yang indah dengan alunan musik Jazz dari musisi ternama. 
                Acara ini akan diselenggarakan dengan protokol kesehatan yang ketat.
            </p>
            
            <div class="p-6 bg-slate-50 rounded-2xl border border-slate-100">
                <p class="text-sm text-slate-400 font-bold uppercase mb-2">Harga Tiket</p>
                <h2 class="text-3xl font-black text-indigo-600">Rp 150.000</h2>
            </div>

            <a href="/checkout" class="block text-center px-8 py-4 bg-indigo-600 text-white rounded-2xl font-bold text-lg shadow-lg hover:bg-indigo-700 transition">
                Beli Tiket Sekarang
            </a>
        </div>
    </div>
</div>

@endsection