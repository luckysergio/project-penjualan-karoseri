@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-center mt-6">

        <div class="flex items-center space-x-1">

            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="px-3 py-2 bg-gray-200 text-gray-400 rounded-full cursor-not-allowed">
                    &laquo;
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-2 bg-white border rounded-full hover:bg-blue-100 transition">
                    &laquo;
                </a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="px-3 py-2 text-gray-500">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="px-3 py-2 bg-blue-600 text-white rounded-full font-semibold">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" class="px-3 py-2 bg-white border rounded-full hover:bg-blue-100 transition">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-2 bg-white border rounded-full hover:bg-blue-100 transition">
                    &raquo;
                </a>
            @else
                <span class="px-3 py-2 bg-gray-200 text-gray-400 rounded-full cursor-not-allowed">
                    &raquo;
                </span>
            @endif

        </div>

    </nav>
@endif
