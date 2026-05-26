<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AmikomEventHub - Temukan & Pesan Tiket Event Impianmu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800 min-h-screen">

    <nav class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-slate-100 px-6 py-4">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="bg-indigo-600 text-white p-2.5 rounded-2xl font-black text-xl shadow-lg shadow-indigo-200">
                    AH
                </div>
                <span class="text-xl font-black tracking-tight text-slate-900">AmikomEventHub</span>
            </div>
            <div class="hidden md:flex items-center space-x-8 font-bold text-sm text-slate-600">
                <a href="/" class="text-indigo-600 transition">Jelajahi</a>
                <a href="#kategori" class="hover:text-indigo-600 transition">Kategori</a>
                <a href="#partner" class="hover:text-indigo-600 transition">Tentang Kami</a>
                <a href="/admin" class="px-4 py-2 bg-slate-100 hover:bg-indigo-50 hover:text-indigo-600 rounded-xl transition">Menu Admin</a>
            </div>
        </div>
    </nav>

    <header class="max-w-7xl mx-auto px-6 pt-12 pb-20 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
        <div class="lg:col-span-6 space-y-6">
            <span class="inline-block bg-indigo-50 text-indigo-600 font-bold text-xs uppercase tracking-widest px-4 py-2 rounded-full">
                #1 Event Platform
            </span>
            <h1 class="text-5xl lg:text-6xl font-black text-slate-900 leading-[1.1] tracking-tight">
                Temukan & Pesan <span class="text-indigo-600">Tiket Event</span> Impianmu.
            </h1>
            <p class="text-slate-500 text-lg font-medium leading-relaxed">
                Dari konser musik hingga workshop teknologi, semua ada di genggamanmu. Pesan aman & cepat dengan platform tepercaya kami.
            </p>
            <div class="pt-2">
                <a href="#event-list" class="px-8 py-4 bg-indigo-600 text-white font-bold rounded-2xl shadow-xl shadow-indigo-200 hover:bg-indigo-700 hover:shadow-none transition-all inline-block">
                    Jelajahi Konser
                </a>
            </div>
        </div>

        <div class="lg:col-span-6 relative">
            <div class="absolute inset-0 bg-gradient-to-tr from-indigo-500 to-purple-500 rounded-[3rem] rotate-3 opacity-10 blur-xl"></div>
            <img src="https://images.unsplash.com/photo-1465847899084-d164df4dedc6?auto=format&fit=crop&w=800&q=80" alt="Concert Hero" class="rounded-[2.5rem] shadow-2xl relative z-10 w-full h-[400px] object-cover">
        </div>
    </header>

    {{-- SECTION EVENT --}}
    <main id="event-list" class="max-w-7xl mx-auto px-6 py-12">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12">
            <div>
                <h2 class="text-3xl font-black text-slate-900 tracking-tight">Event Tersedia</h2>
                <p class="text-slate-500 mt-2 font-medium">Pilih konser atau acara favoritmu dan amankan tiketmu sekarang!</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse($events as $event)
                <div class="bg-white rounded-[2rem] overflow-hidden shadow-xl shadow-slate-100 border border-slate-100 flex flex-col justify-between p-4 hover:translate-y-[-4px] transition-all duration-300">
                    <div>
                        <div class="relative rounded-2xl overflow-hidden h-52 bg-slate-100 mb-5">
                            @if($event->poster)
                                <img src="{{ asset('storage/' . $event->poster) }}" alt="{{ $event->title }}" class="w-full h-full object-cover">
                            @else
                                <img src="https://images.unsplash.com/photo-1514525253161-7a46d19cd819?auto=format&fit=crop&w=600&q=80" alt="Default Poster" class="w-full h-full object-cover">
                            @endif
                        </div>

                        <div class="px-2 space-y-2">
                            <h3 class="text-xl font-black text-slate-900 leading-tight line-clamp-2 min-h-[3.5rem]">
                                {{ $event->title }}
                            </h3>
                            <div class="text-slate-500 text-sm font-semibold space-y-1">
                                <p class="flex items-center">
                                    <span class="mr-2">📅</span> {{ \Carbon\Carbon::parse($event->date)->translatedFormat('d M Y') }}
                                </p>
                                <p class="flex items-center">
                                    <span class="mr-2">📍</span> {{ $event->location }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="px-2 pt-5 mt-6 border-t border-slate-50 flex items-center justify-between">
                        <div>
                            <p class="text-slate-400 text-[10px] font-bold uppercase tracking-wider">Harga Tiket</p>
                            <p class="text-indigo-600 font-black text-xl">
                                Rp {{ number_format($event->price, 0, ',', '.') }}
                            </p>
                        </div>
                        <a href="/event/{{ $event->id }}/checkout" class="px-5 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg shadow-indigo-100 transition-all text-sm">
                            Beli Tiket
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white rounded-2xl p-12 text-center border border-dashed border-slate-200">
                    <p class="text-slate-400 font-medium text-lg">Belum ada event yang ditambahkan oleh Admin.</p>
                </div>
            @endforelse
        </div>
    </main>

    {{-- SECTION KATEGORI --}}
    <section id="kategori" class="max-w-7xl mx-auto px-6 py-12">
        <div class="mb-6">
            <h2 class="text-3xl font-black text-slate-900 tracking-tight">Kategori Event</h2>
            <p class="text-slate-500 mt-2 font-medium">Temukan event berdasarkan kategori favoritmu.</p>
        </div>
        <div class="flex flex-wrap gap-3">
            @forelse($categories as $category)
                <span class="px-6 py-3 bg-indigo-50 text-indigo-700 font-bold rounded-full text-sm border border-indigo-100 hover:bg-indigo-100 transition">
                    {{ $category->name }}
                </span>
            @empty
                <p class="text-slate-400 text-sm italic">Belum ada kategori terdaftar.</p>
            @endforelse
        </div>
    </section>

    {{-- SECTION PARTNER --}}
    <section id="partner" class="bg-white border-t border-slate-100 mt-12 py-16 px-6">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-center font-bold text-xs uppercase tracking-widest text-slate-400 mb-10">
                Partner & Sponsor Resmi
            </h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 items-center justify-center">
                @forelse($partners as $partner)
                    <div class="p-6 bg-slate-50 rounded-2xl flex flex-col items-center justify-center border border-slate-100 group hover:border-indigo-100 transition">
                        @if($partner->logo_url)
                            <img src="{{ $partner->logo_url }}" alt="{{ $partner->name }}" class="h-10 object-contain grayscale group-hover:grayscale-0 opacity-70 group-hover:opacity-100 transition duration-300">
                        @else
                            <span class="font-bold text-slate-400 text-center">{{ $partner->name }}</span>
                        @endif
                    </div>
                @empty
                    <p class="text-slate-400 text-sm italic col-span-full text-center">Belum ada partner terdaftar.</p>
                @endforelse
            </div>
        </div>
    </section>

    <footer class="bg-slate-900 text-slate-500 py-8 px-6 text-center text-sm font-medium">
        <p>&copy; 2026 AmikomEventHub. All rights reserved.</p>
    </footer>

</body>

</html>