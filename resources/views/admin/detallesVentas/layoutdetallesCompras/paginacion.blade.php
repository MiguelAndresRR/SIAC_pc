<div class="paginacion-container" id="paginacion">
    @if ($detallesCompras->onFirstPage())
        <span class="paginacion-btn paginacion-disabled"><i class="fa-solid fa-arrow-left"></i></span>
    @else
        <a href="{{ $detallesCompras->previousPageUrl() }}" class="paginacion-btn paginacion-active"><i class="fa-solid fa-arrow-left"></i></a>
    @endif

    @for ($i = 1; $i <= $detallesCompras->lastPage(); $i++)
        @if ($i == $detallesCompras->currentPage())
            <span class="paginacion-btn paginacion-current">{{ $i }}</span>
        @else
            <a href="{{ $detallesCompras->url($i) }}" class="paginacion-btn paginacion-number">{{ $i }}</a>
        @endif
    @endfor

    @if ($detallesCompras->hasMorePages())
        <a href="{{ $detallesCompras->nextPageUrl() }}" class="paginacion-btn paginacion-active"><i class="fa-solid fa-arrow-right"></i></a>
    @else
        <span class="paginacion-btn paginacion-disabled"><i class="fa-solid fa-arrow-right"></i></span>
    @endif
</div>
