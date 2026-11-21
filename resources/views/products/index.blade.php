@extends('layouts.app')
@section('title', 'Katalog Preloved — After Wear')
@section('content')
<div class="wrap" style="padding-top:24px">
  <p class="small mute">Beranda / Katalog Preloved @if(request('q'))/ <b style="color:#000">Hasil Pencarian</b>@endif</p>
  <h1 style="font-size:36px;margin-top:8px">
    @if(request('q'))Hasil untuk “{{ request('q') }}” @else Katalog Preloved @endif
    <span class="small mute" style="font-family:'Plus Jakarta Sans'">({{ $products->total() }} kurasi ditemukan)</span>
  </h1>

  @if(request()->hasAny(['category','condition','location','min','max']))
  <div class="chips">
    <span class="small mute">Filter Aktif:</span>
    @foreach(['category'=>'Kategori','condition'=>'Kondisi','location'=>'Lokasi','min'=>'Harga min','max'=>'Harga maks'] as $k => $label)
      @if(request($k) !== null && request($k) !== '')
        <span class="chip">{{ $label }}: {{ $k === 'category' ? ($categories->firstWhere('slug', request('category'))?->name ?? request('category')) : request($k) }}</span>
      @endif
    @endforeach
    <a class="small" style="text-decoration:underline" href="{{ route('products.index', array_filter(['q' => request('q')])) }}">Hapus semua</a>
  </div>
  @endif

  <div class="layout" style="margin-top:20px">
    <form class="side" method="GET" action="{{ url('/products') }}">
      <input type="hidden" name="q" value="{{ request('q') }}">
      <h3 style="font-size:22px">Filter Kurasi</h3>
      <h4>Kategori Pakaian</h4>
      @foreach($categories as $c)
        <label><span><input type="radio" name="category" value="{{ $c->slug }}" @checked(request('category') === $c->slug)> {{ $c->name }}</span><span class="mute">{{ $counts[$c->slug] ?? 0 }}</span></label>
      @endforeach
      <h4>Lokasi Pelapak (UMKM)</h4>
      <input type="text" name="location" value="{{ request('location') }}" placeholder="Makassar & Sekitarnya">
      <h4>Rentang Harga (IDR)</h4>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px">
        <input type="number" name="min" value="{{ request('min') }}" placeholder="50.000" min="0">
        <input type="number" name="max" value="{{ request('max') }}" placeholder="250.000" min="0">
      </div>
      <h4>Kondisi Pakaian</h4>
      @foreach($conditions as $value => $label)
        <label><span><input type="radio" name="condition" value="{{ $value }}" @checked(request('condition') === $value)> {{ $label }}</span></label>
      @endforeach
      <button class="btn dark block" style="margin-top:16px">Terapkan Filter</button>
      <div class="card small" style="margin-top:16px"><b>Dampak Sirkularitas</b><p class="mute">Membeli kemeja preloved menghemat sekitar 2.700 liter air dan mencegah limbah tekstil.</p></div>
    </form>

    <div>
      <div class="grid g3">
        @forelse($products as $product)
          <x-product-card :product="$product" />
        @empty
          <p class="mute">Tidak ada produk yang cocok. Coba ubah atau hapus filter.</p>
        @endforelse
      </div>
      <div class="pager">{{ $products->withQueryString()->links() }}</div>
    </div>
  </div>
</div>
@endsection