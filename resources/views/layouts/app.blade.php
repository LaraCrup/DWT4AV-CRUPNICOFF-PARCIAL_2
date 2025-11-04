<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Tortas Manuela')</title>
    <link rel="stylesheet" href="/styles/mainStyles.css">
    @yield('styles')
    @stack('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css">
</head>

<body>
    <header>
        <button id="menu" class="menuButton">
            <svg class="menuIcon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
        <div>
            <img src="/storage/shared/logo.png" alt="Logo Tortas Manuela" class="logoHeader">
        </div>
        <nav class="navDesktop">
            <ul class="fontBody">
                <li><a href="{{ route('home') }}">Inicio</a></li>
                <li><a href="{{ route('tortas.index') }}">Tortas</a></li>
                <li><a href="{{ route('aboutUs') }}">Sobre Nosotros</a></li>
                <li><a href="{{ route('contactUs') }}">Contacto</a></li>
            </ul>
            <div class="btnNav fontBody">
                <a href="{{ route('profile') }}"><img src="/storage/shared/profile.png" alt="Mi Perfil"></a>
                <a href="{{ route('cart') }}" class="btn cart">
                    Carrito
                    <span class="cartCount fontBody">0</span>
                </a>
                <a href="{{ route('login') }}" class="btn btnPrimary">Ingresar</a>
            </div>
        </nav>
        <a href="{{ route('cart') }}" class="cartIcon cart" style="position:relative;">
            <img src="/storage/shared/cart.png" alt="Carrito">
            <span id="cartCount" class="cartCount fontBody">0</span>
        </a>
    </header>
    <div id="backgroundMenu" class="menuOverlay"></div>
    <div id="lateralMenu" class="lateralMenu">
        <div class="menuContent">
            <button id="cruz-cerrar" class="closeButton">
                &times;
            </button>
            <nav class="navMobile">
                <ul class="fontBody">
                    <li><a href="{{ route('home') }}">Inicio</a></li>
                    <li><a href="{{ route('tortas.index') }}">Tortas</a></li>
                    <li><a href="{{ route('aboutUs') }}">Sobre Nosotros</a></li>
                    <li><a href="{{ route('contactUs') }}">Contacto</a></li>
                </ul>
                <div class="btnNav fontBody">
                    <a href="{{ route('profile') }}"><img src="/storage/shared/profile.png" alt="Mi Perfil"></a>
                    <a href="{{ route('cart') }}" class="btn cart">Carrito</a>
                    <a href="{{ route('login') }}" class="btn btnPrimary">Ingresar</a>
                </div>
            </nav>
        </div>
    </div>

    <main>
        @yield('content')
    </main>

    <footer>
        <div class="infoFooter">
            <p class="fontTitle">Info. Clave</p>
            <ul class="fontBody">
                <li>Lara Crupnicoff</li>
                <li>19/08/2003</li>
                <li>lara.crupnicoff@davinci.edu.ar</li>
            </ul>
        </div>
        <div class="navFooter">
            <ul class="fontBody">
                <li><a href="{{ route('home') }}">Inicio</a></li>
                <li><a href="{{ route('tortas.index') }}">Tortas</a></li>
                <li><a href="{{ route('aboutUs') }}">Sobre Nosotros</a></li>
                <li><a href="{{ route('contactUs') }}">Contacto</a></li>
            </ul>
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="./scripts/menu.js"></script>
    <script src="./scripts/cartManager.js"></script>
    @yield('scripts')
</body>

</html>
