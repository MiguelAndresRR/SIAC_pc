<div class="paginacion-container" id="paginacion">
    @if ($detallesInventario->onFirstPage())
        <span class="paginacion-btn paginacion-disabled"><i class="fa-solid fa-arrow-left"></i></span>
    @else
        <a href="{{ $detallesInventario->previousPageUrl() }}" class="paginacion-btn paginacion-active"><i class="fa-solid fa-arrow-left"></i></a>
    @endif

    @for ($i = 1; $i <= $detallesInventario->lastPage(); $i++)
        @if ($i == $detallesInventario->currentPage())
            <span class="paginacion-btn paginacion-current">{{ $i }}</span>
        @else
            <a href="{{ $detallesInventario->url($i) }}" class="paginacion-btn paginacion-number">{{ $i }}</a>
        @endif
    @endfor

    @if ($detallesInventario->hasMorePages())
        <a href="{{ $detallesInventario->nextPageUrl() }}" class="paginacion-btn paginacion-active"><i class="fa-solid fa-arrow-right"></i></a>
    @else
        <span class="paginacion-btn paginacion-disabled"><i class="fa-solid fa-arrow-right"></i></span>
    @endif
</div>
