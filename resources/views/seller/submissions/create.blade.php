{{-- Form pengajuan barang oleh penjual. Variabel dari Seller\ProductSubmissionController@create: $categories --}}
@extends('layouts.app')

@section('title', 'Ajukan Barang')

@push('styles')
    @include('partials.panel-styles')
@endpush

@section('content')
<div class="aw-container aw-panel">
    <header class="aw-panel__head">
        <div>
            <h1>Ajukan Barang</h1>
            <p class="aw-panel__lead">Barang akan diperiksa admin dulu. Jika disetujui, barang tayang di katalog.</p>
        </div>
        <a class="aw-btn" href="{{ route('seller.dashboard') }}">Kembali ke dashboard</a>
    </header>

    <form class="aw-form" method="POST" action="{{ route('seller.submissions.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="aw-field">
            <label for="category_id">Kategori <span aria-hidden="true">*</span></label>
            <select class="aw-input" id="category_id" name="category_id" required>
                <option value="">Pilih kategori</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected((string) old('category_id') === (string) $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id') <p class="aw-field__error">{{ $message }}</p> @enderror
        </div>

        <div class="aw-field">
            <label for="name">Nama barang <span aria-hidden="true">*</span></label>
            <input class="aw-input" id="name" name="name" type="text" maxlength="200" value="{{ old('name') }}" required>
            @error('name') <p class="aw-field__error">{{ $message }}</p> @enderror
        </div>

        <div class="aw-field">
            <label for="description">Deskripsi <span aria-hidden="true">*</span></label>
            <textarea class="aw-input" id="description" name="description" required>{{ old('description') }}</textarea>
            @error('description') <p class="aw-field__error">{{ $message }}</p> @enderror
        </div>

        <div class="aw-field">
            <label for="price">Harga (Rp) <span aria-hidden="true">*</span></label>
            <input class="aw-input" id="price" name="price" type="number" min="1000" step="1" value="{{ old('price') }}" required>
            <p class="aw-field__hint">Minimal Rp 1.000.</p>
            @error('price') <p class="aw-field__error">{{ $message }}</p> @enderror
        </div>

        <fieldset>
            <legend>Detail barang</legend>
            <div class="aw-field">
                <label for="item_condition">Kondisi</label>
                <input class="aw-input" id="item_condition" name="item_condition" type="text" maxlength="100" placeholder="Contoh: Seperti baru" value="{{ old('item_condition') }}">
                @error('item_condition') <p class="aw-field__error">{{ $message }}</p> @enderror
            </div>
            <div class="aw-field">
                <label for="material">Bahan</label>
                <input class="aw-input" id="material" name="material" type="text" maxlength="100" value="{{ old('material') }}">
                @error('material') <p class="aw-field__error">{{ $message }}</p> @enderror
            </div>
            <div class="aw-field">
                <label for="usage_duration">Lama pemakaian</label>
                <input class="aw-input" id="usage_duration" name="usage_duration" type="text" maxlength="100" placeholder="Contoh: 6 bulan" value="{{ old('usage_duration') }}">
                @error('usage_duration') <p class="aw-field__error">{{ $message }}</p> @enderror
            </div>
            <div class="aw-field">
                <label for="flaws">Cacat / minus</label>
                <textarea class="aw-input" id="flaws" name="flaws" placeholder="Tulis jujur supaya pembeli tidak kecewa">{{ old('flaws') }}</textarea>
                @error('flaws') <p class="aw-field__error">{{ $message }}</p> @enderror
            </div>
            <div class="aw-field">
                <label for="location">Lokasi</label>
                <input class="aw-input" id="location" name="location" type="text" maxlength="255" value="{{ old('location') }}">
                @error('location') <p class="aw-field__error">{{ $message }}</p> @enderror
            </div>
            <div class="aw-field">
                <label for="contact_whatsapp">Nomor WhatsApp</label>
                <input class="aw-input" id="contact_whatsapp" name="contact_whatsapp" type="tel" inputmode="numeric" placeholder="081234567890" value="{{ old('contact_whatsapp') }}">
                <p class="aw-field__hint">Format Indonesia, contoh: 081234567890 atau 6281234567890.</p>
                @error('contact_whatsapp') <p class="aw-field__error">{{ $message }}</p> @enderror
            </div>
        </fieldset>

        <fieldset>
            <legend>Foto dan video</legend>
            <div class="aw-field">
                <label for="photos">Foto <span aria-hidden="true">*</span></label>
                <input class="aw-input" id="photos" name="photos[]" type="file" accept="image/jpeg,image/png,image/webp" multiple required>
                <p class="aw-field__hint">Unggah 1 sampai 5 foto (JPG/PNG/WEBP, maksimal 2 MB per foto).</p>
                @error('photos') <p class="aw-field__error">{{ $message }}</p> @enderror
                @error('photos.*') <p class="aw-field__error">{{ $message }}</p> @enderror
            </div>
            <div class="aw-field">
                <label for="video">Video (opsional)</label>
                <input class="aw-input" id="video" name="video" type="file" accept="video/mp4,video/webm,video/quicktime">
                <p class="aw-field__hint">MP4/WEBM/MOV, maksimal 20 MB.</p>
                @error('video') <p class="aw-field__error">{{ $message }}</p> @enderror
            </div>
        </fieldset>

        <button class="aw-btn aw-btn--primary" type="submit">Kirim pengajuan</button>
    </form>
</div>
@endsection
