<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TortaController;
use App\Http\Controllers\Admin\TortaController as AdminTortaController;
use App\Http\Controllers\Admin\CategoriaController as AdminCategoriaController;

// Ruta de bienvenida
Route::get('/', function () {
    return view('welcome');
});

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
