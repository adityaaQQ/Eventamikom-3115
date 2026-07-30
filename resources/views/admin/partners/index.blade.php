@extends('layouts.admin') {{-- Sesuaikan dengan nama layout master Anda --}}

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Modul Partner</h2>
            <p class="text-muted small mb-0">Kelola informasi mitra dan pendukung platform AmikomEventHub</p>
        </div>
        <a href="{{ route('admin.partners.create') }}" class="btn btn-primary btn-lg px-4 shadow fw-bold fs-6">
            <i class="fas fa-plus-circle me-2"></i>Tambah Partner Baru
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <strong>Sukses!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark text-uppercase fs-7">
                        <tr>
                            <th class="ps-4 py-3" style="width: 100px;">ID</th>
                            <th style="width: 140px;">Logo</th>
                            <th>Nama Partner</th>
                            <th class="pe-4">Tanggal Bergabung</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($partners as $partner)
                        <tr>
                            <td class="ps-4 fw-bold text-secondary">#{{ $partner->id }}</td>
                            <td class="py-3">
                                <div class="bg-white d-flex align-items-center justify-content-center rounded-3 border border-2" style="width: 64px; height: 64px; overflow: hidden;">
                                    <img src="{{ $partner->logo_url }}" alt="{{ $partner->name }}" class="img-fluid" style="max-height: 100%; max-width: 100%; object-fit: contain;">
                                </div>
                            </td>
                            <td>
                                <strong class="text-dark fs-5">{{ $partner->name }}</strong>
                            </td>
                            <td class="pe-4">
                                <span class="text-muted fw-medium">
                                    <i class="far fa-calendar-alt me-1 text-primary"></i>{{ $partner->created_at->format('d M Y') }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                <i class="fas fa-folder-open d-block mb-3 fs-3 text-secondary"></i>
                                Belum ada data partner terdaftar.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection