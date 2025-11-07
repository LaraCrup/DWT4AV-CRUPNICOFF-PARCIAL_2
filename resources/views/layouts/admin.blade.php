<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('pageTitle', 'Admin') - Tortas Manuela</title>
    <link rel="stylesheet" href="/styles/mainStyles.css">
    <link rel="stylesheet" href="/styles/mainAdminStyles.css">
    <link rel="stylesheet" href="/styles/formsStyles.css">
    <link rel="stylesheet" href="/styles/logoutModal.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @stack('styles')
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
                <li><a href="{{ route('admin.dashboard') }}">Inicio</a></li>
                <li><a href="{{ route('admin.tortas.index') }}">Productos</a></li>
                <li><a href="{{ route('admin.categorias.index') }}">Categorias</a></li>
                <li><a href="{{ route('admin.usuarios.index') }}">Usuarios</a></li>
                <li><a href="{{ route('admin.mensajes.index') }}">Mensajes</a></li>
            </ul>
            <div class="btnNav fontBody">
                <button onclick="openLogoutConfirm()" class="btn btnPrimary">Cerrar Sesión</button>
            </div>
        </nav>
    </header>
    <div id="backgroundMenu" class="menuOverlay"></div>
    <div id="lateralMenu" class="lateralMenu">
        <div class="menuContent">
            <button id="cruz-cerrar" class="closeButton">
                &times;
            </button>
            <nav class="navMobile">
                <ul class="fontBody">
                    <li><a href="{{ route('admin.dashboard') }}">Inicio</a></li>
                    <li><a href="{{ route('admin.tortas.index') }}">Productos</a></li>
                    <li><a href="{{ route('admin.categorias.index') }}">Categorias</a></li>
                    <li><a href="{{ route('admin.usuarios.index') }}">Usuarios</a></li>
                    <li><a href="{{ route('admin.mensajes.index') }}">Mensajes</a></li>
                </ul>
                <div class="btnNav fontBody">
                    <button onclick="openLogoutConfirm()" class="btn btnPrimary">Cerrar Sesión</button>
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
                <li><a href="{{ route('admin.dashboard') }}">Inicio</a></li>
                <li><a href="{{ route('admin.tortas.index') }}">Productos</a></li>
                <li><a href="{{ route('admin.categorias.index') }}">Categorias</a></li>
                <li><a href="{{ route('admin.usuarios.index') }}">Usuarios</a></li>
                <li><a href="{{ route('admin.mensajes.index') }}">Mensajes</a></li>
            </ul>
        </div>
    </footer>
    <script src="/scripts/menu.js"></script>
    @include('partials.logoutConfirm')
    @yield('scripts')
</body>

</html>
