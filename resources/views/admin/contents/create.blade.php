{{-- Form tambah konten website. Variabel: $sections --}}
@extends('layouts.app')

@section('title', 'Tambah Konten')

@push('styles')
    @include('partials.panel-styles')
@endpush

@section('content')
<div class="aw-container aw-panel">
    <header class="aw-panel__head">
        <div>
            <h1>Tambah Konten</h1>
            <p class="aw-panel__lead">Konten aktif akan tampil di halaman publik sesuai bagiannya.</p>
        </div>
        <a class="aw-btn" href="{{ route('admin.contents.index') }}">Kembali ke daftar</a>
    </header>

    <form class="aw-form" method="POST" action="{{ route('admin.contents.store') }}">
        @csrf
        @include('admin.contents._form', ['content' => null])
        <button class="aw-btn aw-btn--primary" type="submit">Simpan konten</button>
    </form>
</div>
@endsection
