@extends('layouts.app')

@section('content')
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">Perolehan Suara Caleg</h5>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <form method="POST" action="{{ route('perolehan-caleg.update') }}">
            @csrf
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nama Caleg</th>
                            <th>Nomor Kursi</th>
                            <th>Dapil</th>
                            <th>Jumlah Suara</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($calegs as $caleg)
                        <tr>
                            <td>{{ $caleg->nama }}</td>
                            <td>{{ $caleg->nomor_kursi }}</td>
                            <td>{{ $caleg->dapil }}</td>
                            <td style="max-width:120px;">
                                <input type="number" class="form-control" value="{{ $caleg->suara }}" readonly>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </form>
    </div>
</div>
@endsection 