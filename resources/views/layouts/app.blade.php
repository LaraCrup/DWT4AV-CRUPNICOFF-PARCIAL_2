<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                @auth
                    <a href="{{ route('profile') }}"><img src="/storage/shared/profile.png" alt="Mi Perfil"></a>
                @endauth
                <a href="{{ route('cart') }}" class="btn cart">
                    Carrito
                    <span class="cartCount fontBody">0</span>
                </a>
                @auth
                    <button type="button" class="btn btnPrimary" onclick="openLogoutConfirm()">Cerrar Sesión</button>
                @endauth
                @guest
                    <a href="{{ route('login') }}" class="btn btnPrimary">Ingresar</a>
                @endguest
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
                    @auth
                        <a href="{{ route('profile') }}"><img src="/storage/shared/profile.png" alt="Mi Perfil"></a>
                    @endauth
                    <a href="{{ route('cart') }}" class="btn cart">Carrito</a>
                    @auth
                        <button type="button" class="btn btnPrimary" onclick="openLogoutConfirm()">Cerrar Sesión</button>
                    @endauth
                    @guest
                        <a href="{{ route('login') }}" class="btn btnPrimary">Ingresar</a>
                    @endguest
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
    @include('partials.logoutConfirm')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="/scripts/menu.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            loadCartCounterFromServer();
        });

        async function loadCartCounterFromServer() {
            try {
                const response = await fetch('/api/cart/', {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    }
                });

                const data = await response.json();
                let itemCount = 0;
                Object.values(data.items).forEach(item => {
                    itemCount += item.cantidad;
                });

                const cartCountElements = document.querySelectorAll('.cartCount');
                cartCountElements.forEach(element => {
                    element.textContent = itemCount;
                    if (itemCount > 0) {
                        element.style.display = 'flex';
                    } else {
                        element.style.display = 'none';
                    }
                });
            } catch (error) {
                console.error('Error cargando el contador del carrito:', error);
            }
        }
    </script>

    @yield('scripts')
</body>

</html>