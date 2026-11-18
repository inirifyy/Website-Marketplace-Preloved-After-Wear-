{{--
    Moderasi ulasan. Variabel dari AdminReviewController@index:
      $reviews : paginator Review (relasi product, reviewer)
      $q       : kata kunci pencarian
      $rating  : filter rating (0 = semua)
--}}
@extends('layouts.app')

@section('title', 'Moderasi Ulasan')

@push('styles')
    @include('partials.panel-styles')
@endpush

@section('content')
<div class="aw-container aw-panel">
    <header class="aw-panel__head">
        <div>
            <h1>Moderasi Ulasan</h1>
            <p class="aw-panel__lead">{{ $reviews->total() }} ulasan{{ ($q !== '' || $rating) ? ' sesuai filter' : '' }}.</p>
        </div>
        <a class="aw-btn" href="{{ route('admin.dashboard') }}">Kembali ke dashboard</a>
    </header>

    <form class="aw-filter" method="GET" action="{{ route('admin.reviews.index') }}">
        <div>
            <label for="q">Cari</label>
            <input class="aw-input" id="q" name="q" type="search" maxlength="100"
                   placeholder="Produk, pengulas, atau isi ulasan" value="{{ $q }}">
        </div>
        <div>
            <label for="rating">Rating</label>
            <select class="aw-input" id="rating" name="rating">
                <option value="">Semua</option>
                @for ($i = 5; $i >= 1; $i--)
                    <option value="{{ $i }}" @selected($rating === $i)>{{ $i }} bintang</option>
                @endfor
            </select>
        </div>
        <button class="aw-btn aw-btn--primary" type="submit">Terapkan</button>
        @if ($q !== '' || $rating)
            <a class="aw-btn" href="{{ route('admin.reviews.index') }}">Reset</a>
        @endif
    </form>

    @if ($reviews->isEmpty())
        <p class="aw-empty">Tidak ada ulasan{{ ($q !== '' || $rating) ? ' yang cocok dengan filter' : ' saat ini' }}.</p>
    @else
        <div class="aw-table-wrap">
            <table class="aw-table">
                <thead>
                    <tr>
                        <th scope="col">Produk</th>
                        <th scope="col">Pengulas</th>
                        <th scope="col">Rating</th>
                        <th scope="col">Ulasan</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col"><span class="sr-only">Aksi</span></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reviews as $review)
                        <tr>
                            <td>
                                @if ($review->product)
                                    <a href="{{ route('products.show', $review->product) }}">{{ $review->product->name }}</a>
                                @else
                                    <span class="aw-muted">Produk dihapus</span>
                                @endif
                            </td>
                            <td>
                                {{ $review->reviewer?->name ?? 'Pengguna dihapus' }}
                                @if ($review->reviewer)
                                    <br><span class="aw-muted">{{ $review->reviewer->email }}</span>
                                @endif
                            </td>
                            <td>
                                <span class="aw-stars" role="img" aria-label="Rating {{ $review->rating }} dari 5">{{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}</span>
                            </td>
                            <td class="aw-table__comment">
                                @if ($review->comment)
                                    {{ $review->comment }}
                                @else
                                    <span class="aw-muted">Tanpa komentar</span>
                                @endif
                            </td>
                            <td>{{ $review->created_at?->format('d/m/Y') }}</td>
                            <td>
                                <form method="POST" action="{{ route('admin.reviews.destroy', $review) }}"
                                      onsubmit="return confirm('Hapus ulasan ini? Tindakan ini tidak bisa dibatalkan.')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="aw-btn aw-btn--danger aw-btn--small" type="submit">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if ($reviews->hasPages())
            <nav class="aw-pager" aria-label="Halaman ulasan">
                @if ($reviews->onFirstPage())
                    <span class="aw-muted">Sebelumnya</span>
                @else
                    <a class="aw-btn aw-btn--small" href="{{ $reviews->previousPageUrl() }}" rel="prev">Sebelumnya</a>
                @endif

                <span>Halaman {{ $reviews->currentPage() }} dari {{ $reviews->lastPage() }}</span>

                @if ($reviews->hasMorePages())
                    <a class="aw-btn aw-btn--small" href="{{ $reviews->nextPageUrl() }}" rel="next">Berikutnya</a>
                @else
                    <span class="aw-muted">Berikutnya</span>
                @endif
            </nav>
        @endif
    @endif
</div>
@endsection