{{-- Form ubah konten website. Variabel: $content, $sections --}}
@extends('layouts.app')

@section('title', 'Ubah Konten')

@push('styles')
    @include('partials.panel-styles')
@endpush

@section('content')
<div class="aw-container aw-panel">
    <header class="aw-panel__head">
        <div>
            <h1>Ubah Konten</h1>
            <p class="aw-panel__lead">{{ $content->title }}</p>
        </div>
        <a class="aw-btn" href="{{ route('admin.contents.index') }}">Kembali ke daftar</a>
    </header>

    <form class="aw-form" method="POST" action="{{ route('admin.contents.update', $content) }}">
        @csrf
        @method('PUT')
        @include('admin.contents._form', ['content' => $content])
        <button class="aw-btn aw-btn--primary" type="submit">Simpan perubahan</button>
    </form>
</div>
@endsection
