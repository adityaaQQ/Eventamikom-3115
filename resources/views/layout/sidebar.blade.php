<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - AmikomEventHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 font-sans antialiased">

    <div class="flex min-h-screen">
        
        <aside class="w-64 bg-indigo-900 text-white p-6 flex flex-col gap-4 shadow-xl shrink-0">
            <div class="text-xl font-black mb-6 tracking-wide">AH AmikomEventHub</div>
            
            <nav class="flex flex-col gap-2">
                <span class="text-[10px] font-bold uppercase tracking-wider text-indigo-300 px-4 mb-1">Main Menu</span>
                
                <a href="/admin" class="px-4 py-3 rounded-xl transition font-bold text-sm {{ request()->is('admin') ? 'bg-indigo-800 text-white' : 'hover:bg-indigo-800 text-indigo-100' }}">
                    Dashboard
                </a>
                
                <a href="/adminkelola" class="px-4 py-3 rounded-xl transition font-bold text-sm {{ request()->is('adminkelola*') || request()->is('admin/events*') ? 'bg-indigo-800 text-white' : 'hover:bg-indigo-800 text-indigo-100' }}">
                    Kelola Event
                </a>
                
                <a href="/adminlaporan" class="px-4 py-3 rounded-xl transition font-bold text-sm {{ request()->is('adminlaporan') ? 'bg-indigo-800 text-white' : 'hover:bg-indigo-800 text-indigo-100' }}">
                    Laporan Transaksi
                </a>
                
                <hr class="border-indigo-800 my-2">
                
                <a href="{{ route('admin.categories.index') }}" class="px-4 py-3 rounded-xl transition font-bold text-sm {{ request()->is('admin/categories*') ? 'bg-indigo-800 text-white' : 'hover:bg-indigo-800 text-indigo-100' }}">
                    Kelola Kategori
                </a>
                
                <a href="{{ route('admin.partners.index') }}" class="px-4 py-3 rounded-xl transition font-bold text-sm {{ request()->is('admin/partners*') ? 'bg-indigo-800 text-white' : 'hover:bg-indigo-800 text-indigo-100' }}">
                    Kelola Partner
                </a>
            </nav>
        </aside>

        <div class="flex-1 bg-slate-50 flex flex-col min-h-screen overflow-y-auto">
            
            @yield('content')
            
        </div>

    </div>

</body>
</html>