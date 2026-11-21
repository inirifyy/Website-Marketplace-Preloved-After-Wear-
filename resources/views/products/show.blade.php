{{--
    Detail produk. Variabel dari ProductController@show:
      $product, $reviews, $reviewCount, $averageRating, $distribution,
      $canReview, $myReview, $related
--}}
@extends('layouts.app')
@section('title', $product->name.' — After Wear')
@section('content')
@php
  $sellerPhone = \App\Support\Phone::normalize($product->seller->phone ?? '');
  $wa = $sellerPhone
      ? 'https://wa.me/'.$sellerPhone.'?text='.urlencode('Halo, saya tertarik dengan '.$product->name.' di After Wear. Apakah barang ini masih tersedia?')
      : null;
  $soldOut = $product->status === 'sold_out';
@endphp
<div class="wrap">
  <p class="small mute" style="padding-top:16px">
    <a href="{{ route('home') }}">Beranda</a> /
    <a href="{{ route('products.index', array_filter(['category' => $product->category?->slug])) }}">{{ $product->category->name ?? 'Katalog' }}</a> /
    <b style="color:#000">{{ $product->name }}</b>
  </p>

  <section class="detail">
    <div class="gal">
      <div class="main"><img src="{{ $product->cover_url }}" alt="{{ $product->name }}"></div>
      <div class="thumbs">
        @foreach($product->media->where('media_type', 'image')->take(4) as $m)
          <img src="{{ $m->url }}" alt="Foto {{ $loop->iteration }} {{ $product->name }}">
        @endforeach
      </div>
    </div>

    <div>
      @if($soldOut)<span class="badge gray">Habis</span>@else<span class="badge">Tersedia</span>@endif
      <span class="badge gray">Terverifikasi AW</span>
      <p class="small mute" style="margin-top:12px">{{ $product->category->name ?? '' }}</p>
      <h1>{{ $product->name }}</h1>
      <div class="price">Rp {{ number_format((float) $product->price, 0, ',', '.') }}</div>

      <table class="spec">
        <tr><td colspan="2"><b>Spesifikasi Pakaian</b></td></tr>
        <tr><td>Kondisi</td><td>{{ $product->item_condition ?: '-' }}</td></tr>
        <tr><td>Bahan</td><td>{{ $product->material ?: '-' }}</td></tr>
        <tr><td>Lama Pakai</td><td>{{ $product->usage_duration ?: '-' }}</td></tr>
        <tr><td>Lokasi</td><td>{{ $product->location ?: '-' }}</td></tr>
      </table>

      @if($product->description)
        <p style="margin-top:16px;white-space:pre-line">{{ $product->description }}</p>
      @endif

      @if(!empty($product->flaws))
      <div class="note"><b class="small">Catatan Kekurangan Barang (Transparansi Kurasi)</b><p class="small">{{ $product->flaws }}</p></div>
      @endif

      <div class="card seller">
        <div><b>{{ $product->seller->name ?? '-' }}</b><br>
          <span class="small mute">Penjual • {{ $product->location ?? 'Indonesia' }}</span></div>
      </div>

      @if($wa && !$soldOut)
        <a class="btn dark block" style="margin-top:16px;padding:14px" href="{{ $wa }}" target="_blank" rel="noopener">Hubungi Penjual via WhatsApp</a>
      @elseif($soldOut)
        <p class="small mute" style="margin-top:16px;text-align:center">Barang ini sudah habis terjual.</p>
      @else
        <p class="small mute" style="margin-top:16px;text-align:center">Penjual belum mencantumkan nomor WhatsApp.</p>
      @endif
      <p class="small mute" style="text-align:center;margin-top:8px">Transaksi berlangsung langsung antara pembeli dan penjual melalui WhatsApp. Tanpa potongan biaya marketplace.</p>
    </div>
  </section>

  <section class="sec" id="ulasan" style="padding-bottom:0">
    <h2 style="margin-bottom:4px">Rating &amp; Ulasan Pembeli</h2>
    <p class="mute" style="margin-bottom:20px">Ulasan dari pembeli terdaftar dengan nomor HP terverifikasi, untuk menjaga kredibilitas penjual UMKM kami.</p>

    <div class="rating">
      <div>
        <span class="num">{{ number_format($averageRating, 1) }}</span> <span class="mute">/ 5.0</span>
        <p class="small mute">Berdasarkan {{ $reviewCount }} ulasan</p>
      </div>
      <div>
        @foreach($distribution as $star => $pct)
          <div class="bar"><span>{{ $star }} ★</span><i><b style="width:{{ $pct }}%"></b></i><span>{{ $pct }}%</span></div>
        @endforeach
      </div>
      <div>
        <b>Ingin memberi ulasan?</b>
        @guest
          <p class="small mute">Masuk dulu sebagai pembeli untuk menulis ulasan.</p>
          <a class="btn dark" href="{{ route('login') }}">Masuk</a>
        @else
          @if($myReview)
            <p class="small mute">Anda sudah mengulas produk ini. Terima kasih!</p>
          @elseif(!auth()->user()->isBuyer())
            <p class="small mute">Hanya akun pembeli yang dapat menulis ulasan.</p>
          @elseif(!auth()->user()->hasVerifiedPhone())
            <p class="small mute">Verifikasi nomor HP Anda dulu untuk menulis ulasan.</p>
            <a class="btn dark" href="{{ route('phone.verification.notice') }}">Verifikasi Nomor</a>
          @endif
        @endguest
      </div>
    </div>

    @if($canReview)
      <form method="POST" action="{{ route('products.reviews.store', $product) }}" class="card" style="margin-top:20px;max-width:560px">
        @csrf
        <b>Tulis ulasan Anda</b>
        <div style="margin:10px 0">
          @for($i = 5; $i >= 1; $i--)
            <label style="margin-right:10px;cursor:pointer">
              <input type="radio" name="rating" value="{{ $i }}" @checked((int) old('rating') === $i) required> {{ $i }} ★
            </label>
          @endfor
        </div>
        <textarea name="comment" rows="3" maxlength="1000" placeholder="Ceritakan kondisi barang dan pengalaman Anda (opsional)" style="width:100%;box-sizing:border-box">{{ old('comment') }}</textarea>
        <button type="submit" class="btn dark" style="margin-top:10px">Kirim Ulasan</button>
      </form>
    @endif

    <div class="grid g3" style="margin-top:20px">
      @forelse($reviews->take(6) as $r)
        <div class="card">
          <b>{{ $r->reviewer->name ?? 'Pengguna After Wear' }}</b>
          <span class="small mute" style="float:right">{{ $r->created_at?->diffForHumans() }}</span>
          <p class="small">{{ str_repeat('★', (int) $r->rating) }}{{ str_repeat('☆', 5 - (int) $r->rating) }}</p>
          @if($r->comment)<p class="small">“{{ $r->comment }}”</p>@endif
        </div>
      @empty
        <p class="mute">Belum ada ulasan untuk produk ini.</p>
      @endforelse
    </div>
  </section>

  @if($related->isNotEmpty())
  <section class="sec"><h2>{{ $product->category->name ?? 'Produk' }} Pilihan Kurator</h2>
    <div class="grid g4">
      @foreach($related as $item)
        <x-product-card :product="$item" />
      @endforeach
    </div>
  </section>
  @endif
</div>
@endsection
