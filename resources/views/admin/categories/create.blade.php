@extends('layouts.app')

@section('title', 'Tambah Kategori')

@push('styles')
    @include('partials.panel-styles')
    <style>
        .aw-form-grid { display: grid; gap: 1.25rem; max-width: 600px; background: var(--aw-white); border: 1px solid var(--aw-line); border-radius: .5rem; padding: 1.5rem; margin-top: 1rem; }
        .aw-form-group { display: flex; flex-direction: column; gap: .35rem; }
        .aw-form-group label { font-weight: 600; font-size: .95rem; }
        .aw-form-group input[type="text"],
        .aw-form-group input[type="number"],
        .aw-form-group textarea {
            padding: .6rem .8rem;
            border: 1px solid var(--aw-line);
            border-radius: .4rem;
            font: inherit;
            background: var(--aw-white);
        }
        .aw-form-hint { font-size: .8rem; color: rgba(48, 51, 47, .7); }
        .aw-form-checkbox { display: flex; align-items: center; gap: .5rem; font-weight: 500; cursor: pointer; }
    </style>
@endpush

@section('content')
<div class="aw-container aw-panel">
    <header class="aw-panel__head">
        <div>
            <h1>Tambah Kategori</h1>
            <p class="aw-panel__lead">Buat kelompok kategori baru untuk produk preloved.</p>
        </div>
        <div class="aw-panel__actions">
            <a class="aw-btn" href="{{ route('admin.categories.index') }}">Kembali ke Daftar Kategori</a>
        </div>
    </header>

    @if ($errors->any())
        <div class="aw-alert aw-alert-error" role="alert">
            <strong>Terjadi kesalahan pengisian form:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.categories.store') }}" class="aw-form-grid">
        @csrf

        <div class="aw-form-group">
            <label for="name">Nama Kategori <span style="color: #991b1b;">*</span></label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Contoh: Atasan, Outerwear" required autofocus />
            <span class="aw-form-hint">Nama kategori yang akan ditampilkan ke pengguna.</span>
        </div>

        <div class="aw-form-group">
            <label for="slug">Slug (URL)</label>
            <input type="text" id="slug" name="slug" value="{{ old('slug') }}" placeholder="contoh: atasan (opsional, otomatis dibuat jika kosong)" />
            <span class="aw-form-hint">Format huruf kecil dan tanda strip untuk URL (contoh: dress-terusan).</span>
        </div>

        <div class="aw-form-group">
            <label for="description">Deskripsi Kategori</label>
            <textarea id="description" name="description" rows="3" placeholder="Jelaskan jenis pakaian yang termasuk dalam kategori ini...">{{ old('description') }}</textarea>
        </div>

        <div class="aw-form-group">
            <label for="image">URL Gambar Kategori</label>
            <input type="text" id="image" name="image" value="{{ old('image') }}" placeholder="https://... atau /images/kategori.jpg" />
            <span class="aw-form-hint">Tautan foto banner atau thumbnail kategori.</span>
        </div>

        <div class="aw-form-group">
            <label for="order">Urutan Tampilan</label>
            <input type="number" id="order" name="order" value="{{ old('order', 0) }}" min="0" />
            <span class="aw-form-hint">Kategori dengan angka urutan lebih kecil muncul lebih awal di beranda.</span>
        </div>

        <div class="aw-form-group">
            <label class="aw-form-checkbox">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} />
                <span>Aktifkan kategori ini (tampil di halaman utama & pencarian katalog)</span>
            </label>
        </div>

        <div style="display: flex; gap: .75rem; margin-top: .5rem;">
            <button type="submit" class="aw-btn aw-btn--primary">Simpan Kategori</button>
            <a href="{{ route('admin.categories.index') }}" class="aw-btn">Batal</a>
        </div>
    </form>
</div>
@endsection

