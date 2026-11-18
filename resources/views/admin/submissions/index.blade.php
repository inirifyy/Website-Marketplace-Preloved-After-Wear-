{{--
    Verifikasi pengajuan barang dari penjual. Variabel dari Admin\ProductSubmissionController@index:
      $submissions : paginator ProductSubmission (relasi seller, category, media)
      $status      : pending | approved | rejected (tab yang sedang dibuka)
--}}
@extends('layouts.app')

@section('title', 'Verifikasi Pengajuan')

@push('styles')
    @include('partials.panel-styles')
    <style>
        .aw-tabs { display: flex; flex-wrap: wrap; gap: .5rem; margin-bottom: 1rem; }
        .aw-tabs .aw-btn[aria-current="page"] { background: var(--aw-sage-dark); border-color: var(--aw-sage-dark); color: var(--aw-white); }
        .aw-reject summary { cursor: pointer; display: inline-block; }
        .aw-reject form { margin-top: .5rem; min-width: 14rem; }
    </style>
@endpush

@section('content')
@php
    $statusLabels = ['pending' => 'Menunggu', 'approved' => 'Disetujui', 'rejected' => 'Ditolak'];
@endphp
<div class="aw-container aw-panel">
    <header class="aw-panel__head">
        <div>
            <h1>Verifikasi Pengajuan</h1>
            <p class="aw-panel__lead">{{ $submissions->total() }} pengajuan berstatus {{ strtolower($statusLabels[$status]) }}.</p>
        </div>
        <a class="aw-btn" href="{{ route('admin.dashboard') }}">Kembali ke dashboard</a>
    </header>

    <nav class="aw-tabs" aria-label="Filter status pengajuan">
        @foreach ($statusLabels as $value => $label)
            <a class="aw-btn" href="{{ route('admin.submissions.index', ['status' => $value]) }}"
               @if ($status === $value) aria-current="page" @endif>{{ $label }}</a>
        @endforeach
    </nav>

    @if ($submissions->isEmpty())
        <p class="aw-empty">Tidak ada pengajuan berstatus {{ strtolower($statusLabels[$status]) }}.</p>
    @else
        <div class="aw-table-wrap">
            <table class="aw-table">
                <thead>
                    <tr>
                        <th scope="col">Foto</th>
                        <th scope="col">Barang</th>
                        <th scope="col">Penjual</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Status</th>
                        <th scope="col">Diajukan</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($submissions as $submission)
                        @php
                            $photos = $submission->media->where('media_type', 'image');
                            $video  = $submission->media->firstWhere('media_type', 'video');
                        @endphp
                        <tr>
                            <td>
                                <div style="display:flex; flex-wrap:wrap; gap:.25rem; max-width: 9rem;">
                                    @forelse ($photos as $photo)
                                        <a href="{{ $photo->url }}" target="_blank" rel="noopener">
                                            <img class="aw-thumb" src="{{ $photo->url }}" alt="Foto {{ $submission->name }}" loading="lazy">
                                        </a>
                                    @empty
                                        <span class="aw-thumb--empty">Tanpa foto</span>
                                    @endforelse
                                </div>
                                @if ($video)
                                    <a class="aw-muted" href="{{ $video->url }}" target="_blank" rel="noopener">Lihat video</a>
                                @endif
                            </td>
                            <td class="aw-table__comment">
                                <strong>{{ $submission->name }}</strong>
                                <div class="aw-muted">{{ $submission->category?->name ?? '-' }}</div>
                                {{ \Illuminate\Support\Str::limit($submission->description, 140) }}
                                <div class="aw-muted">
                                    @if ($submission->item_condition) Kondisi: {{ $submission->item_condition }}<br> @endif
                                    @if ($submission->material) Bahan: {{ $submission->material }}<br> @endif
                                    @if ($submission->usage_duration) Pemakaian: {{ $submission->usage_duration }}<br> @endif
                                    @if ($submission->flaws) Minus: {{ $submission->flaws }}<br> @endif
                                    @if ($submission->location) Lokasi: {{ $submission->location }} @endif
                                </div>
                            </td>
                            <td>
                                {{ $submission->seller?->name ?? '-' }}
                                @if ($submission->contact_whatsapp)
                                    <div class="aw-muted">WA: {{ $submission->contact_whatsapp }}</div>
                                @endif
                            </td>
                            <td>Rp {{ number_format((float) $submission->price, 0, ',', '.') }}</td>
                            <td>
                                <span class="aw-badge aw-badge--{{ $submission->submission_status }}">
                                    {{ $statusLabels[$submission->submission_status] ?? $submission->submission_status }}
                                </span>
                                @if ($submission->submission_status === 'rejected' && $submission->admin_note)
                                    <div class="aw-muted aw-table__comment">Alasan: {{ $submission->admin_note }}</div>
                                @endif
                            </td>
                            <td>{{ $submission->created_at?->format('d/m/Y H:i') }}</td>
                            <td>
                                @if ($submission->submission_status === 'pending')
                                    <form method="POST" action="{{ route('admin.submissions.approve', $submission) }}"
                                          onsubmit="return confirm('Setujui pengajuan ini dan tayangkan di katalog?')">
                                        @csrf
                                        @method('PATCH')
                                        <button class="aw-btn aw-btn--primary aw-btn--small" type="submit">Setujui</button>
                                    </form>

                                    <details class="aw-reject" style="margin-top:.5rem;">
                                        <summary class="aw-btn aw-btn--danger aw-btn--small">Tolak</summary>
                                        <form method="POST" action="{{ route('admin.submissions.reject', $submission) }}">
                                            @csrf
                                            @method('PATCH')
                                            <label class="sr-only" for="note-{{ $submission->id }}">Alasan penolakan</label>
                                            <textarea class="aw-input" id="note-{{ $submission->id }}" name="admin_note" maxlength="1000" required
                                                      placeholder="Tulis alasan penolakan untuk penjual"></textarea>
                                            <button class="aw-btn aw-btn--danger aw-btn--small" type="submit" style="margin-top:.35rem;">Kirim penolakan</button>
                                        </form>
                                    </details>
                                @else
                                    <span class="aw-muted">Sudah diproses</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @include('partials.pager', ['paginator' => $submissions])
    @endif
</div>
@endsection
