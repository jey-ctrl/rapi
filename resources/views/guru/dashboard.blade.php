
@extends('layouts.app')

@section('title', 'Dashboard Guru')
@section('page-title', 'Dashboard Guru')

@section('content')

@php
    $guru = auth()->user();
    $namaGuru = $guru->fullname ?? $guru->username ?? 'Pengguna';
@endphp

{{-- INTRO --}}
<section class="page-intro">
    <h2>Selamat Datang, {{ $namaGuru }}</h2>
    <p>
        Kelola peminjaman ruangan dan pantau status pengajuan
        kegiatan sekolah Anda.
    </p>
</section>

{{-- NOTIFIKASI SISTEM --}}
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@if($errors->has('msg'))
    <div class="alert alert-danger">
        {{ $errors->first('msg') }}
    </div>
@endif

{{-- NOTIFIKASI PEMINDAHAN --}}
<section class="section" id="notifikasi">

    <div class="section-heading">
        <div>
            <h2>Notifikasi</h2>
            <p class="section-description">
                Informasi perubahan agenda peminjaman ruangan.
            </p>
        </div>
        <span class="section-index">01</span>
    </div>

    @if(isset($movedEvents) && $movedEvents->count() > 0)

        @foreach($movedEvents as $event)
            <div class="card mb-3">
                <div class="card-body">

                    <h3 class="mb-2" style="color: var(--navy); font-size: 14px;">
                        Pemberitahuan Pemindahan Ruangan
                    </h3>

                    <p class="mb-2">
                        Agenda
                        <strong>{{ $event->event_name }}</strong>
                        pada tanggal
                        <strong>{{ $event->date }}</strong>
                        dipindahkan ke ruangan
                        <strong>
                            {{ $event->room->room_name ?? 'Ruangan' }}
                        </strong>.
                    </p>

                    <div class="p-3 rounded"
                         style="background: #fff9e8; color: #725600; font-size: 12px;">
                        <strong>Alasan Waka:</strong>
                        {{ $event->move_reason ?? 'Tidak ada keterangan.' }}
                    </div>

                </div>
            </div>
        @endforeach

    @else

        <div class="card">
            <div class="card-body text-center text-muted">
                Tidak ada notifikasi pemindahan ruangan.
            </div>
        </div>

    @endif

</section>

{{-- STATUS PEMINJAMAN --}}
<section class="section" id="status-peminjaman">

    <div class="section-heading">
        <div>
            <h2>Status Peminjaman Ruangan</h2>
            <p class="section-description">
                Pantau status pengajuan peminjaman ruangan.
            </p>
        </div>
        <span class="section-index">02</span>
    </div>

    @include('guru.status_ruang')

</section>

@endsection
