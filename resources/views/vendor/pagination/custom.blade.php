@if ($paginator->hasPages())
    <nav role="navigation" class="flex justify-end mt-6 space-x-2" aria-label="Pagination Navigation">
        {{-- Tombol sebelumnya --}}
        @if ($paginator->onFirstPage())
            <span class="w-10 h-10 flex items-center justify-center border border-gray-300 text-gray-400 rounded-full">‹</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}"
                class="w-10 h-10 flex items-center justify-center border border-gray-300 text-gray-600 hover:bg-gray-100 rounded-full">‹</a>
        @endif

        {{-- 3 halaman (current - 1, current, current + 1) --}}
        @php
            $current = $paginator->currentPage();
            $last = $paginator->lastPage();

            $pages = [];

            if ($current === 1) {
                $pages = [$current, $current + 1, $current + 2];
            } elseif ($current === $last) {
                $pages = [$current - 2, $current - 1, $current];
            } else {
                $pages = [$current - 1, $current, $current + 1];
            }

            $pages = array_filter($pages, fn($page) => $page >= 1 && $page <= $last);
        @endphp

        @foreach ($pages as $page)
            @if ($page == $current)
                <span class="w-10 h-10 flex items-center justify-center border border-blue-500 bg-blue-500 text-white rounded-full">{{ $page }}</span>
            @else
                <a href="{{ $paginator->url($page) }}"
                   class="w-10 h-10 flex items-center justify-center border border-gray-300 text-gray-600 hover:bg-gray-100 rounded-full">{{ $page }}</a>
            @endif
        @endforeach

        {{-- Tombol selanjutnya --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}"
                class="w-10 h-10 flex items-center justify-center border border-gray-300 text-gray-600 hover:bg-gray-100 rounded-full">›</a>
        @else
            <span class="w-10 h-10 flex items-center justify-center border border-gray-300 text-gray-400 rounded-full">›</span>
        @endif
    </nav>
@endif
