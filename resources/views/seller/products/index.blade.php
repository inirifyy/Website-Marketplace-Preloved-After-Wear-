daftar barang milik penjual dan status ready/habis.{{--
    Produk milik penjual. Variabel dari Seller\MyProductController@index:
      $products : paginator Product (relasi category, media)
    Penjual hanya bisa mengubah status ready <-> sold_out (route seller.products.status).
--}}
@extends('layouts.app')

@section('title', 'Produk Saya')

@push('styles')
    @include('partials.panel-styles')
@endpush

@section('content')
@php
    $approvalLabels = ['pending' => 'Menunggu', 'approved' => 'Disetujui', 'rejected' => 'Ditolak'];
@endphp
<div class="aw-container aw-panel">
    <header class="aw-panel__head">
        <div>
            <h1>Produk Saya</h1>
            <p class="aw-panel__lead">{{ $products->total() }} produk milik Anda.</p>
        </div>
        <div class="aw-panel__actions">
            <a class="aw-btn aw-btn--primary" href="{{ route('seller.submissions.create') }}">Ajukan barang</a>
            <a class="aw-btn" href="{{ route('seller.dashboard') }}">Kembali ke dashboard</a>
        </div>
    </header>

    @if ($products->isEmpty())
        <div class="aw-empty">
            <p>Belum ada produk. Produk muncul di sini setelah pengajuan Anda disetujui admin.</p>
            <a class="aw-btn aw-btn--primary" href="{{ route('seller.submissions.create') }}">Ajukan barang</a>
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
                        <th scope="col">Persetujuan</th>
                        <th scope="col">Status barang</th>
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
                            <td>
                                @if ($product->approval_status === 'approved')
                                    <a href="{{ route('products.show', $product) }}"><strong>{{ $product->name }}</strong></a>
                                @else
                                    <strong>{{ $product->name }}</strong>
                                @endif
                            </td>
                            <td>{{ $product->category?->name ?? '-' }}</td>
                            <td>Rp {{ number_format((float) $product->price, 0, ',', '.') }}</td>
                            <td>
                                <span class="aw-badge aw-badge--{{ $product->approval_status }}">
                                    {{ $approvalLabels[$product->approval_status] ?? $product->approval_status }}
                                </span>
                            </td>
                            <td>
                                <form method="POST" action="{{ route('seller.products.status', $product) }}"
                                      style="display:flex; gap:.35rem; align-items:center;">
                                    @csrf
                                    @method('PATCH')
                                    <label class="sr-only" for="status-{{ $product->id }}">Status {{ $product->name }}</label>
                                    <select class="aw-input" id="status-{{ $product->id }}" name="status" style="width:auto;">
                                        <option value="ready" @selected($product->status === 'ready')>Tersedia</option>
                                        <option value="sold_out" @selected($product->status === 'sold_out')>Habis</option>
                                    </select>
                                    <button class="aw-btn aw-btn--small" type="submit">Simpan</button>
                                </form>
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
