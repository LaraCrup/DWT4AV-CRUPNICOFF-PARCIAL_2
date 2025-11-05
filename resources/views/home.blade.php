@extends('layouts.app')

@section('title', 'Inicio - Tortas Manuela')

@section('styles')
    <link rel="stylesheet" href="/styles/homeStyles.css">
@endsection

@section('content')
    <section class="hero">
        <h1 class="fontTitle">¡Bienvenido a Tortas Manuela, el sabor auténtico!</h1>
        <p class="fontBody">Hechas con amor y los mejores ingredientes</p>
        <a href="{{ route('tortas.index') }}" class="btn btnPrimary">Ver todas las tortas</a>
    </section>

    <section class="sectionBest">
        <h2 class="fontTitle">Calidad y sabor en cada bocado</h2>
        <p class="fontBody">En Tortas Manuela, nos dedicamos a ofrecer tortas frescas y deliciosas, elaboradas con
            ingredientes de la más alta calidad. Nuestro compromiso es satisfacer el paladar de nuestros clientes
            con cada creación.</p>
        <div>
            <div>
                <img src="/storage/home/ingredientes.webp" alt="Ingredientes frescos">
                <h3 class="fontTitle">Ingredientes frescos</h3>
            </div>
            <div>
                <img src="/storage/home/envio.webp" alt="Envio rápido">
                <h3 class="fontTitle">Envío rápido en tu zona</h3>
            </div>
            <div>
                <img src="/storage/home/personalizacion.webp" alt="Personalización a tu gusto">
                <h3 class="fontTitle">Personalización a tu gusto</h3>
            </div>
            <div>
                <img src="/storage/home/pagos.webp" alt="Pagos seguros">
                <h3 class="fontTitle">Pagos seguros</h3>
            </div>
        </div>
        <a href="{{ route('contactUs') }}" class="btn btnPrimary">Contactanos</a>
    </section>

    <section class="carouselSection">
        <h2 class="fontTitle">
            Nuestras tortas mas vendidas
        </h2>
        <div class="carouselContainer">
            <div id="cakesSlider" class="carouselSlider">
                @forelse($tortasDestacadas as $torta)
                    @include('partials.tortaCard', ['isCarousel' => true])
                @empty
                    <p class="fontBody">No hay tortas destacadas disponibles</p>
                @endforelse
            </div>
        </div>
    </section>

    <section class="sectionAbout">
        <div>
            <h2 class="fontTitle">Somos productores artesanales</h2>
            <p class="fontBody">Trabajamos con un equipo apasionado por crear tortas únicas, hechas a mano con
                ingredientes frescos y
                seleccionados. Cada producto refleja nuestra dedicación, combinando tradición familiar y creatividad
                para que disfrutes un sabor auténtico en cada bocado.</p>
            <a href="{{ route('aboutUs') }}" class="btn btnPrimary">Conocé a nuestro equipo</a>
        </div>
        <img src="/storage/home/somos.webp" alt="Equipo">
    </section>
@endsection

@section('scripts')
    <script src="./scripts/carouselHome.js"></script>
@endsection
