
@extends('layouts.app')

@section('title', 'Persetujuan Peminjaman')
@section('page-title', 'Persetujuan Peminjaman')

@section('content')

<section class="page-intro">
    <h2>Persetujuan Peminjaman Ruangan</h2>
    <p>
        Periksa pengajuan peminjaman ruangan dan tentukan apakah
        pengajuan dapat disetujui atau ditolak.
    </p>
</section>

@if(session('approval_success'))
    <div class="alert alert-success">
        {{ session('approval_success') }}
    </div>
@endif

@if(session('approval_error'))
    <div class="alert alert-danger">
        {{ session('approval_error') }}
    </div>
@endif

<section class="section">

    <div class="section-heading">
        <div>
            <h2>Daftar Pengajuan</h2>
            <p class="section-description">
                Pengajuan yang menunggu keputusan Admin.
            </p>
        </div>

        <span class="badge bg-warning text-dark">
            {{ $pendingApprovals->count() }} Menunggu
        </span>
    </div>

    @include('admin.persetujuan_peminjaman')

</section>

@endsection