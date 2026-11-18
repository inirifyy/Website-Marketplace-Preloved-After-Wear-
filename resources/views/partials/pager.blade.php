{{-- Navigasi halaman sederhana. Pakai: @include('partials.pager', ['paginator' => $products]) --}}
@if ($paginator->hasPages())
    <nav class="aw-pager" aria-label="Navigasi halaman">
        @if ($paginator->onFirstPage())
            <span class="aw-btn aw-btn--small" aria-disabled="true" style="opacity:.5">&laquo; Sebelumnya</span>
        @else
            <a class="aw-btn aw-btn--small" href="{{ $paginator->previousPageUrl() }}">&laquo; Sebelumnya</a>
        @endif

        <span class="aw-muted">Halaman {{ $paginator->currentPage() }} dari {{ $paginator->lastPage() }}</span>

        @if ($paginator->hasMorePages())
            <a class="aw-btn aw-btn--small" href="{{ $paginator->nextPageUrl() }}">Berikutnya &raquo;</a>
        @else
            <span class="aw-btn aw-btn--small" aria-disabled="true" style="opacity:.5">Berikutnya &raquo;</span>
        @endif
    </nav>
@endif
