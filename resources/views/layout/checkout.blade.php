<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - {{ $event->title ?? 'Detail Event' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-slate-50 min-h-screen py-10 px-4">

    <div class="max-w-2xl mx-auto space-y-6">

        <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100">
            <h2 class="text-xl font-bold text-slate-800 mb-6">Pesanan Anda</h2>
            
            <div class="flex items-start gap-4 pb-6 border-b border-slate-100">
                <div class="w-20 h-20 bg-slate-100 rounded-2xl overflow-hidden flex-shrink-0 border border-slate-100">
                    <img src="{{ $event->image ? asset('storage/' . $event->image) : 'https://images.unsplash.com/photo-1514525253161-7a46d19cd819?q=80&w=200&auto=format&fit=crop' }}" 
                         class="w-full h-full object-cover" alt="Event Thumbnail">
                </div>
                <div>
                    <h3 class="font-black text-lg text-slate-900 leading-tight mb-1">
                        {{ $event->title ?? 'Nama Event' }}
                    </h3>
                    <p class="text-sm text-slate-500 font-medium">
                        {{ isset($event->date) ? \Carbon\Carbon::parse($event->date)->translatedFormat('d M Y') : 'Tanggal Event' }} • {{ $event->location ?? 'Amikom Yogyakarta' }}
                    </p>
                    <p class="text-sm text-indigo-600 font-bold mt-2">
                        1x Rp {{ number_format($event->price ?? 0, 0, ',', '.') }}
                    </p>
                </div>
            </div>

            <div class="pt-6 space-y-4 text-sm font-medium text-slate-500">
                <div class="flex justify-between">
                    <span>Harga Tiket</span>
                    <span class="text-slate-800">Rp {{ number_format($event->price ?? 0, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Biaya Layanan</span>
                    <span class="text-slate-800">Rp 5.000</span>
                </div>
                <div class="flex justify-between items-center pt-4 border-t border-slate-100">
                    <span class="text-base font-bold text-slate-800">Total Bayar</span>
                    <span class="text-2xl font-black text-indigo-600">
                        Rp {{ number_format(($event->price ?? 0) + 5000, 0, ',', '.') }}
                    </span>
                </div>
            </div>
        </div>

        <form action="/checkout/proses" method="POST" class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100">
            @csrf
            
            <input type="hidden" name="event_id" value="{{ $event->id }}">

            <div class="flex items-center gap-2 mb-6">
                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <h2 class="text-xl font-bold text-slate-800">Data Pemesan</h2>
            </div>

            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Nama Lengkap</label>
                    <input type="text" name="nama" required placeholder="Masukkan nama sesuai kartu identitas"
                        class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none focus:border-indigo-500 focus:bg-white font-medium text-slate-800 transition-all placeholder:text-slate-400">
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Alamat Email</label>
                    <input type="email" name="email" required placeholder="contoh@email.com"
                        class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none focus:border-indigo-500 focus:bg-white font-medium text-slate-800 transition-all placeholder:text-slate-400">
                    <p class="text-xs text-slate-400 font-medium mt-1.5 ml-1">E-Ticket resmi Anda akan dikirimkan ke alamat email ini.</p>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Nomor Telepon / WhatsApp</label>
                    <input type="text" name="telepon" required placeholder="Contoh: 08123456789"
                        class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none focus:border-indigo-500 focus:bg-white font-medium text-slate-800 transition-all placeholder:text-slate-400">
                </div>
            </div>

            <div class="mt-8">
                <button type="submit" class="w-full py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-2xl shadow-lg shadow-indigo-100 transition-all text-center text-base tracking-wide">
                    Beli Sekarang
                </button>
            </div>
        </form>

    </div>

</body>

</html>