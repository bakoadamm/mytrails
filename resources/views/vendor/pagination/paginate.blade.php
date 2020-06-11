@if ($paginator->hasPages())
    <ul class="pagination justify-content-end mb-0">
    {{-- Previous Page Link --}}
    @if ($paginator->onFirstPage())
        <!-- <li class="disabled item"><span><i class="icon ion-md-arrow-round-back"></i></span></li> -->
        @else
        {{--}}
            <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">
                <li class="page-item"><<</li>
            </a>
            --}}
            <li class="page-item disabled">
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}" tabindex="-1">
                    <i class="fa fa-angle-left"></i>
                    <span class="sr-only">Előző</span>
                </a>
            </li>
        @endif

        @if($paginator->currentPage() > 3)
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->url(1) }}">1</a>
            </li>
        @endif
        @if($paginator->currentPage() > 4)
            <li class="disabled item"><span>...</span></li>
        @endif
        @foreach(range(1, $paginator->lastPage()) as $i)
            @if($i >= $paginator->currentPage() - 2 && $i <= $paginator->currentPage() + 2)
                @if ($i == $paginator->currentPage())
                    {{--}}<li class="item active-pagination"><span>{{ $i }}</span></li>--}}
                    <li class="page-item active">
                        <a class="page-link" href="#">{{ $i }}</a>
                    </li>
                @else
                    {{--}}<a href="/eredmenyek{{ $paginator->url($i) }}"><li class="item">{{ $i }}</li></a>--}}
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->url($i) }}">{{ $i }}</a>
                    </li>
                @endif
            @endif
        @endforeach
        @if($paginator->currentPage() < $paginator->lastPage() - 3)
            <li class="disabled item"><span>...</span></li>
        @endif
        @if($paginator->currentPage() < $paginator->lastPage() - 2)
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a>
            </li>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())

            <li class="page-item">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}">
                    <i class="fa fa-angle-right"></i>
                    <span class="sr-only">Következő</span>
                </a>
            </li>
        @else
        <!-- <li class="item disabled"><i class="icon ion-md-arrow-round-forward"></i></li> -->
        @endif
    </ul>
@endif
