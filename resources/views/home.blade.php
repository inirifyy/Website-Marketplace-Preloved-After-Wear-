@extends('layouts.app')
@section('title', 'After Wear — Fesyen Preloved Terkurasi')
@section('content')
@php
  $categories = [['Atasan','Kemeja, Kaos & Blus'],['Bawahan','Kulot, Denim & Rok'],['Dress','Midi, Maxi & Casual'],['Sepatu','Loafers, Boots & Sneaker'],['Tas','Tote, Kulit & Selempang'],['Aksesoris','Syal, Sabuk & Topi']];
  $why = [['Kurasi Berkualitas','Pemeriksaan kondisi ketat sebelum produk ditayangkan: keaslian bahan, kebersihan standar laundry ozon, dan grading akurat.'],
          ['Harga Masuk Akal','Pakaian bermerek dan arsip lokal berkualitas dengan diskon hingga 70% di bawah harga butik resmi.'],
          ['Dampak Nyata','Perpanjang siklus hidup pakaian dan kurangi limbah kain sintetis di TPA lokal. Setiap transaksi terdata jejak lingkungannya.'],
          ['Aman via WhatsApp','Komunikasi langsung dan transparan dengan penjual terverifikasi. Konfirmasi ukuran dan video real time sebelum membayar.']];
@endphp
<div class="wrap">
  <section class="hero">
    <div>
      <h1>Ubah Cara Berpakaian, Kurangi Limbah Tekstil Bersama After Wear.</h1>
      <p class="mute">Setiap helai pakaian preloved yang Anda pilih memangkas hingga 82% jejak karbon dan menghemat ribuan liter air. Mari wujudkan lemari berkelanjutan untuk masa depan Indonesia.</p>
      <div class="row">
        <a class="btn dark" href="{{ url('/education') }}">Pelajari Dampaknya</a>
        <a class="btn" href="{{ url('/products') }}">Jelajah Kurasi</a>
      </div>
    </div>
    <figure>
      <img src="{{ asset('images/hero.png') }}" alt="Tumpukan kemeja preloved terlipat rapi">
      <figcaption><span class="small mute">Statistik Dampak UMKM</span><br><b>12.450+ Kg Pakaian Terselamatkan</b></figcaption>
    </figure>
  </section>
</div>

<section class="sec"><div class="wrap">
  <h2>Kategori Pilihan</h2>
  <div class="grid g3 cats">
    @foreach($categories as [$name, $desc])
      <a href="{{ url('/products?category='.urlencode($name)) }}"><b>{{ $name }}</b><span class="small mute">{{ $desc }}</span></a>
    @endforeach
  </div>
</div></section>

<section class="sec white"><div class="wrap">
  <h2>Kenapa After Wear?</h2>
  <p class="mute" style="max-width:640px;margin:-12px 0 24px">Kami mendefinisikan ulang makna berpakaian dengan menghubungkan konsumen berkesadaran tinggi dengan UMKM thrift terkurasi. Menghadirkan fesyen sirkular yang transparan, etis, dan bermartabat.</p>
  <div class="grid g4">
    @foreach($why as [$t, $d])
      <div class="card"><h3 style="font-size:20px;margin-bottom:8px">{{ $t }}</h3><p class="mute small">{{ $d }}</p></div>
    @endforeach
  </div>
</div></section>

<section class="sec"><div class="wrap">
  <h2>Produk Terbaru</h2>
  <div class="grid g3">
    @forelse($featuredProducts->take(5) as $product)
      @include('partials.product-card', ['product' => $product])
    @empty
      <p class="mute">Belum ada produk yang ditayangkan.</p>
    @endforelse
  </div>
  <div style="text-align:center;margin-top:32px"><a class="btn" href="{{ url('/products') }}">Lihat Semua Produk</a></div>
</div></section>

<section class="sec white"><div class="wrap">
  <div style="display:flex;justify-content:space-between;align-items:baseline"><h2>Cerita Pembeli &amp; Penjual</h2><a href="{{ url('/testimonials') }}"><b>Lihat Semua Testimoni</b></a></div>
  <div class="grid g2">
    <div class="card"><p>★★★★★</p><p>“Menemukan kemeja bahan premium dengan harga sepertiga dari toko aslinya, kondisinya masih seperti baru tanpa cacat! Transaksi via WhatsApp juga super cepat dan ramah.”</p><p style="margin-top:16px"><b>Dian Sastrowardoyo</b><br><span class="small mute">Pembeli Rutin • Jakarta</span></p></div>
    <div class="card"><p>★★★★★</p><p>“Sebagai pelaku UMKM thrift, platform ini memberi panggung terhormat untuk koleksi pakaian kurasi saya. Penjualan stabil dan pembelinya sangat mengapresiasi nilai barang.”</p><p style="margin-top:16px"><b>Bagus Pratama</b><br><span class="small mute">Kurator Toko • Bandung</span></p></div>
  </div>
</div></section>

<div class="wrap" style="margin-top:48px"><div class="cta">
  <div><h2 style="font-size:30px">Punya Pakaian Preloved Berkualitas?</h2><p>Daftarkan pakaian Anda atau buka kurasi UMKM Anda sendiri. Ubah koleksi lemari menjadi penghasilan sirkular bernilai tinggi.</p></div>
  <a class="btn" style="background:#fff;color:#000" href="{{ url('/seller/submissions/create') }}">Mulai Jual Barang</a>
</div></div>
@endsection