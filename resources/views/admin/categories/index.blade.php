@extends('layouts.app')

@section('title', 'Kelola Kategori')

@push('styles')
    @include('partials.panel-styles')
@endpush

@section('content')
<div class="aw-container aw-panel">
    <header class="aw-panel__head">
        <div>
            <h1>Kelola Kategori</h1>
            <p class="aw-panel__lead">Daftar kategori produk pakaian preloved di After Wear.</p>
        </div>
        <div class="aw-panel__actions">
            <a class="aw-btn aw-btn--primary" href="{{ route('admin.categories.create') }}">+ Tambah Kategori</a>
            <a class="aw-btn" href="{{ route('admin.dashboard') }}">Kembali ke Dashboard</a>
        </div>
    </header>

    @if (session('success'))
        <div class="aw-alert aw-alert-success" role="status">
            {{ session('success') }}
        </div>
    @endif

    {{-- Pencarian --}}
    <form method="GET" action="{{ route('admin.categories.index') }}" style="margin-bottom: 1.25rem; display: flex; gap: .5rem; max-width: 480px;">
        <input type="search" name="search" value="{{ $search ?? '' }}" placeholder="Cari nama atau deskripsi kategori..."
               style="flex: 1; padding: .5rem .75rem; border: 1px solid var(--aw-line); border-radius: .5rem; font: inherit;" />
        <button type="submit" class="aw-btn aw-btn--primary">Cari</button>
        @if (!empty($search))
            <a href="{{ route('admin.categories.index') }}" class="aw-btn">Reset</a>
        @endif
    </form>

    {{-- Tabel Kategori --}}
    @if ($categories->count() > 0)
        <div class="aw-table-wrap">
            <table class="aw-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">Urutan</th>
                        <th>Kategori</th>
                        <th>Slug</th>
                        <th>Deskripsi</th>
                        <th style="text-align: center;">Jumlah Produk</th>
                        <th style="text-align: center;">Status</th>
                        <th style="text-align: right; width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $cat)
                        <tr>
                            <td style="font-weight: 600;">#{{ $cat->order }}</td>
                            <td>
                                <div style="display: flex; align-items: center; gap: .5rem;">
                                    @if ($cat->image)
                                        <img src="{{ $cat->image }}" alt="{{ $cat->name }}" class="aw-thumb" />
                                    @else
                                        <div class="aw-thumb--empty">{{ $cat->name }}</div>
                                    @endif
                                    <strong>{{ $cat->name }}</strong>
                                </div>
                            </td>
                            <td><code>{{ $cat->slug }}</code></td>
                            <td class="aw-table__comment">{{ $cat->description ?: '-' }}</td>
                            <td style="text-align: center;">
                                <span class="aw-badge aw-badge--role">{{ $cat->products_count ?? 0 }} produk</span>
                            </td>
                            <td style="text-align: center;">
                                @if ($cat->is_active)
                                    <span class="aw-badge aw-badge--approved">Aktif</span>
                                @else
                                    <span class="aw-badge aw-badge--rejected">Nonaktif</span>
                                @endif
                            </td>
                            <td style="text-align: right;">
                                <div style="display: inline-flex; gap: .35rem;">
                                    <a href="{{ route('admin.categories.edit', $cat) }}" class="aw-btn aw-btn--small">Ubah</a>
                                    <form method="POST" action="{{ route('admin.categories.destroy', $cat) }}" onsubmit="return confirm('Hapus kategori {{ $cat->name }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="aw-btn aw-btn--small aw-btn--danger">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div style="margin-top: 1.25rem;">
            {{ $categories->links() }}
        </div>
    @else
        <div class="aw-empty">
            <p>Belum ada kategori yang ditambahkan.</p>
            <a href="{{ route('admin.categories.create') }}" class="aw-btn aw-btn--primary" style="margin-top: .5rem;">+ Tambah Kategori Pertama</a>
        </div>
    @endif
</div>
@endsection

