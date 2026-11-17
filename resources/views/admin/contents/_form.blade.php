{{--
    Isi form konten website, dipakai create dan edit.
    Variabel: $sections, $content (null saat tambah)
--}}
@php
    $content = $content ?? null;
    $v = fn (string $field, $default = '') => old($field, $content?->{$field} ?? $default);
    $metadata = old('metadata', $content?->metadata ? json_encode($content->metadata, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) : '');
    $active = old('is_active', $content ? (bool) $content->is_active : true);
@endphp

<div class="aw-field">
    <label for="section">Bagian <span aria-hidden="true">*</span></label>
    <select class="aw-input" id="section" name="section" required>
        <option value="">Pilih bagian</option>
        @foreach ($sections as $value => $label)
            <option value="{{ $value }}" @selected($v('section') === $value)>{{ $label }}</option>
        @endforeach
    </select>
    @error('section') <p class="aw-field__error">{{ $message }}</p> @enderror
</div>

<div class="aw-field">
    <label for="key">Key (opsional)</label>
    <input class="aw-input" id="key" name="key" type="text" maxlength="255" value="{{ $v('key') }}">
    <p class="aw-field__hint">Pengenal unik yang dipakai kode dan seeder, contoh: <code>hero_main</code>.</p>
    @error('key') <p class="aw-field__error">{{ $message }}</p> @enderror
</div>

<div class="aw-field">
    <label for="title">Judul <span aria-hidden="true">*</span></label>
    <input class="aw-input" id="title" name="title" type="text" maxlength="255" value="{{ $v('title') }}" required>
    @error('title') <p class="aw-field__error">{{ $message }}</p> @enderror
</div>

<div class="aw-field">
    <label for="subtitle">Subjudul</label>
    <input class="aw-input" id="subtitle" name="subtitle" type="text" maxlength="255" value="{{ $v('subtitle') }}">
    @error('subtitle') <p class="aw-field__error">{{ $message }}</p> @enderror
</div>

<div class="aw-field">
    <label for="content">Isi konten</label>
    <textarea class="aw-input" id="content" name="content">{{ $v('content') }}</textarea>
    @error('content') <p class="aw-field__error">{{ $message }}</p> @enderror
</div>

<div class="aw-field">
    <label for="image">URL gambar</label>
    <input class="aw-input" id="image" name="image" type="text" maxlength="255" placeholder="https://... atau /images/banner.jpg" value="{{ $v('image') }}">
    @error('image') <p class="aw-field__error">{{ $message }}</p> @enderror
</div>

<fieldset>
    <legend>Tombol (opsional)</legend>
    <div class="aw-field">
        <label for="button_text">Teks tombol</label>
        <input class="aw-input" id="button_text" name="button_text" type="text" maxlength="255" value="{{ $v('button_text') }}">
        @error('button_text') <p class="aw-field__error">{{ $message }}</p> @enderror
    </div>
    <div class="aw-field">
        <label for="button_url">Link tombol</label>
        <input class="aw-input" id="button_url" name="button_url" type="text" maxlength="255" placeholder="/products" value="{{ $v('button_url') }}">
        @error('button_url') <p class="aw-field__error">{{ $message }}</p> @enderror
    </div>
</fieldset>

<fieldset>
    <legend>Pengaturan lain</legend>
    <div class="aw-field">
        <label for="order">Urutan tampil</label>
        <input class="aw-input" id="order" name="order" type="number" min="0" value="{{ $v('order', 0) }}">
        @error('order') <p class="aw-field__error">{{ $message }}</p> @enderror
    </div>
    <div class="aw-field">
        <label for="metadata">Metadata (JSON, opsional)</label>
        <textarea class="aw-input" id="metadata" name="metadata" spellcheck="false" placeholder='{"icon":"fa-leaf"}'>{{ $metadata }}</textarea>
        @error('metadata') <p class="aw-field__error">{{ $message }}</p> @enderror
    </div>
    <div class="aw-field">
        <label style="display:flex; align-items:center; gap:.5rem; font-weight:500;">
            <input type="checkbox" name="is_active" value="1" @checked($active)>
            Tampilkan di website (aktif)
        </label>
    </div>
</fieldset>
