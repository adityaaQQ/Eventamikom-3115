@extends('layout.sidebar')

@section('content')
<div class="p-10">
    <div class="mb-8">
        <h1 class="text-3xl font-black text-slate-800 tracking-tight">Edit Informasi Event</h1>
        <p class="text-sm text-slate-500 mt-1">Perbarui poster atau rincian detail event yang telah dipilih.</p>
    </div>

    <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm max-w-2xl">
        <form action="/adminkelola/{{ $event->id }}/update" method="POST" enctype="multipart/form-data" class="flex flex-col gap-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Nama Event</label>
                <input type="text" name="title" value="{{ old('title', $event->title) }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-500 text-sm font-medium" required>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Tanggal Event</label>
                <input type="date" name="date" value="{{ old('date', \Carbon\Carbon::parse($event->date)->format('Y-m-d')) }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-500 text-sm font-medium" required>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Harga Tiket (Isi 0 jika Gratis)</label>
                <input type="number" name="price" value="{{ old('price', $event->price) }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-500 text-sm font-medium" required>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Poster Event (Biarkan kosong jika tidak ingin diganti)</label>
                @if($event->poster)
                    <div class="mb-3">
                        <img src="{{ asset('storage/' . $event->poster) }}" class="w-32 h-40 object-cover rounded-xl shadow-sm border border-slate-100" alt="Current Poster">
                    </div>
                @endif
                <input type="file" name="poster" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
            </div>

            <div class="flex gap-3 mt-4">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-6 py-3 rounded-xl shadow-lg shadow-indigo-600/20 transition text-sm">
                    Simpan Perubahan
                </button>
                <a href="/adminkelola" class="bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold px-6 py-3 rounded-xl transition text-sm text-center flex items-center justify-center">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection