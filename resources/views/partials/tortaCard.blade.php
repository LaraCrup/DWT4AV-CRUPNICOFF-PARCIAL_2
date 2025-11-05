@php
$cardClasses = (isset($isCarousel) && $isCarousel)
? 'cakeCard fontBody carouselItem'
: 'productCard fontBody';
@endphp
<div class="{{ $cardClasses }}" data-id="{{ $torta->id }}" data-category="{{ $torta->categoria_id }}" data-price="{{ $torta->tamanos->min('pivot.precio') ?? 0 }}" data-rating="{{ $torta->valoracion ?? 0 }}">
    <div class="imgCake">
        @if($torta->imagen)
        <img src="/storage/products/{{ $torta->imagen }}" alt="{{ $torta->nombre }}">
        @else
        <div class="imagePlaceholder">
            <span>Sin imagen</span>
        </div>
        @endif
    </div>
    <div class="infoCake">
        <div class="cakeDetails">
            <div>
                <h3>{{ $torta->nombre }}</h3>
                @if($torta->valoracion)
                <div class="stars">
                    @php
                    $rating = round($torta->valoracion);
                    echo str_repeat('★', $rating) . str_repeat('☆', 5 - $rating);
                    @endphp
                </div>
                @endif
            </div>
            <div class="cakePrice">
                <p>
                    @if($torta->tamanos->count() > 0)
                    <span>${{ number_format($torta->tamanos->min('pivot.precio'), 0) }}</span> por porcion
                    @endif
                </p>
            </div>
        </div>
        <a href="{{ route('tortas.show', $torta->id) }}" class="btn btnPrimary">
            Ver producto
        </a>
    </div>
</div>