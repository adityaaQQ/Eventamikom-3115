@extends('layouts.app') {{-- 1. Sesuaikan dengan nama file layout utama kamu (misal: layouts.app atau layouts.main) --}}

@section('content') {{-- 2. Ini pembuka section yang tadi hilang --}}
<main class="min-h-screen flex items-center justify-center bg-slate-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full text-center bg-white p-8 rounded-2xl shadow-sm">
        
        <h2 class="text-3xl font-black mb-4">Terima Kasih!</h2>
        <p class="text-slate-500 mb-8 leading-relaxed">
            Pembayaran untuk pesanan <strong>{{ $transaction->order_id }}</strong> sedang diproses atau telah berhasil.
            E-Ticket akan dikirim ke email Anda (<strong>{{ $transaction->customer_email }}</strong>) setelah pembayaran terkonfirmasi lunas.
        </p>
        <a href="{{ route('home') }}" class="inline-block px-8 py-4 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition">
            Kembali ke Beranda
        </a>

    </div>
</main>
@endsection {{-- 3. Sekarang ini sudah aman karena ada pasangannya di atas --}}