@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0 text-danger">
                        <i class="bi bi-exclamation-triangle"></i> Akses Ditolak
                    </h4>
                </div>
                <div class="card-body text-center">
                    <div class="mb-4">
                        <i class="bi bi-shield-x" style="font-size: 4rem; color: #dc3545;"></i>
                    </div>
                    <h5 class="text-danger mb-3">Error 403 - Akses Ditolak</h5>
                    <p class="text-muted mb-4">
                        Maaf, Anda tidak memiliki izin untuk mengakses halaman ini.
                    </p>
                    <p class="text-muted mb-4">
                        {{ $exception->getMessage() ?: 'Anda hanya dapat mengakses data yang Anda input sendiri.' }}
                    </p>
                    <div class="d-flex justify-content-center gap-2">
                        <a href="{{ route('dashboard') }}" class="btn btn-primary">
                            <i class="bi bi-house-door"></i> Kembali ke Dashboard
                        </a>
                        <a href="{{ route('rekap-pemilih') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali ke Rekap Pemilih
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 