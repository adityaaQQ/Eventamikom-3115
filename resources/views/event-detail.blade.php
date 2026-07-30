<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $event->title }} - AmikomEventHub</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen">

    <!-- NAVBAR -->
    <nav class="bg-white border-b border-slate-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="/" class="flex items-center gap-2">
                <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white font-black">AH</div>
                <span class="font-black text-xl text-slate-900">AmikomEventHub</span>
            </a>
            <div class="flex items-center gap-6 text-sm font-bold text-slate-600">
                <a href="/" class="hover:text-indigo-600 transition">Jelajahi</a>
                <a href="/#events" class="hover:text-indigo-600 transition">Kategori</a>
                @auth
                    <span class="text-indigo-600 font-extrabold">Hai, {{ Auth::user()->name }}</span>
                @else
                    <a href="{{ route('auth.google') }}" class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition shadow-md shadow-indigo-100">Login</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- CONTENT DETAIL EVENT -->
    <div class="max-w-7xl mx-auto px-6 py-10">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            
            <!-- KIRI: POSTER & DESKRIPSI EVENT -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Poster Event -->
                <div class="w-full h-[400px] bg-slate-200 rounded-[2.5rem] overflow-hidden shadow-sm border border-slate-100 flex items-center justify-center">
                    @if($event->poster_path)
                        <img src="{{ asset('storage/' . $event->poster_path) }}" alt="{{ $event->title }}" class="w-full h-full object-cover">
                    @else
                        <span class="text-3xl font-black text-slate-400">No Poster</span>
                    @endif
                </div>

                <!-- Info Header Event -->
                <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm">
                    <span class="px-4 py-1.5 bg-indigo-50 text-indigo-600 rounded-full text-xs font-black uppercase tracking-wider">
                        {{ $event->category->name ?? 'EVENT' }}
                    </span>
                    <h1 class="text-3xl font-black text-slate-900 mt-4 mb-2">{{ $event->title }}</h1>
                    <p class="text-slate-400 text-sm font-medium flex items-center gap-2 mb-6">
                        📅 {{ \Carbon\Carbon::parse($event->date)->format('d F Y, H:i') }} WIB • 📍 {{ $event->location }}
                    </p>

                    <h4 class="font-black text-slate-800 text-base mb-2">Deskripsi Acara</h4>
                    <p class="text-slate-600 leading-relaxed text-sm">
                        {{ $event->description ?? 'Tidak ada deskripsi untuk acara ini.' }}
                    </p>
                </div>
            </div>

            <!-- KANAN: CARD CHECKOUT & HARGA -->
            <div class="lg:col-span-1">
                <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm sticky top-28 space-y-6">
                    <h3 class="text-lg font-black text-slate-900">Beli Tiket</h3>
                    
                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-wider mb-1">Harga Tiket</p>
                        <p class="text-3xl font-black text-indigo-600">Rp {{ number_format($event->price, 0, ',', '.') }}</p>
                        <p class="text-xs text-slate-500 font-bold mt-2">Sisa Stok: <span class="text-slate-800">{{ $event->stock }} tiket</span></p>
                    </div>

                    <!-- TOMBOL CHECKOUT -->
                    @if($event->stock > 0)
                        <a href="{{ route('checkout.create', $event->id) }}" 
                           class="w-full block text-center py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-black rounded-2xl shadow-xl shadow-indigo-200 transition">
                            Checkout Tiket Sekarang
                        </a>
                    @else
                        <button disabled class="w-full py-4 bg-slate-200 text-slate-400 font-black rounded-2xl cursor-not-allowed">
                            Tiket Habis
                        </button>
                    @endif
                </div>
            </div>

        </div>

        <!-- SECTION ULASAN & RATING -->
        <div class="mt-12 bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm">
            <div class="flex items-center justify-between mb-8 pb-6 border-b border-slate-100">
                <div>
                    <h3 class="text-2xl font-black text-slate-900">Ulasan & Testimoni Peserta</h3>
                    <p class="text-slate-400 text-sm font-medium mt-1">Rekam jejak penilaian dari acara sebelumnya</p>
                </div>
                <div class="flex items-center gap-3 bg-amber-50 px-5 py-3 rounded-2xl border border-amber-100">
                    <span class="text-amber-500 text-3xl font-black">★ {{ $event->averageRating() }}</span>
                    <div class="text-left">
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Rata-rata</p>
                        <p class="text-xs font-bold text-slate-700">{{ $event->reviews->count() }} ulasan</p>
                    </div>
                </div>
            </div>

            {{-- Alert --}}
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-100 text-emerald-800 rounded-2xl font-bold text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 bg-rose-100 text-rose-800 rounded-2xl font-bold text-sm">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Form Ulasan --}}
            @auth
                <form action="{{ route('reviews.store', $event->id) }}" method="POST" class="mb-10 p-6 bg-slate-50 rounded-2xl border border-slate-100">
                    @csrf
                    <h4 class="font-black text-slate-800 mb-4 text-base">Tulis Ulasan Anda</h4>
                    
                    <div class="mb-4">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Rating Bintang</label>
                        <select name="rating" class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500 outline-none transition" required>
                            <option value="5">⭐⭐⭐⭐⭐ (5/5 - Sangat Memuaskan)</option>
                            <option value="4">⭐⭐⭐⭐ (4/5 - Bagus)</option>
                            <option value="3">⭐⭐⭐ (3/5 - Cukup)</option>
                            <option value="2">⭐⭐ (2/5 - Kurang)</option>
                            <option value="1">⭐ (1/5 - Buruk)</option>
                        </select>
                    </div>

                    <div class="mb-5">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Testimoni / Kesan Acara</label>
                        <textarea name="comment" rows="3" class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl font-medium text-slate-700 focus:ring-2 focus:ring-indigo-500 outline-none transition" placeholder="Bagikan pengalaman Anda mengikuti acara ini..." required></textarea>
                    </div>

                    <button type="submit" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg shadow-indigo-100 transition">
                        Kirim Ulasan
                    </button>
                </form>
            @else
                <div class="p-5 bg-indigo-50 border border-indigo-100 rounded-2xl mb-10 flex items-center justify-between">
                    <span class="text-sm font-bold text-indigo-950">Ingin memberikan ulasan untuk acara ini?</span>
                    <a href="{{ route('auth.google') }}" class="px-5 py-2.5 bg-indigo-600 text-white text-xs font-bold rounded-xl hover:bg-indigo-700 transition">
                        Login via Google
                    </a>
                </div>
            @endauth

            {{-- Daftar Ulasan --}}
            <div class="space-y-4">
                @forelse($event->reviews as $review)
                    <div class="p-5 bg-slate-50 rounded-2xl border border-slate-100">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 bg-indigo-100 text-indigo-700 rounded-full flex items-center justify-center font-black text-xs">
                                    {{ strtoupper(substr($review->user->name, 0, 2)) }}
                                </div>
                                <div>
                                    <h5 class="font-bold text-slate-800 text-sm">{{ $review->user->name }}</h5>
                                    <span class="text-[11px] text-slate-400 font-medium">{{ $review->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                            <div class="text-amber-400 text-sm font-black">
                                {{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}
                            </div>
                        </div>
                        <p class="text-slate-600 text-sm leading-relaxed mt-2 pl-12">{{ $review->comment }}</p>
                    </div>
                @empty
                    <div class="text-center py-10 text-slate-400 font-medium text-sm">
                        Belum ada ulasan untuk acara ini.
                    </div>
                @endforelse
            </div>
        </div>

    </div>

</body>
</html>