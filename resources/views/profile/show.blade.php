{{--
    Profil pengguna. Variabel dari ProfileController@show:
      $user    : user yang login
      $reviews : maksimal 10 ulasan terbaru milik user (relasi product)
--}}
@extends('layouts.app')

@section('title', 'Profil Saya')

@push('styles')
    @include('partials.panel-styles')
@endpush

@section('content')
<div class="aw-container aw-panel">
    <header class="aw-panel__head">
        <h1>Profil Saya</h1>
        <div class="aw-panel__actions">
            @if ($user->isAdmin())
                <a class="aw-btn" href="{{ route('admin.dashboard') }}">Ke dashboard admin</a>
            @elseif ($user->isSeller())
                <a class="aw-btn" href="{{ route('seller.dashboard') }}">Ke dashboard penjual</a>
            @endif
            <a class="aw-btn aw-btn--primary" href="{{ route('profile.edit') }}">Edit profil</a>
        </div>
    </header>

    <section class="aw-profile" aria-label="Informasi akun">
        <div class="aw-profile__who">
            <span class="aw-avatar" aria-hidden="true">{{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}</span>
            <div>
                <strong>{{ $user->name }}</strong><br>
                <span class="aw-badge aw-badge--role">{{ $user->role_label }}</span>
            </div>
        </div>

        <dl>
            <dt>Email</dt>
            <dd>{{ $user->email }}</dd>

            <dt>Telepon</dt>
            <dd>{{ $user->phone ?: 'Belum diisi' }}</dd>

            <dt>Alamat</dt>
            <dd>{{ $user->address ?: 'Belum diisi' }}</dd>

            <dt>Bergabung</dt>
            <dd>{{ $user->created_at?->format('d/m/Y') ?? '-' }}</dd>
        </dl>
    </section>

    @if ($user->isBuyer())
        <h2>Ulasan saya</h2>

        @if ($reviews->isEmpty())
            <p class="aw-empty">
                Anda belum menulis ulasan.
                <a href="{{ route('products.index') }}">Lihat katalog</a> untuk menemukan produk.
            </p>
        @else
            <ul class="aw-review-list">
                @foreach ($reviews as $review)
                    <li class="aw-review-item">
                        @if ($review->product)
                            <a href="{{ route('products.show', $review->product) }}">{{ $review->product->name }}</a>
                        @else
                            <span class="aw-muted">Produk dihapus</span>
                        @endif
                        <div>
                            <span class="aw-stars" role="img" aria-label="Rating {{ $review->rating }} dari 5">{{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}</span>
                            <span class="aw-muted">&middot; {{ $review->created_at?->format('d/m/Y') }}</span>
                        </div>
                        @if ($review->comment)
                            <p>{{ $review->comment }}</p>
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif
    @endif
</div>
@endsection