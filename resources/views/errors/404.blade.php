@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0 text-warning">
                        <i class="bi bi-exclamation-triangle"></i> Halaman Tidak Ditemukan
                    </h4>
                </div>
                <div class="card-body text-center">
                    <div class="mb-4">
                        <i class="bi bi-search" style="font-size: 4rem; color: #ffc107;"></i>
                    </div>
                    <h5 class="text-warning mb-3">Error 404 - Halaman Tidak Ditemukan</h5>
                    <p class="text-muted mb-4">
                        Maaf, halaman yang Anda cari tidak ditemukan atau telah dipindahkan.
                    </p>
                    <p class="text-muted mb-4">
                        {{ $exception->getMessage() ?: 'Silakan periksa kembali URL yang Anda masukkan.' }}
                    </p>
                    <div class="d-flex justify-content-center gap-2">
                        <a href="{{ route('dashboard') }}" class="btn btn-primary">
                            <i class="bi bi-house-door"></i> Kembali ke Dashboard
                        </a>
                        <button onclick="history.back()" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 