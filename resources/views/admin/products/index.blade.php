{{--
    Daftar produk (admin). Variabel dari Admin\ProductController@index:
      $products : paginator Product (relasi seller, category, media)
    Filter lewat query string: ?q=...&approval_status=pending|approved|rejected
--}}
@extends('layouts.app')

@section('title', 'Kelola Produk')

@push('styles')
    @include('partials.panel-styles')
@endpush

@section('content')
@php
    $approvalLabels = ['pending' => 'Menunggu', 'approved' => 'Disetujui', 'rejected' => 'Ditolak'];
    $statusLabels   = ['ready' => 'Tersedia', 'sold_out' => 'Habis'];
@endphp
<div class="aw-container aw-panel">
    <header class="aw-panel__head">
        <div>
            <h1>Kelola Produk</h1>
            <p class="aw-panel__lead">{{ $products->total() }} produk terdaftar.</p>
        </div>
        <div class="aw-panel__actions">
            <a class="aw-btn aw-btn--primary" href="{{ route('admin.products.create') }}">+ Tambah Produk</a>
            <a class="aw-btn" href="{{ route('admin.dashboard') }}">Kembali ke dashboard</a>
        </div>
    </header>

    <form class="aw-filter" method="GET" action="{{ route('admin.products.index') }}">
        <div>
            <label for="q">Cari nama produk</label>
            <input class="aw-input" id="q" name="q" type="search" value="{{ request('q') }}" placeholder="Contoh: kemeja">
        </div>
        <div>
            <label for="approval_status">Status persetujuan</label>
            <select class="aw-input" id="approval_status" name="approval_status">
                <option value="">Semua</option>
                @foreach ($approvalLabels as $value => $label)
                    <option value="{{ $value }}" @selected(request('approval_status') === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <button class="aw-btn aw-btn--primary" type="submit">Terapkan</button>
        @if (request()->filled('q') || request()->filled('approval_status'))
            <a class="aw-btn" href="{{ route('admin.products.index') }}">Reset</a>
        @endif
    </form>

    @if ($products->isEmpty())
        <p class="aw-empty">Belum ada produk{{ request()->filled('q') || request()->filled('approval_status') ? ' yang cocok dengan filter' : '' }}.</p>
    @else
        <div class="aw-table-wrap">
            <table class="aw-table">
                <thead>
                    <tr>
                        <th scope="col">Foto</th>
                        <th scope="col">Produk</th>
                        <th scope="col">Kategori</th>
                        <th scope="col">Penjual</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Stok</th>
                        <th scope="col">Persetujuan</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        @php $photo = $product->media->firstWhere('media_type', 'image'); @endphp
                        <tr>
                            <td>
                                @if ($photo)
                                    <img class="aw-thumb" src="{{ $photo->url }}" alt="Foto {{ $product->name }}" loading="lazy">
                                @else
                                    <span class="aw-thumb--empty">Tanpa foto</span>
                                @endif
                            </td>
                            <td><strong>{{ $product->name }}</strong></td>
                            <td>{{ $product->category?->name ?? '-' }}</td>
                            <td>{{ $product->seller?->name ?? '-' }}</td>
                            <td>Rp {{ number_format((float) $product->price, 0, ',', '.') }}</td>
                            <td><span class="aw-badge aw-badge--role">{{ $statusLabels[$product->status] ?? $product->status }}</span></td>
                            <td>
                                <span class="aw-badge aw-badge--{{ $product->approval_status }}">
                                    {{ $approvalLabels[$product->approval_status] ?? $product->approval_status }}
                                </span>
                            </td>
                            <td>
                                <div style="display: inline-flex; gap: .35rem;">
                                    <a class="aw-btn aw-btn--small" href="{{ route('admin.products.edit', $product) }}">Ubah</a>
                                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}"
                                          onsubmit="return confirm('Hapus produk {{ $product->name }}? Foto dan videonya ikut terhapus.')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="aw-btn aw-btn--danger aw-btn--small" type="submit">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @include('partials.pager', ['paginator' => $products])
    @endif
</div>
@endsection
