@extends('layout.sidebar')

@section('content')
<main class="p-10 max-w-2xl">
    <div class="mb-6">
        <h1 class="text-3xl font-black text-slate-800">Edit Partner</h1>
        <p class="text-slate-500 text-sm">Perbarui data nama partner atau ganti link posternya.</p>
    </div>

    <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm">
        <form action="{{ route('admin.partners.update', $partner->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-5">
                <label class="block text-sm font-bold text-slate-700 mb-2">Nama Partner</label>
                <input type="text" name="name" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500" value="{{ old('name', $partner->name) }}" required>
            </div>
            <div class="mb-6">
                <label class="block text-sm font-bold text-slate-700 mb-2">URL Link Logo / Poster</label>
                <input type="url" name="logo_url" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500" value="{{ old('logo_url', $partner->logo_url) }}" required>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="px-6 py-3 bg-amber-500 text-white font-bold rounded-xl hover:bg-amber-600 transition text-sm">Perbarui Data</button>
                <a href="{{ route('admin.partners.index') }}" class="px-6 py-3 bg-slate-100 text-slate-600 font-bold rounded-xl hover:bg-slate-200 transition text-sm">Batal</a>
            </div>
        </form>
    </div>
</main>
@endsection