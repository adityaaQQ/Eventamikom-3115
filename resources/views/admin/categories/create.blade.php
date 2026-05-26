@extends('layout.sidebar')

@section('content')
<main class="p-10 max-w-2xl">
    <div class="mb-6">
        <h1 class="text-3xl font-black text-slate-800">Tambah Kategori</h1>
        <p class="text-slate-500 text-sm">Tambahkan kategori baru AmikomEventHub.</p>
    </div>

    <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm">
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            <div class="mb-6">
                <label class="block text-sm font-bold text-slate-700 mb-2">Nama Kategori</label>
                <input type="text" name="name" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500" placeholder="Contoh: Seminar" value="{{ old('name') }}" required>
                @error('name')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex gap-3">
                <button type="submit" class="px-6 py-3 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 transition text-sm">Simpan</button>
                <a href="{{ route('admin.categories.index') }}" class="px-6 py-3 bg-slate-100 text-slate-600 font-bold rounded-xl hover:bg-slate-200 transition text-sm">Batal</a>
            </div>
        </form>
    </div>
</main>
@endsection