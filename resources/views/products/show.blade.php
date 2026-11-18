@extends('layouts.app')
@section('title', $product->name.' — After Wear')
@section('content')
@php
  $wa = 'https://wa.me/'.preg_replace('/\D/', '', $product->seller->phone ?? '').'?text='.urlencode('Halo, saya tertarik dengan '.$product->name.' di After Wear. Apakah barang ini masih tersedia?');
  $dist = $distribution ?? [5 => 85, 4 => 12, 3 => 3, 2 => 0, 1 => 0];
@endphp
<div class="wrap">
  <p class="small mute" style="padding-top:16px">Beranda / {{ $product->category->name ?? 'Katalog' }} / <b style="color:#000">{{ $product->name }}</b></p>
  <section class="detail">
    <div class="gal">
      <div class="main"><img src="{{ $product->cover_url ?? asset('images/placeholder.jpg') }}" alt="{{ $product->name }}"></div>
      <div class="thumbs">
        @foreach(($product->media ?? [])->take(4) as $m)<img src="{{ $m->url }}" alt="Foto {{ $loop->iteration }} {{ $product->name }}">@endforeach
      </div>
    </div>
    <div>
      <span class="badge">Tersedia</span> <span class="badge gray">Terverifikasi AW</span>
      <p class="small mute" style="margin-top:12px">{{ $product->category->name ?? '' }}</p>
      <h1>{{ $product->name }}</h1>
      <div class="price">Rp {{ number_format($product->price, 0, ',', '.') }}
        @if(!empty($product->original_price))<s class="mute small" style="font-weight:400">Rp {{ number_format($product->original_price, 0, ',', '.') }}</s>@endif</div>

      <table class="spec">
        <tr><td colspan="2"><b>Spesifikasi Pakaian</b> <span class="small mute" style="float:right">SKU: {{ $product->sku ?? '-' }}</span></td></tr>
        <tr><td>Bahan</td><td>{{ $product->material ?? '-' }}</td></tr>
        <tr><td>Ukuran</td><td>{{ $product->size ?? '-' }}</td></tr>
        <tr><td>Lama Pakai</td><td>{{ $product->usage_duration ?? '-' }}</td></tr>
        <tr><td>Kondisi Detail</td><td>{{ $product->condition_detail ?? '-' }}</td></tr>
      </table>

      @if(!empty($product->flaw_note))
      <div class="note"><b class="small">Catatan Kekurangan Barang (Transparansi Kurasi)</b><p class="small">{{ $product->flaw_note }}</p></div>
      @endif

      <div class="card seller">
        <div><b>{{ $product->seller->shop_name ?? $product->seller->name ?? '-' }}</b><br>
          <span class="small mute">★ {{ number_format($product->seller->rating ?? 0, 1) }} / 5.0 • {{ $product->seller->city ?? $product->location ?? '' }}</span></div>
        <a class="small" style="text-decoration:underline" href="#">Kunjungi Toko</a>
      </div>

      <a class="btn dark block" style="margin-top:16px;padding:14px" href="{{ $wa }}" target="_blank" rel="noopener">Hubungi Penjual via WhatsApp</a>
      <p class="small mute" style="text-align:center;margin-top:8px">Transaksi berlangsung langsung antara pembeli dan penjual melalui WhatsApp. Tanpa potongan biaya marketplace.</p>
    </div>
  </section>

  <section class="sec" style="padding-bottom:0">
    <h2 style="margin-bottom:4px">Rating &amp; Ulasan Pembeli</h2>
    <p class="mute" style="margin-bottom:20px">Ulasan otentik dari pembeli yang telah menerima dan memverifikasi barang ini.</p>
    <div class="rating">
      <div><span class="num">{{ number_format($product->rating ?? 0, 1) }}</span> <span class="mute">/ 5.0</span><p class="small mute">Berdasarkan {{ $product->reviews->count() }} transaksi terverifikasi</p></div>
      <div>@foreach($dist as $star => $pct)<div class="bar"><span>{{ $star }} ★</span><i><b style="width:{{ $pct }}%"></b></i><span>{{ $pct }}%</span></div>@endforeach</div>
      <div><b>Ingin memberi ulasan?</b><p class="small mute">After Wear hanya mengizinkan ulasan dari pembeli terverifikasi guna menjamin kredibilitas penjual UMKM kami.</p>
        @guest<a class="btn dark" href="{{ url('/login') }}">Masuk</a>@else<a class="btn dark" href="#">Tulis Ulasan</a>@endguest</div>
    </div>
    <div class="grid g3" style="margin-top:20px">
      @foreach($product->reviews->take(3) as $r)
        <div class="card"><b>{{ $r->user->name }}</b> <span class="small mute" style="float:right">{{ $r->created_at->diffForHumans() }}</span>
          <p class="small">{{ str_repeat('★', $r->rating) }}</p><p class="small">“{{ $r->comment }}”</p></div>
      @endforeach
    </div>
  </section>

  @if(isset($related) && $related->isNotEmpty())
  <section class="sec"><h2>{{ $product->category->name ?? 'Produk' }} Pilihan Kurator</h2>
    <div class="grid g4">@foreach($related as $product)@include('partials.product-card', ['product' => $product])@endforeach</div>
  </section>
  @endif
</div>
@endsection