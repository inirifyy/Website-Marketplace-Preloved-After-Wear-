{{--
    Dashboard penjual. Variabel dari Seller\DashboardController@index:
      $stats       : pending, approved, rejected, ready, sold_out
      $submissions : 10 pengajuan terbaru (relasi category, media)
--}}
@extends('layouts.app')

@section('title', 'Dashboard Penjual')

@push('styles')
    @include('partials.panel-styles')
@endpush

@section('content')
@php
    $statusLabels = ['pending' => 'Menunggu', 'approved' => 'Disetujui', 'rejected' => 'Ditolak'];
@endphp
<div class="aw-container aw-panel">
    <header class="aw-panel__head">
        <div>
            <h1>Dashboard Penjual</h1>
            <p class="aw-panel__lead">Pantau pengajuan dan status barang Anda.</p>
        </div>
        <div class="aw-panel__actions">
            <a class="aw-btn aw-btn--primary" href="{{ route('seller.submissions.create') }}">Ajukan barang</a>
            <a class="aw-btn" href="{{ route('seller.products.index') }}">Produk saya</a>
        </div>
    </header>

    <section aria-label="Ringkasan" class="aw-stats">
        <div class="aw-stat">
            <span class="aw-stat__num">{{ $stats['pending'] ?? 0 }}</span>
            <span class="aw-stat__label">Pengajuan menunggu</span>
        </div>
        <div class="aw-stat">
            <span class="aw-stat__num">{{ $stats['approved'] ?? 0 }}</span>
            <span class="aw-stat__label">Pengajuan disetujui</span>
        </div>
        <div class="aw-stat">
            <span class="aw-stat__num">{{ $stats['rejected'] ?? 0 }}</span>
            <span class="aw-stat__label">Pengajuan ditolak</span>
        </div>
        <div class="aw-stat">
            <span class="aw-stat__num">{{ $stats['ready'] ?? 0 }}</span>
            <span class="aw-stat__label">Produk tersedia</span>
        </div>
        <div class="aw-stat">
            <span class="aw-stat__num">{{ $stats['sold_out'] ?? 0 }}</span>
            <span class="aw-stat__label">Produk terjual</span>
        </div>
    </section>

    <h2>Pengajuan terbaru</h2>

    @if (($submissions ?? collect())->isEmpty())
        <div class="aw-empty">
            <p>Anda belum mengajukan barang.</p>
            <a class="aw-btn aw-btn--primary" href="{{ route('seller.submissions.create') }}">Ajukan barang pertama</a>
        </div>
    @else
        <div class="aw-table-wrap">
            <table class="aw-table">
                <thead>
                    <tr>
                        <th scope="col">Foto</th>
                        <th scope="col">Produk</th>
                        <th scope="col">Kategori</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Status</th>
                        <th scope="col">Catatan admin</th>
                        <th scope="col">Diajukan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($submissions as $submission)
                        @php $photo = $submission->media->firstWhere('media_type', 'image'); @endphp
                        <tr>
                            <td>
                                @if ($photo)
                                    <img class="aw-thumb" src="{{ $photo->url }}" alt="Foto {{ $submission->name }}" loading="lazy">
                                @else
                                    <span class="aw-thumb--empty">Tanpa foto</span>
                                @endif
                            </td>
                            <td>{{ $submission->name }}</td>
                            <td>{{ $submission->category?->name ?? '-' }}</td>
                            <td>Rp {{ number_format((float) $submission->price, 0, ',', '.') }}</td>
                            <td>
                                <span class="aw-badge aw-badge--{{ $submission->submission_status }}">
                                    {{ $statusLabels[$submission->submission_status] ?? $submission->submission_status }}
                                </span>
                            </td>
                            <td class="aw-table__comment">{{ $submission->admin_note ?: '-' }}</td>
                            <td>{{ $submission->created_at?->format('d/m/Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection