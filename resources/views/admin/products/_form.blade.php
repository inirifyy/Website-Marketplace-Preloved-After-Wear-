{{--
    Isi form produk, dipakai create dan edit.
    Variabel: $categories, $product (null saat tambah), $isEdit (bool)
--}}
@php
    $product = $product ?? null;
    $isEdit  = $isEdit ?? false;
    $v = fn (string $field, $default = '') => old($field, $product?->{$field} ?? $default);
@endphp

<div class="aw-field">
    <label for="category_id">Kategori <span aria-hidden="true">*</span></label>
    <select class="aw-input" id="category_id" name="category_id" required>
        <option value="">Pilih kategori</option>
        @foreach ($categories as $category)
            <option value="{{ $category->id }}" @selected((string) $v('category_id') === (string) $category->id)>{{ $category->name }}</option>
        @endforeach
    </select>
    @error('category_id') <p class="aw-field__error">{{ $message }}</p> @enderror
</div>

<div class="aw-field">
    <label for="name">Nama produk <span aria-hidden="true">*</span></label>
    <input class="aw-input" id="name" name="name" type="text" maxlength="200" value="{{ $v('name') }}" required>
    @error('name') <p class="aw-field__error">{{ $message }}</p> @enderror
</div>

<div class="aw-field">
    <label for="description">Deskripsi <span aria-hidden="true">*</span></label>
    <textarea class="aw-input" id="description" name="description" required>{{ $v('description') }}</textarea>
    @error('description') <p class="aw-field__error">{{ $message }}</p> @enderror
</div>

<div class="aw-field">
    <label for="price">Harga (Rp) <span aria-hidden="true">*</span></label>
    <input class="aw-input" id="price" name="price" type="number" min="0" step="1" value="{{ $v('price') !== '' ? (int) $v('price') : '' }}" required>
    @error('price') <p class="aw-field__error">{{ $message }}</p> @enderror
</div>

<fieldset>
    <legend>Detail barang</legend>
    <div class="aw-field">
        <label for="item_condition">Kondisi</label>
        <input class="aw-input" id="item_condition" name="item_condition" type="text" maxlength="100" placeholder="Contoh: Seperti baru" value="{{ $v('item_condition') }}">
        @error('item_condition') <p class="aw-field__error">{{ $message }}</p> @enderror
    </div>
    <div class="aw-field">
        <label for="material">Bahan</label>
        <input class="aw-input" id="material" name="material" type="text" maxlength="100" value="{{ $v('material') }}">
        @error('material') <p class="aw-field__error">{{ $message }}</p> @enderror
    </div>
    <div class="aw-field">
        <label for="usage_duration">Lama pemakaian</label>
        <input class="aw-input" id="usage_duration" name="usage_duration" type="text" maxlength="100" placeholder="Contoh: 6 bulan" value="{{ $v('usage_duration') }}">
        @error('usage_duration') <p class="aw-field__error">{{ $message }}</p> @enderror
    </div>
    <div class="aw-field">
        <label for="flaws">Cacat / minus</label>
        <textarea class="aw-input" id="flaws" name="flaws">{{ $v('flaws') }}</textarea>
        @error('flaws') <p class="aw-field__error">{{ $message }}</p> @enderror
    </div>
    <div class="aw-field">
        <label for="location">Lokasi</label>
        <input class="aw-input" id="location" name="location" type="text" maxlength="255" value="{{ $v('location') }}">
        @error('location') <p class="aw-field__error">{{ $message }}</p> @enderror
    </div>
</fieldset>

<fieldset>
    <legend>Status</legend>
    <div class="aw-field">
        <label for="status">Ketersediaan <span aria-hidden="true">*</span></label>
        <select class="aw-input" id="status" name="status" required>
            <option value="ready" @selected($v('status', 'ready') === 'ready')>Tersedia</option>
            <option value="sold_out" @selected($v('status', 'ready') === 'sold_out')>Habis</option>
        </select>
        @error('status') <p class="aw-field__error">{{ $message }}</p> @enderror
    </div>
    <div class="aw-field">
        <label for="approval_status">Persetujuan <span aria-hidden="true">*</span></label>
        <select class="aw-input" id="approval_status" name="approval_status" required>
            @foreach (['pending' => 'Menunggu', 'approved' => 'Disetujui', 'rejected' => 'Ditolak'] as $value => $label)
                <option value="{{ $value }}" @selected($v('approval_status', 'approved') === $value)>{{ $label }}</option>
            @endforeach
        </select>
        <p class="aw-field__hint">Hanya produk berstatus "Disetujui" yang tampil di katalog publik.</p>
        @error('approval_status') <p class="aw-field__error">{{ $message }}</p> @enderror
    </div>
</fieldset>

<fieldset>
    <legend>Foto dan video</legend>

    @if ($isEdit && $product && $product->media->isNotEmpty())
        <div class="aw-field">
            <span style="display:block; font-weight:600; margin-bottom:.35rem;">Media saat ini</span>
            <div style="display:flex; flex-wrap:wrap; gap:.5rem;">
                @foreach ($product->media as $media)
                    @if ($media->media_type === 'image')
                        <img class="aw-thumb" src="{{ $media->url }}" alt="Foto {{ $product->name }}" loading="lazy">
                    @else
                        <span class="aw-thumb--empty">Video</span>
                    @endif
                @endforeach
            </div>
        </div>
    @endif

    <div class="aw-field">
        <label for="photos">{{ $isEdit ? 'Tambah foto baru' : 'Foto' }} @unless ($isEdit)<span aria-hidden="true">*</span>@endunless</label>
        <input class="aw-input" id="photos" name="photos[]" type="file" accept="image/jpeg,image/png,image/webp" multiple @unless ($isEdit) required @endunless>
        <p class="aw-field__hint">Maksimal 5 foto, format JPG/PNG/WEBP, masing-masing maksimal 2 MB.</p>
        @error('photos') <p class="aw-field__error">{{ $message }}</p> @enderror
        @error('photos.*') <p class="aw-field__error">{{ $message }}</p> @enderror
    </div>

    <div class="aw-field">
        <label for="video">{{ $isEdit ? 'Tambah video baru' : 'Video' }} (opsional)</label>
        <input class="aw-input" id="video" name="video" type="file" accept="video/mp4,video/webm,video/quicktime">
        <p class="aw-field__hint">Format MP4/WEBM/MOV, maksimal 20 MB.</p>
        @error('video') <p class="aw-field__error">{{ $message }}</p> @enderror
    </div>
</fieldset>
