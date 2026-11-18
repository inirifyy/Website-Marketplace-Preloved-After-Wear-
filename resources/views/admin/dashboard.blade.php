{{--
    Dashboard admin. Variabel dari Admin\DashboardController@index:
      $stats               : pending_submissions, products, categories, sellers
                             (opsional: reviews -> kartu ulasan muncul otomatis)
      $pendingSubmissions  : koleksi ProductSubmission (relasi seller, category)
--}}
@extends('layouts.app')

@section('title', 'Dashboard Admin')

@push('styles')
    @include('partials.panel-styles')
@endpush

@section('content')
<div class="aw-container aw-panel">
    <header class="aw-panel__head">
        <div>
            <h1>Dashboard Admin</h1>
            <p class="aw-panel__lead">Ringkasan pengelolaan After Wear.</p>
        </div>
        <div class="aw-panel__actions">
            <a class="aw-btn aw-btn--primary" href="{{ route('admin.submissions.index') }}">Tinjau pengajuan</a>
            <a class="aw-btn" href="{{ route('admin.reviews.index') }}">Moderasi ulasan</a>
        </div>
    </header>

    <section aria-label="Ringkasan" class="aw-stats">
        <a class="aw-stat" href="{{ route('admin.submissions.index') }}">
            <span class="aw-stat__num">{{ $stats['pending_submissions'] ?? 0 }}</span>
            <span class="aw-stat__label">Pengajuan menunggu verifikasi</span>
        </a>
        <a class="aw-stat" href="{{ route('admin.products.index') }}">
            <span class="aw-stat__num">{{ $stats['products'] ?? 0 }}</span>
            <span class="aw-stat__label">Produk</span>
        </a>
        <a class="aw-stat" href="{{ route('admin.categories.index') }}">
            <span class="aw-stat__num">{{ $stats['categories'] ?? 0 }}</span>
            <span class="aw-stat__label">Kategori</span>
        </a>
        <div class="aw-stat">
            <span class="aw-stat__num">{{ $stats['sellers'] ?? 0 }}</span>
            <span class="aw-stat__label">Penjual terdaftar</span>
        </div>
        @isset($stats['reviews'])
            <a class="aw-stat" href="{{ route('admin.reviews.index') }}">
                <span class="aw-stat__num">{{ $stats['reviews'] }}</span>
                <span class="aw-stat__label">Ulasan</span>
            </a>
        @endisset
    </section>

    <h2>Pengajuan yang menunggu</h2>

    @if (($pendingSubmissions ?? collect())->isEmpty())
        <p class="aw-empty">Tidak ada pengajuan yang menunggu. Semua pengajuan sudah ditinjau.</p>
    @else
        <div class="aw-table-wrap">
            <table class="aw-table">
                <thead>
                    <tr>
                        <th scope="col">Produk</th>
                        <th scope="col">Penjual</th>
                        <th scope="col">Kategori</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Diajukan</th>
                        <th scope="col"><span class="sr-only">Aksi</span></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pendingSubmissions as $submission)
                        <tr>
                            <td>{{ $submission->name }}</td>
                            <td>{{ $submission->seller?->name ?? '-' }}</td>
                            <td>{{ $submission->category?->name ?? '-' }}</td>
                            <td>Rp {{ number_format((float) $submission->price, 0, ',', '.') }}</td>
                            <td>{{ $submission->created_at?->format('d/m/Y') }}</td>
                            <td><a class="aw-btn aw-btn--small" href="{{ route('admin.submissions.index') }}">Tinjau</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection