@extends('layouts.app')

@section('title', 'Contactanos - Tortas Manuela')

@section('styles')
    <link rel="stylesheet" href="/styles/contactUsStyles.css">
@endsection

@section('content')
    <section class="hero">
        <h1 class="fontTitle">Contáctanos hoy</h1>
        <p class="fontBody">Estamos aquí para ayudarte. No dudes en ponerte en contacto con nosotros para cualquier
            consulta.</p>
    </section>

    <section class="contactSection fontBody">
        <div>
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                    <path fill="#3b3a44"
                        d="M4 20q-.825 0-1.412-.587T2 18V6q0-.825.588-1.412T4 4h16q.825 0 1.413.588T22 6v12q0 .825-.587 1.413T20 20zM20 8l-7.475 4.675q-.125.075-.262.113t-.263.037t-.262-.037t-.263-.113L4 8v10h16zm-8 3l8-5H4zM4 8v.25v-1.475v.025V6v.8v-.012V8.25zv10z" />
                </svg>
                <div>
                    <h2 class="fontTitle">Correo</h2>
                    <p>Escríbenos a:</p>
                    <a href="mailto:info@tortasmanuela.com" target="_blank">info@tortasmanuela.com</a>
                </div>
            </div>
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                    <path fill="#3b3a44"
                        d="M20 12q-.4 0-.712-.288T18.925 11q-.325-2.325-1.963-3.963T13 5.076q-.425-.05-.712-.35T12 4t.3-.712t.7-.238q3.15.35 5.375 2.575T20.95 11q.05.4-.238.7T20 12m-4.175 0q-.325 0-.575-.225t-.375-.6q-.2-.725-.763-1.287t-1.287-.763q-.375-.125-.6-.375T12 8.15q0-.5.35-.812t.775-.213q1.4.325 2.413 1.338t1.337 2.412q.1.425-.225.775t-.825.35m4.125 9q-3.125 0-6.175-1.362t-5.55-3.863t-3.862-5.55T3 4.05q0-.45.3-.75t.75-.3H8.1q.35 0 .625.238t.325.562l.65 3.5q.05.4-.025.675T9.4 8.45L6.975 10.9q.5.925 1.187 1.787t1.513 1.663q.775.775 1.625 1.438T13.1 17l2.35-2.35q.225-.225.588-.337t.712-.063l3.45.7q.35.1.575.363T21 15.9v4.05q0 .45-.3.75t-.75.3M6.025 9l1.65-1.65L7.25 5H5.025q.125 1.025.35 2.025T6.025 9m8.95 8.95q.975.425 1.988.675T19 18.95v-2.2l-2.35-.475zm0 0" />
                </svg>
                <div>
                    <h2 class="fontTitle">Teléfono</h2>
                    <p>Llámanos al:</p>
                    <a href="tel:+15550000000" target="_blank">+1 (555) 000-0000</a>
                </div>
            </div>
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                    <path fill="#3b3a44"
                        d="M12 19.35q3.05-2.8 4.525-5.087T18 10.2q0-2.725-1.737-4.462T12 4T7.738 5.738T6 10.2q0 1.775 1.475 4.063T12 19.35m0 1.975q-.35 0-.7-.125t-.625-.375Q9.05 19.325 7.8 17.9t-2.087-2.762t-1.275-2.575T4 10.2q0-3.75 2.413-5.975T12 2t5.588 2.225T20 10.2q0 1.125-.437 2.363t-1.275 2.575T16.2 17.9t-2.875 2.925q-.275.25-.625.375t-.7.125M12 12q.825 0 1.413-.587T14 10t-.587-1.412T12 8t-1.412.588T10 10t.588 1.413T12 12" />
                </svg>
                <div>
                    <h2 class="fontTitle">Local</h2>
                    <p>Encontranos en:</p>
                    <a href="https://maps.app.goo.gl/N1QF7We6Qb37TqZ76" target="_blank">11 de Septiembre de 1888
                        1772, CABA, Buenos Aires, Argentina</a>
                </div>
            </div>
        </div>
        <img src="/storage/contactUs/nuestro-local.webp" alt="Nuestro Local">
    </section>

    <section class="formSection">
        <h2 class="fontTitle">Envíanos un mensaje</h2>

        @auth
            <form action="{{ route('contactUs.store') }}" method="POST" class="contactForm fontBody">
                @csrf
                <div>
                    <label for="titulo">Título:</label>
                    <input type="text" id="titulo" name="titulo" required>
                    @error('titulo')
                        <span class="errorMessage">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="mensaje">Mensaje:</label>
                    <textarea id="mensaje" name="mensaje" rows="5" required></textarea>
                    @error('mensaje')
                        <span class="errorMessage">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="btn btnPrimary">Enviar</button>
            </form>
        @endauth
        @guest
            <div class="fontBody noForm">
                <p>Debes <a href="{{ route('login') }}">iniciar sesión</a> para enviar un mensaje.</p>
                <p>¿No tienes cuenta? <a href="{{ route('register') }}">Regístrate aquí</a>.</p>
            </div>
        @endguest
    </section>
@endsection
