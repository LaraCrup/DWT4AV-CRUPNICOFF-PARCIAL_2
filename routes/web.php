<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TortaController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TortaController as AdminTortaController;
use App\Http\Controllers\Admin\CategoriaController as AdminCategoriaController;
use App\Http\Controllers\Admin\UserController as AdminUserController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/contactUs', [ContactUsController::class, 'show'])->name('contactUs');
Route::post('/contactUs', [ContactUsController::class, 'store'])->middleware('auth')->name('contactUs.store');

Route::get('/aboutUs', function () {
    return view('aboutUs');
})->name('aboutUs');

Route::get('/cart', function () {
    return view('cart');
})->name('cart');

Route::get('/formReceived', function () {
    return view('formReceived');
})->name('formReceived');

Route::middleware('auth')->group(function () {
    Route::get('/profile', function () {
        return view('profile');
    })->name('profile');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::prefix('tortas')->group(function () {
    Route::get('/', [TortaController::class, 'index'])->name('tortas.index');
    Route::get('/{id}', [TortaController::class, 'show'])->name('tortas.show');
});

Route::prefix('api/cart')->group(function () {
    Route::get('/', [CartController::class, 'getCart'])->name('cart.get');
    Route::post('/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/remove', [CartController::class, 'removeFromCart'])->name('cart.remove');
    Route::post('/update', [CartController::class, 'updateQuantity'])->name('cart.update');
    Route::post('/clear', [CartController::class, 'clearCart'])->name('cart.clear');
});

Route::post('/compras', [CompraController::class, 'store'])->name('compras.store');

Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CompraController::class, 'checkout'])->name('checkout');
    Route::get('/compras/{compra}', [CompraController::class, 'show'])->name('compras.show');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('tortas')->name('tortas.')->group(function () {
        Route::get('/', [AdminTortaController::class, 'index'])->name('index');
        Route::get('/create', [AdminTortaController::class, 'create'])->name('create');
        Route::post('/', [AdminTortaController::class, 'store'])->name('store');
        Route::get('/{id}', [AdminTortaController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [AdminTortaController::class, 'edit'])->name('edit');
        Route::put('/{id}', [AdminTortaController::class, 'update'])->name('update');
        Route::delete('/{id}', [AdminTortaController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('categorias')->name('categorias.')->group(function () {
        Route::get('/', [AdminCategoriaController::class, 'index'])->name('index');
        Route::get('/create', [AdminCategoriaController::class, 'create'])->name('create');
        Route::post('/', [AdminCategoriaController::class, 'store'])->name('store');
        Route::get('/{id}', [AdminCategoriaController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [AdminCategoriaController::class, 'edit'])->name('edit');
        Route::put('/{id}', [AdminCategoriaController::class, 'update'])->name('update');
        Route::delete('/{id}', [AdminCategoriaController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('usuarios')->name('usuarios.')->group(function () {
        Route::get('/', [AdminUserController::class, 'index'])->name('index');
        Route::get('/create', [AdminUserController::class, 'create'])->name('create');
        Route::post('/', [AdminUserController::class, 'store'])->name('store');
        Route::get('/{id}', [AdminUserController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [AdminUserController::class, 'edit'])->name('edit');
        Route::put('/{id}', [AdminUserController::class, 'update'])->name('update');
        Route::delete('/{id}', [AdminUserController::class, 'destroy'])->name('destroy');
    });
});
