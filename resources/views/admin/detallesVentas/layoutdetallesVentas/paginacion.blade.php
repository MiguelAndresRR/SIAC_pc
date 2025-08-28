<div class="paginacion-container" id="paginacion">
    @if ($detallesVentas->onFirstPage())
        <span class="paginacion-btn paginacion-disabled"><i class="fa-solid fa-arrow-left"></i></span>
    @else
        <a href="{{ $detallesVentas->previousPageUrl() }}" class="paginacion-btn paginacion-active"><i class="fa-solid fa-arrow-left"></i></a>
    @endif

    @for ($i = 1; $i <= $detallesVentas->lastPage(); $i++)
        @if ($i == $detallesVentas->currentPage())
            <span class="paginacion-btn paginacion-current">{{ $i }}</span>
        @else
            <a href="{{ $detallesVentas->url($i) }}" class="paginacion-btn paginacion-number">{{ $i }}</a>
        @endif
    @endfor

    @if ($detallesVentas->hasMorePages())
        <a href="{{ $detallesVentas->nextPageUrl() }}" class="paginacion-btn paginacion-active"><i class="fa-solid fa-arrow-right"></i></a>
    @else
        <span class="paginacion-btn paginacion-disabled"><i class="fa-solid fa-arrow-right"></i></span>
    @endif
</div>
