@extends('layouts.admin') {{-- Sesuaikan dengan nama layout master Anda --}}

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-7">
            
            <a href="{{ route('admin.partners.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3 mb-3 fw-medium">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
            </a>

            <div class="card border-0 shadow rounded-3 bg-light">
                <div class="card-body p-4 bg-white rounded-3 m-1 shadow-sm">
                    <h3 class="fw-bold text-dark mb-1">Daftarkan Partner Baru</h3>
                    <p class="text-muted small mb-4">Lengkapi formulir di bawah ini dengan benar untuk menambah mitra baru.</p>
                    <hr class="text-muted opacity-25 mb-4">
                    
                    <form action="{{ route('admin.partners.store') }}" method="POST">
                        @csrf 

                        <div class="mb-4">
                            <label for="name" class="form-label fw-bold text-dark fs-6">Nama Instansi / Partner <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" 
                                   class="form-control form-control-lg border-2 @error('name') is-invalid @enderror" 
                                   placeholder="Masukkan nama lengkap partner (cth: Bank Mandiri)"
                                   value="{{ old('name') }}" required autocomplete="off">
                            @error('name')
                                <div class="invalid-feedback fw-bold">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="logo_url" class="form-label fw-bold text-dark fs-6">URL Link Logo <span class="text-danger">*</span></label>
                            <input type="url" name="logo_url" id="logo_url" 
                                   class="form-control form-control-lg border-2 @error('logo_url') is-invalid @enderror" 
                                   placeholder="Masukkan tautan gambar (cth: https://placehold.co/200x200)" 
                                   value="{{ old('logo_url') }}" required>
                            <div class="form-text text-dark-50 fw-medium fs-7 mt-2">
                                <i class="fas fa-info-circle text-primary me-1"></i> Gunakan direct link gambar eksternal yang valid.
                            </div>
                            @error('logo_url')
                                <div class="invalid-feedback fw-bold">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid mt-5">
                            <button type="submit" class="btn btn-success btn-lg py-3 fw-bold shadow">
                                <i class="fas fa-check-circle me-2"></i> Simpan Data Partner Sekarang
                            </button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection