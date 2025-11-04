<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TortaController;
use App\Http\Controllers\Admin\TortaController as AdminTortaController;
use App\Http\Controllers\Admin\CategoriaController as AdminCategoriaController;

// Ruta de bienvenida
Route::get('/', function () {
    return view('home');
})->name('home');

// Ruta de contacto
Route::get('/contactUs', function () {
    return view('contactUs');
})->name('contactUs');

// Ruta POST para enviar formulario de contacto
Route::post('/contactUs', function () {
    // Por ahora solo redirige a formReceived
    return redirect()->route('formReceived')->with('success', 'Mensaje enviado correctamente');
});

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

// Ruta de perfil de usuario
Route::get('/profile', function () {
    return view('profile');
})->name('profile');

// Ruta de login
Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', function () {
    // Por ahora redirige al home
    return redirect()->route('home')->with('success', 'Sesión iniciada correctamente');
});

// Ruta de registro
Route::get('/register', function () {
    return view('register');
})->name('register');

// Ruta de admin login
Route::get('/admin/login', function () {
    return view('admin.login');
})->name('admin.login');

// Rutas de Tortas (Catálogo - Público)
Route::prefix('tortas')->group(function () {
    Route::get('/', [TortaController::class, 'index'])->name('tortas.index');
    Route::get('/{id}', [TortaController::class, 'show'])->name('tortas.show');
});

// Rutas de Admin
Route::prefix('admin')->name('admin.')->group(function () {
    // Admin - Tortas
    Route::prefix('tortas')->name('tortas.')->group(function () {
        Route::get('/', [AdminTortaController::class, 'index'])->name('index');
        Route::get('/create', [AdminTortaController::class, 'create'])->name('create');
        Route::post('/', [AdminTortaController::class, 'store'])->name('store');
        Route::get('/{id}', [AdminTortaController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [AdminTortaController::class, 'edit'])->name('edit');
        Route::put('/{id}', [AdminTortaController::class, 'update'])->name('update');
        Route::delete('/{id}', [AdminTortaController::class, 'destroy'])->name('destroy');
    });

    // Admin - Categorías
    Route::prefix('categorias')->name('categorias.')->group(function () {
        Route::get('/', [AdminCategoriaController::class, 'index'])->name('index');
        Route::get('/create', [AdminCategoriaController::class, 'create'])->name('create');
        Route::post('/', [AdminCategoriaController::class, 'store'])->name('store');
        Route::get('/{id}', [AdminCategoriaController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [AdminCategoriaController::class, 'edit'])->name('edit');
        Route::put('/{id}', [AdminCategoriaController::class, 'update'])->name('update');
        Route::delete('/{id}', [AdminCategoriaController::class, 'destroy'])->name('destroy');
    });
});
