<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TortaController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TortaController as AdminTortaController;
use App\Http\Controllers\Admin\CategoriaController as AdminCategoriaController;
use App\Http\Controllers\Admin\UserController as AdminUserController;

// Ruta de bienvenida
Route::get('/', [HomeController::class, 'index'])->name('home');

// Rutas de contacto
Route::get('/contactUs', [ContactUsController::class, 'show'])->name('contactUs');
Route::post('/contactUs', [ContactUsController::class, 'store'])->middleware('auth')->name('contactUs.store');

// Ruta de sobre nosotros
Route::get('/aboutUs', function () {
    return view('aboutUs');
})->name('aboutUs');

// Ruta del carrito
Route::get('/cart', function () {
    return view('cart');
})->name('cart');

// Ruta de checkout
Route::get('/checkout', function () {
    return view('checkout');
})->name('checkout');

// Ruta de formulario recibido
Route::get('/formReceived', function () {
    return view('formReceived');
})->name('formReceived');

// Rutas protegidas (requieren autenticación)
Route::middleware('auth')->group(function () {
    Route::get('/profile', function () {
        return view('profile');
    })->name('profile');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Rutas de autenticación (Solo para usuarios no autenticados)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

// Ruta de admin login redirige al login único
Route::get('/admin/login', function () {
    return redirect()->route('login');
})->name('admin.login');

// Rutas de Tortas (Catálogo - Público)
Route::prefix('tortas')->group(function () {
    Route::get('/', [TortaController::class, 'index'])->name('tortas.index');
    Route::get('/{id}', [TortaController::class, 'show'])->name('tortas.show');
});

// Rutas de Admin (Protegidas - Solo para Admin)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Admin - Dashboard
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

    // Admin - Usuarios
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
