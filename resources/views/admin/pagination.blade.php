@if ($paginator->hasPages())
    <div class="d-flex justify-content-between align-items-center mb-3 pagination-wrapper">
        <!-- Showing data information -->
        <div style="text-align: left; font-family: 'Poppins', sans-serif; font-size: 14px;">
            Showing {{ $paginator->firstItem() }} to {{ $paginator->lastItem() }} of {{ $paginator->total() }} entries
        </div>


        <!-- Pagination Navigation -->
        <nav class="admin-pagination-container">
            <ul class="admin-pagination">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li class="admin-pagination-item disabled" aria-disabled="true">
                        <span>&lt;</span>
                    </li>
                @else
                    <li class="admin-pagination-item">
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev">&lt;</a>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <li class="admin-pagination-item disabled" aria-disabled="true">
                            <span class="admin-pagination-ellipsis">{{ $element }}</span>
                        </li>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="admin-pagination-item active" aria-current="page">
                                    <span>{{ $page }}</span>
                                </li>
                            @elseif ($page == 1 || $page == $paginator->lastPage() || abs($page - $paginator->currentPage()) <= 1)
                                <li class="admin-pagination-item">
                                    <a href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @elseif ($page == 2 || $page == $paginator->lastPage() - 1)
                                <li class="admin-pagination-item disabled">
                                    <span class="admin-pagination-ellipsis">...</span>
                                </li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li class="admin-pagination-item">
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next">&gt;</a>
                    </li>
                @else
                    <li class="admin-pagination-item disabled" aria-disabled="true">
                        <span>&gt;</span>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
@endif
