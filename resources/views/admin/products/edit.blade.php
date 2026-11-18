{{-- Form ubah produk (admin). Variabel: $product (relasi media), $categories --}}
@extends('layouts.app')

@section('title', 'Ubah Produk')

@push('styles')
    @include('partials.panel-styles')
@endpush

@section('content')
<div class="aw-container aw-panel">
    <header class="aw-panel__head">
        <div>
            <h1>Ubah Produk</h1>
            <p class="aw-panel__lead">{{ $product->name }}</p>
        </div>
        <a class="aw-btn" href="{{ route('admin.products.index') }}">Kembali ke daftar</a>
    </header>

    <form class="aw-form" method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.products._form', ['product' => $product, 'isEdit' => true])
        <button class="aw-btn aw-btn--primary" type="submit">Simpan perubahan</button>
    </form>
</div>
@endsection
