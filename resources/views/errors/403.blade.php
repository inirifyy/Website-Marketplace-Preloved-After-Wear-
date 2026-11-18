@extends('layouts.app')

@section('title', 'Akses Ditolak')

@push('styles')
    @include('partials.panel-styles')
@endpush

@section('content')
<div class="aw-container" style="padding-block: 4rem; text-align: center;">
    <h1 style="font-size: 3rem; margin: 0;">403</h1>
    <p style="font-size: 1.15rem; margin: .5rem 0 1.5rem;">
        {{ $exception->getMessage() ?: 'Anda tidak memiliki akses ke halaman ini.' }}
    </p>
    <a class="aw-btn aw-btn--primary" href="{{ route('home') }}">Kembali ke Beranda</a>
</div>
@endsection
