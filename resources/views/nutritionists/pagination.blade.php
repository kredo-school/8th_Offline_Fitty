@if ($adviceList->hasPages())
    <div class="d-flex justify-content-between align-items-center mb-3 pagination-wrapper">
        <!-- Showing data information -->
        <div style="text-align: left; font-family: 'Poppins', sans-serif; font-size: 14px; color: #333;">
            Showing {{ $adviceList->firstItem() }} to {{ $adviceList->lastItem() }} of {{ $adviceList->total() }} entries
        </div>

        <!-- Pagination Navigation -->
        <nav class="admin-pagination-container">
            <ul class="admin-pagination">
                {{-- Previous Page Link --}}
                <li class="admin-pagination-item {{ $adviceList->onFirstPage() ? 'disabled' : '' }}">
                    <a href="{{ $adviceList->previousPageUrl() }}" rel="prev">&lt;</a>
                </li>

                {{-- Pagination Elements --}}
                @foreach ($adviceList->links()->elements() as $element)
                    @if (is_string($element))
                        <li class="admin-pagination-item disabled">
                            <span class="admin-pagination-ellipsis">{{ $element }}</span>
                        </li>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $adviceList->currentPage())
                                <li class="admin-pagination-item active">
                                    <span>{{ $page }}</span>
                                </li>
                            @else
                                <li class="admin-pagination-item">
                                    <a href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                <li class="admin-pagination-item {{ $adviceList->hasMorePages() ? '' : 'disabled' }}">
                    <a href="{{ $adviceList->nextPageUrl() }}" rel="next">&gt;</a>
                </li>
            </ul>
        </nav>
    </div>
@endif
