{{-- Form tambah produk (admin). Variabel: $categories --}}
@extends('layouts.app')

@section('title', 'Tambah Produk')

@push('styles')
    @include('partials.panel-styles')
@endpush

@section('content')
<div class="aw-container aw-panel">
    <header class="aw-panel__head">
        <div>
            <h1>Tambah Produk</h1>
            <p class="aw-panel__lead">Produk yang dibuat admin langsung masuk ke daftar produk.</p>
        </div>
        <a class="aw-btn" href="{{ route('admin.products.index') }}">Kembali ke daftar</a>
    </header>

    <form class="aw-form" method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
        @csrf
        @include('admin.products._form', ['product' => null, 'isEdit' => false])
        <button class="aw-btn aw-btn--primary" type="submit">Simpan produk</button>
    </form>
</div>
@endsection
