{{--
    Daftar konten website. Variabel dari Admin\SiteContentController@index:
      $contents : paginator SiteContent
      $sections : [key => label] bagian konten yang dikenali
--}}
@extends('layouts.app')

@section('title', 'Kelola Konten')

@push('styles')
    @include('partials.panel-styles')
@endpush

@section('content')
<div class="aw-container aw-panel">
    <header class="aw-panel__head">
        <div>
            <h1>Kelola Konten Website</h1>
            <p class="aw-panel__lead">{{ $contents->total() }} konten: banner beranda, edukasi, statistik, dan lainnya.</p>
        </div>
        <div class="aw-panel__actions">
            <a class="aw-btn aw-btn--primary" href="{{ route('admin.contents.create') }}">+ Tambah Konten</a>
            <a class="aw-btn" href="{{ route('admin.dashboard') }}">Kembali ke dashboard</a>
        </div>
    </header>

    <form class="aw-filter" method="GET" action="{{ route('admin.contents.index') }}">
        <div>
            <label for="q">Cari judul</label>
            <input class="aw-input" id="q" name="q" type="search" value="{{ request('q') }}">
        </div>
        <div>
            <label for="section">Bagian</label>
            <select class="aw-input" id="section" name="section">
                <option value="">Semua</option>
                @foreach ($sections as $value => $label)
                    <option value="{{ $value }}" @selected(request('section') === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <button class="aw-btn aw-btn--primary" type="submit">Terapkan</button>
        @if (request()->filled('q') || request()->filled('section'))
            <a class="aw-btn" href="{{ route('admin.contents.index') }}">Reset</a>
        @endif
    </form>

    @if ($contents->isEmpty())
        <p class="aw-empty">Belum ada konten{{ request()->filled('q') || request()->filled('section') ? ' yang cocok dengan filter' : '' }}.</p>
    @else
        <div class="aw-table-wrap">
            <table class="aw-table">
                <thead>
                    <tr>
                        <th scope="col">Urutan</th>
                        <th scope="col">Bagian</th>
                        <th scope="col">Judul</th>
                        <th scope="col">Key</th>
                        <th scope="col">Status</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($contents as $content)
                        <tr>
                            <td>#{{ $content->order }}</td>
                            <td><span class="aw-badge aw-badge--role">{{ $sections[$content->section] ?? $content->section }}</span></td>
                            <td class="aw-table__comment">
                                <strong>{{ $content->title }}</strong>
                                @if ($content->subtitle)
                                    <div class="aw-muted">{{ $content->subtitle }}</div>
                                @endif
                            </td>
                            <td>{!! $content->key ? '<code>'.e($content->key).'</code>' : '<span class="aw-muted">-</span>' !!}</td>
                            <td>
                                @if ($content->is_active)
                                    <span class="aw-badge aw-badge--approved">Aktif</span>
                                @else
                                    <span class="aw-badge aw-badge--rejected">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <div style="display: inline-flex; gap: .35rem;">
                                    <a class="aw-btn aw-btn--small" href="{{ route('admin.contents.edit', $content) }}">Ubah</a>
                                    <form method="POST" action="{{ route('admin.contents.destroy', $content) }}"
                                          onsubmit="return confirm('Hapus konten {{ $content->title }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="aw-btn aw-btn--danger aw-btn--small" type="submit">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @include('partials.pager', ['paginator' => $contents])
    @endif
</div>
@endsection
