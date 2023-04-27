<div class="d-none flex-sm-fill d-sm-flex align-items-sm-center justify-content-sm-between">
    <div>
        <p class="small text-muted">
            {!! __('Showing') !!}
            <span class="fw-semibold">{{ $paginator->firstItem() }}</span>
            {!! __('to') !!}
            <span class="fw-semibold">{{ $paginator->lastItem() }}</span>
            {!! __('of') !!}
            <span class="fw-semibold">{{ $paginator->total() }}</span>
            {!! __('results') !!}
        </p>
    </div>
    <div class="paginating-container pagination-default float-end">
        @if ($paginator->hasPages())
            <ul class="pagination">
                @if ($paginator->onFirstPage())
                    <li class="prev"><a href="javascript:void(0);">Prev</a></li>
                @else
                    <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev">Prev</a></li>
                @endif
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <li class="disabled"><span>{{ $element }}</span></li>
                    @endif
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="active"><a href="javascript:void(0);">{{ $page }}</a></li>
                            @else
                                <li><a href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endforeach
                    @endif
                @endforeach
                @if ($paginator->hasMorePages())
                    <li><a href="{{ $paginator->nextPageUrl() }}" rel="next">Next</a></li>
                @else
                    <li class="next"><a href="javascript:void(0);">Next</a></li>
                @endif
            </ul>
        @endif
    </div>
</div>
