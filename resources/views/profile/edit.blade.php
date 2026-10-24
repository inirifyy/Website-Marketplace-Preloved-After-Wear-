{{--
    Form edit profil. Variabel dari ProfileController@edit: $user
    Dikirim ke route profile.update (PATCH). Role tidak bisa diubah dari sini.
--}}
@extends('layouts.app')

@section('title', 'Edit Profil')

@push('styles')
    @include('partials.panel-styles')
@endpush

@section('content')
<div class="aw-container aw-panel">
    <header class="aw-panel__head">
        <h1>Edit Profil</h1>
    </header>

    <form class="aw-form" method="POST" action="{{ route('profile.update') }}" novalidate>
        @csrf
        @method('PATCH')

        <div class="aw-field">
            <label for="name">Nama</label>
            <input class="aw-input" id="name" name="name" type="text" required maxlength="255"
                   autocomplete="name" value="{{ old('name', $user->name) }}"
                   @error('name') aria-invalid="true" @enderror>
            @error('name') <p class="aw-field__error">{{ $message }}</p> @enderror
        </div>

        <div class="aw-field">
            <label for="email">Email</label>
            <input class="aw-input" id="email" name="email" type="email" required maxlength="255"
                   autocomplete="email" value="{{ old('email', $user->email) }}"
                   @error('email') aria-invalid="true" @enderror>
            @error('email') <p class="aw-field__error">{{ $message }}</p> @enderror
        </div>

        <div class="aw-field">
            <label for="phone">Nomor telepon</label>
            <input class="aw-input" id="phone" name="phone" type="tel" maxlength="30"
                   autocomplete="tel" value="{{ old('phone', $user->phone) }}"
                   @error('phone') aria-invalid="true" @enderror>
            <p class="aw-field__hint">Opsional. Contoh: 0812 3456 7890</p>
            @error('phone') <p class="aw-field__error">{{ $message }}</p> @enderror
        </div>

        <div class="aw-field">
            <label for="address">Alamat</label>
            <textarea class="aw-input" id="address" name="address" maxlength="1000"
                      autocomplete="street-address"
                      @error('address') aria-invalid="true" @enderror>{{ old('address', $user->address) }}</textarea>
            @error('address') <p class="aw-field__error">{{ $message }}</p> @enderror
        </div>

        <fieldset>
            <legend>Ganti password (opsional)</legend>
            <p class="aw-field__hint">Kosongkan bagian ini jika tidak ingin mengganti password.</p>

            <div class="aw-field">
                <label for="current_password">Password saat ini</label>
                <input class="aw-input" id="current_password" name="current_password" type="password"
                       autocomplete="current-password"
                       @error('current_password') aria-invalid="true" @enderror>
                @error('current_password') <p class="aw-field__error">{{ $message }}</p> @enderror
            </div>

            <div class="aw-field">
                <label for="password">Password baru</label>
                <input class="aw-input" id="password" name="password" type="password"
                       autocomplete="new-password"
                       @error('password') aria-invalid="true" @enderror>
                <p class="aw-field__hint">Minimal 8 karakter.</p>
                @error('password') <p class="aw-field__error">{{ $message }}</p> @enderror
            </div>

            <div class="aw-field">
                <label for="password_confirmation">Ulangi password baru</label>
                <input class="aw-input" id="password_confirmation" name="password_confirmation"
                       type="password" autocomplete="new-password">
            </div>
        </fieldset>

        <div class="aw-panel__actions">
            <button class="aw-btn aw-btn--primary" type="submit">Simpan perubahan</button>
            <a class="aw-btn" href="{{ route('profile.show') }}">Batal</a>
        </div>
    </form>
</div>
@endsection