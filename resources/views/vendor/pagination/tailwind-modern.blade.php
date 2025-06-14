@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-center mt-6">
        <div class="flex flex-wrap items-center gap-2">

            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="px-3 py-2 bg-slate-200 text-slate-400 rounded-lg cursor-not-allowed shadow-sm">
                    &laquo;
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-2 bg-white border border-slate-300 rounded-lg hover:bg-blue-100 transition shadow-sm">
                    &laquo;
                </a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="px-3 py-2 text-slate-500">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="px-3 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg font-semibold shadow-sm">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" class="px-3 py-2 bg-white border border-slate-300 rounded-lg hover:bg-blue-100 transition shadow-sm">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-2 bg-white border border-slate-300 rounded-lg hover:bg-blue-100 transition shadow-sm">
                    &raquo;
                </a>
            @else
                <span class="px-3 py-2 bg-slate-200 text-slate-400 rounded-lg cursor-not-allowed shadow-sm">
                    &raquo;
                </span>
            @endif

        </div>
    </nav>
@endif
