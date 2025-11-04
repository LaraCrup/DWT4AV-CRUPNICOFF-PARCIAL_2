<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN - Ingresar</title>
    <link rel="icon" type="image/ico" href="/images/favicon.ico">
    <link rel="stylesheet" href="/styles/mainStyles.css">
    <link rel="stylesheet" href="/styles/mainAdminStyles.css">
    <link rel="stylesheet" href="/styles/formsStyles.css">
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
            <img src="../images/shared/logo.png" alt="Logo Tortas Manuela" class="logoHeader">
        </div>
        <nav class="navDesktop">
            <ul class="fontBody">
                <li><a href="{{ route('admin.dashboard') }}">Inicio</a></li>
                <li><a href="{{ route('admin.tortas.index') }}">Productos</a></li>
                <li><a href="{{ route('admin.categorias.index') }}">Categorias</a></li>
                <li><a href="#">Usuarios</a></li>
            </ul>
            <div class="btnNav fontBody">
                <a href="{{ route('login') }}" class="btn btnPrimary">Ingresar</a>
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
                    <li><a href="#">Usuarios</a></li>
                </ul>
                <div class="btnNav fontBody">
                    <a href="{{ route('login') }}" class="btn btnPrimary">Ingresar</a>
                </div>
            </nav>
        </div>
    </div>

    <main>
        <section>
            <h1 class="fontTitle">Iniciar sesión</h1>
            <form class="formContainer fontBody" action="{{ route('admin.login.store') }}" method="post" id="loginAdminForm">
                @csrf
                <div class="formInputs">
                    <div class="formGroup">
                        <label for="email">Correo electrónico</label>
                        <input type="email" id="email" name="email" required
                            placeholder="Ingresa tu correo electrónico" value="{{ old('email') }}">
                        @error('email')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="formGroup">
                        <label for="password">Contraseña</label>
                        <input type="password" id="password" name="password" required
                            placeholder="Ingresa tu contraseña">
                        @error('password')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="btn btnPrimary">Iniciar sesión</button>
            </form>
        </section>
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
                <li><a href="#">Usuarios</a></li>
            </ul>
        </div>
    </footer>
    <script src="/scripts/menu.js"></script>
    <script src="/scripts/formValidation.js"></script>
</body>

</html>
