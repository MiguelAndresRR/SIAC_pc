<div class="paginacion-container" id="paginacion">
    @if ($inventarioProductos->onFirstPage())
        <span class="paginacion-btn paginacion-disabled"><i class="fa-solid fa-arrow-left"></i></span>
    @else
        <a href="{{ $inventarioProductos->previousPageUrl() }}" class="paginacion-btn paginacion-active"><i class="fa-solid fa-arrow-left"></i></a>
    @endif

    @for ($i = 1; $i <= $inventarioProductos->lastPage(); $i++)
        @if ($i == $inventarioProductos->currentPage())
            <span class="paginacion-btn paginacion-current">{{ $i }}</span>
        @else
            <a href="{{ $inventarioProductos->url($i) }}" class="paginacion-btn paginacion-number">{{ $i }}</a>
        @endif
    @endfor

    @if ($inventarioProductos->hasMorePages())
        <a href="{{ $inventarioProductos->nextPageUrl() }}" class="paginacion-btn paginacion-active"><i class="fa-solid fa-arrow-right"></i></a>
    @else
        <span class="paginacion-btn paginacion-disabled"><i class="fa-solid fa-arrow-right"></i></span>
    @endif
</div>
