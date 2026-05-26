@extends('layout.sidebar')

@section('content')
<div class="p-10">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-black text-slate-800 tracking-tight">Kelola Event</h1>
            <p class="text-sm text-slate-500 mt-1">Manajemen pembuatan poster, nama, harga, dan tanggal event.</p>
        </div>
        <a href="/adminkelola/create" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-6 py-3 rounded-2xl shadow-lg shadow-indigo-600/20 transition text-sm flex items-center gap-2">
            + Tambah Event Baru
        </a>
    </div>

    @if(session('success'))
    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl text-sm font-semibold">
        {{ session('success') }}
    </div>
    @endif

    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/75 border-b border-slate-100 text-slate-500 text-xs font-bold uppercase tracking-wider">
                    <th class="px-6 py-4 text-center w-16">No</th>
                    <th class="px-6 py-4">Poster</th>
                    <th class="px-6 py-4">Nama Event</th>
                    <th class="px-6 py-4">Tanggal</th>
                    <th class="px-6 py-4">Harga Tiket</th>
                    <th class="px-6 py-4 text-center w-36">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm font-medium text-slate-700">
                @forelse($events as $index => $event)
                <tr class="hover:bg-slate-50/50 transition">
                    <td class="px-6 py-4 text-center text-slate-400 font-normal">
                        {{ $index + 1 }}
                    </td>
                    
                    <td class="px-6 py-4">
                        @if($event->poster)
                            <img src="{{ asset('storage/' . $event->poster) }}" class="w-16 h-20 object-cover rounded-xl shadow-sm border border-slate-100" alt="Poster">
                        @else
                            <div class="w-16 h-20 bg-slate-100 rounded-xl flex flex-col items-center justify-center text-[10px] text-slate-400 font-semibold border border-dashed border-slate-200">
                                <span>No Image</span>
                            </div>
                        @endif
                    </td>
                    
                    <td class="px-6 py-4 text-slate-900 font-bold">
                        {{ $event->title }}
                    </td>
                    
                    <td class="px-6 py-4 text-slate-500 font-normal">
                        {{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}
                    </td>
                    
                    <td class="px-6 py-4 text-indigo-600 font-bold">
                        @if($event->price == 0)
                            <span class="text-emerald-600 font-bold bg-emerald-50 px-2.5 py-1 rounded-lg text-xs">Gratis</span>
                        @else
                            Rp {{ number_format($event->price, 0, ',', '.') }}
                        @endif
                    </td>
                    
                    <td class="px-6 py-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <a href="/adminkelola/{{ $event->id }}/edit" class="bg-amber-50 hover:bg-amber-100 text-amber-700 font-bold px-4 py-2 rounded-xl transition text-xs">
                                Edit
                            </a>
                            <form action="/adminkelola/{{ $event->id }}/destroy" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus event ini?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold px-4 py-2 rounded-xl transition text-xs">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-slate-400 font-normal">
                        Belum ada data event yang ditambahkan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection