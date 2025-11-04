@extends('layouts.app')

@section('title', 'Mi Carrito')

@section('styles')
    <link rel="stylesheet" href="/styles/cartStyles.css">
@endsection

@section('content')
    <section class="cartSection">
        <h1 class="fontTitle">Mi carrito</h1>

        <div class="cartContainer" id="cartItems">
        </div>

        <div id="emptyCartMessage" class="emptyCartMessage">
            <p class="fontBody">No hay productos en tu carrito</p>
            <a href="{{ route('tortas.index') }}" class="btn btnPrimary">Ver productos</a>
        </div>

        <div class="checkoutSection fontBody" id="checkoutSection">
            <div class="cartSummary total">
                <span>Total:</span>
                <span id="total">$0</span>
            </div>
            <a href="{{ route('checkout') }}" id="checkoutBtn" class="btn btnPrimary">Pagar</a>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="./scripts/cartManager.js"></script>
@endsection
