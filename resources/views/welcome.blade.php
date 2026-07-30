@extends('layouts.app')

@section('content')

    <section class="max-w-7xl mx-auto px-6 py-20 flex flex-col md:flex-row items-center gap-12">
        <div class="flex-1 space-y-8">
            <span class="inline-block px-4 py-1.5 bg-indigo-100 text-indigo-700 rounded-full text-sm font-bold uppercase tracking-wider">
                #1 Event Platform
            </span>
            <h1 class="text-5xl md:text-7xl font-extrabold leading-tight">
                Temukan & Pesan <span class="text-indigo-600">Tiket Event</span> Impianmu.
            </h1>
            <p class="text-lg text-slate-500 max-w-lg leading-relaxed">
                Dari konser musik hingga workshop teknologi, semua ada di genggamanmu. Pesan aman & cepat dengan Midtrans.
            </p>
            <div class="flex gap-4">
                <a href="#events" class="px-8 py-4 bg-indigo-600 text-white rounded-2xl font-bold text-lg shadow-xl shadow-indigo-200 hover:scale-105 transition-transform">
                    Mulai Jelajah
                </a>
                <a href="#" class="px-8 py-4 border-2 border-slate-200 rounded-2xl font-bold text-lg hover:border-indigo-600 hover:text-indigo-600 transition">
                    Cara Pesan
                </a>
            </div>
        </div>
        
        <div class="flex-1 relative">
            <div class="absolute -top-10 -left-10 w-64 h-64 bg-indigo-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
            <div class="absolute -bottom-10 -right-10 w-64 h-64 bg-purple-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
            
            <img src="{{ asset('assets/concert.png') }}" 
                 onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1465847899084-d164df4dedc6?q=80&w=600&auto=format&fit=crop';" 
                 alt="Concert Hero" 
                 class="rounded-[2rem] shadow-2xl relative z-10 w-full object-cover aspect-[4/5] object-center">

            <div class="absolute -bottom-6 -left-6 glass p-6 rounded-2xl shadow-xl z-20 border border-white bg-white/80 backdrop-blur-md">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-green-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 font-bold uppercase">Terverifikasi</p>
                        <p class="font-bold">Pembayaran Aman via Midtrans</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="events" class="max-w-7xl mx-auto px-6 py-20">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-12 gap-8">
            <div>
                <h2 class="text-3xl font-extrabold mb-2 text-slate-900">Event Terdekat</h2>
                <p class="text-slate-500 font-medium">Jangan sampai ketinggalan acara seru minggu ini!</p>
            </div>

            <div class="flex flex-wrap gap-3">
                <a href="{{ url('/') }}" 
                   class="px-6 py-2.5 rounded-xl font-bold text-sm transition-all duration-200 {{ !request('category') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-100' : 'bg-white border border-slate-200 text-slate-600 hover:border-indigo-600 hover:text-indigo-600' }}">
                   Semua Kategori
                </a>
                
                @foreach($categories as $cat)
                    <a href="{{ url('/?category=' . $cat->slug) }}" 
                       class="px-6 py-2.5 rounded-xl font-bold text-sm transition-all duration-200 {{ request('category') == $cat->slug ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-100' : 'bg-indigo-50 text-indigo-700 hover:bg-indigo-100' }}">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($events as $event)
            <div class="group bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-2xl transition-all duration-300 overflow-hidden">
                <div class="relative overflow-hidden aspect-[3/4]">
                    
                    @if($event->poster_path)
                        <img src="{{ asset('storage/' . $event->poster_path) }}" alt="{{ $event->title }}"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    @else
                        <img src="https://placehold.co/400x600?text=No+Poster" alt="{{ $event->title }}"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    @endif

                    <div class="absolute top-4 left-4 px-3 py-1 bg-white/95 backdrop-blur rounded-lg text-xs font-bold uppercase text-indigo-600 shadow-sm">
                        {{ $event->category->name ?? 'Uncategorized' }}
                    </div>
                </div>
                
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-3 group-hover:text-indigo-600 transition min-h-[3.5rem] line-clamp-2">
                        {{ $event->title }}
                    </h3>
                    
                    <div class="flex items-center gap-2 text-slate-500 text-sm mb-6">
                        <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>{{ \Carbon\Carbon::parse($event->date)->format('d M Y, H:i') }} WIB</span>
                    </div>

                    <div class="flex justify-between items-center pt-5 border-t border-slate-50">
                        <div class="flex flex-col">
                            <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Mulai Dari</span>
                            <span class="text-xl font-black text-indigo-600">Rp {{ number_format($event->price, 0, ',', '.') }}</span>
                        </div>
                        <a href="{{ route('events.show', $event->id) }}" class="px-5 py-2.5 bg-indigo-50 text-indigo-600 rounded-xl font-bold hover:bg-indigo-600 hover:text-white transition-colors duration-300">
    Lihat Detail
</a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-20 bg-slate-50 rounded-3xl border-2 border-dashed border-slate-200">
                <p class="text-slate-500 font-bold text-lg">Belum ada event tersedia untuk kategori ini.</p>
            </div>
            @endforelse
        </div>
    </section>

@endsection