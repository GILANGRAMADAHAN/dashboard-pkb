@extends('layouts.app')

@section('content')
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">Detail User</h5>
    </div>
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-3">Nama</dt>
            <dd class="col-sm-9">{{ $user->name }}</dd>
            <dt class="col-sm-3">Email</dt>
            <dd class="col-sm-9">{{ $user->email }}</dd>
            <dt class="col-sm-3">Role</dt>
            <dd class="col-sm-9">{{ ucfirst($user->role) }}</dd>
        </dl>
        <a href="{{ route('user.index') }}" class="btn btn-secondary">Kembali</a>
        <a href="{{ route('user.edit', $user->id) }}" class="btn btn-warning">Edit</a>
    </div>
</div>
@endsection 