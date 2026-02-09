@if ($paginator->hasPages())
<nav role="navigation" aria-label="Pagination Navigation">

    {{-- Mobile Version --}}
    <div class="flex gap-2 items-center justify-between sm:hidden">
        @if ($paginator->onFirstPage())
            <span class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-400 bg-gray-50 border border-gray-200 rounded-lg cursor-not-allowed">
                Previous
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-100 transition">
                Previous
            </a>
        @endif

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-100 transition">
                Next
            </a>
        @else
            <span class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-400 bg-gray-50 border border-gray-200 rounded-lg cursor-not-allowed">
                Next
            </span>
        @endif
    </div>

    {{-- Desktop Version --}}
    <div class="hidden sm:flex sm:items-center sm:justify-between">

        {{-- Info Text --}}
        <div>
            <p class="text-sm text-gray-500">
                Showing
                @if ($paginator->firstItem())
                    <span class="font-medium text-gray-700">{{ $paginator->firstItem() }}</span>
                    to
                    <span class="font-medium text-gray-700">{{ $paginator->lastItem() }}</span>
                @else
                    {{ $paginator->count() }}
                @endif
                of
                <span class="font-medium text-gray-700">{{ $paginator->total() }}</span>
                results
            </p>
        </div>

        {{-- Pagination Buttons --}}
        <div>
            <span class="inline-flex gap-1">

                {{-- Previous --}}
                @if ($paginator->onFirstPage())
                    <span class="px-3 py-2 text-gray-400 bg-gray-50 border border-gray-200 rounded-lg cursor-not-allowed">
                        ‹
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}"
                       class="px-3 py-2 text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-100 transition">
                        ‹
                    </a>
                @endif

                {{-- Page Numbers --}}
                @foreach ($elements as $element)

                    {{-- Dots --}}
                    @if (is_string($element))
                        <span class="px-4 py-2 text-gray-400">
                            {{ $element }}
                        </span>
                    @endif

                    {{-- Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)

                            @if ($page == $paginator->currentPage())
                                <span class="px-4 py-2 text-sm font-semibold text-gray-800 bg-gray-200 border border-gray-300 rounded-lg">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}"
                                   class="px-4 py-2 text-sm text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-100 transition">
                                    {{ $page }}
                                </a>
                            @endif

                        @endforeach
                    @endif

                @endforeach

                {{-- Next --}}
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}"
                       class="px-3 py-2 text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-100 transition">
                        ›
                    </a>
                @else
                    <span class="px-3 py-2 text-gray-400 bg-gray-50 border border-gray-200 rounded-lg cursor-not-allowed">
                        ›
                    </span>
                @endif

            </span>
        </div>
    </div>
</nav>
@endif
