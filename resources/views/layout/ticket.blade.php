<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Ticket - AmikomEventHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-indigo-600 min-h-screen flex items-center justify-center p-6">

    <div class="max-w-md w-full bg-white rounded-[2.5rem] shadow-2xl overflow-hidden relative">
        
        <div class="bg-indigo-50/50 px-8 pt-10 pb-6 text-center border-b-2 border-dashed border-slate-100 relative">
            <div class="absolute -bottom-3 -left-3 w-6 h-6 bg-indigo-600 rounded-full"></div>
            <div class="absolute -bottom-3 -right-3 w-6 h-6 bg-indigo-600 rounded-full"></div>
            
            <p class="text-indigo-600 text-xs font-bold tracking-widest uppercase mb-2">E-Ticket Resmi</p>
            <h2 class="text-2xl font-black text-slate-900 leading-tight">
                {{ $event->title ?? 'Nama Event' }}
            </h2>
        </div>

        <div class="p-8">
            <div class="grid grid-cols-2 gap-y-6 gap-x-4 mb-8 text-sm">
                <div>
                    <p class="text-slate-400 font-bold text-[10px] uppercase tracking-wider mb-1">Nama Pembeli</p>
                    <p class="font-black text-slate-800 text-base">
                        {{ $transaksi->pembeli ?? 'Nama Pembeli' }}
                    </p>
                </div>
                <div>
                    <p class="text-slate-400 font-bold text-[10px] uppercase tracking-wider mb-1">Tanggal & Waktu</p>
                    <p class="font-black text-slate-800 text-base">
                        {{ isset($event->date) ? \Carbon\Carbon::parse($event->date)->translatedFormat('d M Y') : 'Tanggal Event' }}
                    </p>
                </div>
                <div>
                    <p class="text-slate-400 font-bold text-[10px] uppercase tracking-wider mb-1">Order ID</p>
                    <p class="font-black text-slate-800 text-base uppercase">
                        {{ $transaksi->order_id ?? 'TRX-XXXXX' }}
                    </p>
                </div>
                <div>
                    <p class="text-slate-400 font-bold text-[10px] uppercase tracking-wider mb-1">Lokasi</p>
                    <p class="font-black text-slate-800 text-base">
                        {{ $event->location ?? 'Amikom Yogyakarta' }}
                    </p>
                </div>
            </div>

            <div class="bg-slate-50 rounded-3xl p-6 flex flex-col items-center justify-center border border-slate-100 mb-6">
                <p class="text-slate-400 text-[10px] font-bold uppercase tracking-wider mb-4">Scan QR Untuk Check-In</p>
                
                <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100 mb-4">
                    <div class="w-32 h-32 bg-slate-900 flex flex-wrap p-2 gap-2 justify-center items-center rounded-lg">
                        <div class="w-8 h-8 bg-white rounded"></div>
                        <div class="w-8 h-8 bg-slate-900 rounded"></div>
                        <div class="w-8 h-8 bg-white rounded"></div>
                        <div class="w-8 h-8 bg-slate-900 rounded"></div>
                        <div class="w-8 h-8 bg-white rounded"></div>
                        <div class="w-8 h-8 bg-slate-900 rounded"></div>
                        <div class="w-8 h-8 bg-white rounded"></div>
                        <div class="w-8 h-8 bg-slate-900 rounded"></div>
                        <div class="w-8 h-8 bg-white rounded"></div>
                    </div>
                </div>

                <p class="font-mono text-xs font-bold text-slate-600 tracking-widest">
                    TKT-00{{ $transaksi->id ?? rand(100, 999) }}
                </p>
            </div>

            <div class="space-y-3">
                <button onclick="window.print()" class="w-full py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg shadow-indigo-100 transition-all text-center block text-sm">
                    Cetak / Simpan PDF
                </button>
                <a href="/" class="w-full py-4 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl transition-all text-center block text-sm">
                    Kembali ke Beranda
                </a>
            </div>
        </div>

    </div>

</body>

</html>