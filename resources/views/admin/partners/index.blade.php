@extends('layout.sidebar')

@section('content')
<main class="p-10">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-black text-slate-800">Kelola Partner</h1>
            <p class="text-slate-500 font-medium text-sm">Daftar partner yang mendukung AmikomEventHub.</p>
        </div>
        <a href="{{ route('admin.partners.create') }}" class="px-5 py-3 bg-indigo-600 text-white rounded-2xl font-bold hover:bg-indigo-700 shadow-lg transition text-sm">
            + Tambah Partner
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-2xl text-sm font-semibold">
            {{ session('success') }}
        </div>
    @endif

    {{-- Search Form --}}
    <form method="GET" action="{{ route('admin.partners.index') }}" class="mb-6">
        <div class="flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Cari nama partner..."
                class="w-full px-5 py-3 rounded-2xl border border-slate-200 text-sm font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-300">
            <button type="submit" class="px-5 py-3 bg-indigo-600 text-white rounded-2xl font-bold text-sm hover:bg-indigo-700 transition">Cari</button>
            @if(request('search'))
                <a href="{{ route('admin.partners.index') }}" class="px-5 py-3 bg-slate-100 text-slate-600 rounded-2xl font-bold text-sm hover:bg-slate-200 transition">Reset</a>
            @endif
        </div>
    </form>

    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                    <tr>
                        <th class="px-8 py-4">No</th>
                        <th class="px-8 py-4">Logo</th>
                        <th class="px-8 py-4">Nama Partner</th>
                        <th class="px-8 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y border-t text-sm text-slate-700 font-medium">
                    @forelse($partners as $index => $partner)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-8 py-5 font-bold text-slate-900">{{ $index + 1 }}</td>
                            <td class="px-8 py-5">
                                @if($partner->logo_url)
                                    <img src="{{ $partner->logo_url }}" alt="{{ $partner->name }}" class="h-10 w-auto object-contain rounded-lg">
                                @else
                                    <span class="text-slate-300 text-xs font-bold">Tidak ada</span>
                                @endif
                            </td>
                            <td class="px-8 py-5 text-base font-bold text-slate-800">{{ $partner->name }}</td>
                            <td class="px-8 py-5 flex justify-center gap-2">
                                <a href="{{ route('admin.partners.edit', $partner->id) }}" class="px-4 py-2 bg-amber-50 text-amber-700 font-bold rounded-xl text-xs hover:bg-amber-100 transition">Edit</a>

                                <form action="{{ route('admin.partners.destroy', $partner->id) }}" method="POST" onsubmit="return confirm('Yakin hapus partner ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="px-4 py-2 bg-rose-50 text-rose-700 font-bold rounded-xl text-xs hover:bg-rose-100 transition">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-8 py-10 text-center text-slate-400 font-bold">Belum ada data partner.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</main>
@endsection