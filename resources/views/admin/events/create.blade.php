@extends('layout.sidebar')

@section('content')
<div class="p-10">
    <div class="mb-8">
        <h1 class="text-3xl font-black text-slate-800 tracking-tight">Tambah Event Baru</h1>
        <p class="text-sm text-slate-500 mt-1">Publikasikan gambar poster serta kelengkapan informasi acara Anda.</p>
    </div>

    @if ($errors->any())
    <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-2xl text-sm font-semibold max-w-2xl">
        <ul class="list-disc pl-5 flex flex-col gap-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm max-w-2xl">
        <form action="/adminkelola/store" method="POST" enctype="multipart/form-data" class="flex flex-col gap-6">
            @csrf

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Nama Event</label>
                <input type="text" name="title" value="{{ old('title') }}" class="w-full px-4 py-3 rounded-xl border @error('title') border-rose-400 focus:border-rose-500 @else border-slate-200 focus:border-indigo-500 @enderror text-sm font-medium" placeholder="Masukkan nama event" required>
                @error('title') <p class="text-rose-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Upload Poster Gambar (Format: JPG, JPEG, PNG)</label>
                <input type="file" name="poster" accept="image/jpeg,image/png,image/jpg" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                <p class="text-[11px] text-slate-400 mt-1">⚠️ Jangan gunakan format .HEIC dari iPhone. Gunakan JPG/PNG biasa.</p>
                @error('poster') <p class="text-rose-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Tanggal Pelaksanaan</label>
                    <input type="date" name="date" value="{{ old('date') }}" class="w-full px-4 py-3 rounded-xl border @error('date') border-rose-400 focus:border-rose-500 @else border-slate-200 focus:border-indigo-500 @enderror text-sm font-medium" required>
                    @error('date') <p class="text-rose-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Harga Tiket (Rupiah)</label>
                    <input type="number" name="price" value="{{ old('price') }}" class="w-full px-4 py-3 rounded-xl border @error('price') border-rose-400 focus:border-rose-500 @else border-slate-200 focus:border-indigo-500 @enderror text-sm font-medium" placeholder="Isi 0 jika gratis" required>
                    @error('price') <p class="text-rose-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex gap-3 mt-4">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-6 py-3 rounded-xl shadow-lg shadow-indigo-600/20 transition text-sm">
                    Simpan & Publikasikan
                </button>
                <a href="/adminkelola" class="bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold px-6 py-3 rounded-xl transition text-sm text-center flex items-center justify-center">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection