@if ($paginator->hasPages())
    <nav class="pagination is-centered">
        <a class="pagination-previous"
           href="{{ $paginator->previousPageUrl() }}"
           @if ($paginator->onFirstPage()) disabled @endif>
            <span>
                &lsaquo;
            </span>
        </a>
        <ul class="pagination-list">
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li>
                        <a disabled>
                            {{ $element }}
                        </a>
                    </li>
                @endif
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li>
                                <a class="pagination-link is-current">
                                    {{ $page }}
                                </a>
                            </li>
                        @else
                            <li>
                                <a class="pagination-link" href="{{ $url }}">
                                    {{ $page }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </ul>
        <a class="pagination-next"
           href="{{ $paginator->previousPageUrl() }}"
           @if (!$paginator->hasMorePages()) disabled @endif>
            <span>
                &rsaquo;
            </span>
        </a>
    </nav>
@endif
