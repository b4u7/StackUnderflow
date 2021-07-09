@if ($paginator->hasPages())
    <nav class="card card--transparent pagination flex mt-4" aria-label="Pagination">
        <ul class="pagination__list">
            <li class="pagination__item">
                <a class="pagination__link" href="{{ $paginator->previousPageUrl() }}"
                   @if ($paginator->onFirstPage()) disabled @endif>
                    <span>
                        &lsaquo;
                    </span>
                </a>
            </li>
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="pagination__item">
                        <a class="pagination__link" disabled>
                            {{ $element }}
                        </a>
                    </li>
                @endif
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="pagination__item">
                                <a class="pagination__link" aria-current="page">
                                    {{ $page }}
                                </a>
                            </li>
                        @else
                            <li class="pagination__item">
                                <a class="pagination__link" href="{{ $url }}">
                                    {{ $page }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach
            <li class="pagination__item">
                <a class="pagination__link" href="{{ $paginator->nextPageUrl() }}"
                   @if (!$paginator->hasMorePages()) disabled @endif>
                    <span>
                        &rsaquo;
                    </span>
                </a>
            </li>
        </ul>
    </nav>
@endif
