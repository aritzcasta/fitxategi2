<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CodigoController;
use App\Http\Controllers\FichajeController;
use App\Http\Controllers\PerfilController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\Admin\AdminUserPanelController;

// Rutas de autenticación (login, register, logout, etc.)
Auth::routes();

// Ver página del código actual
Route::get('/codigo', [CodigoController::class, 'show'])->name('codigo');
// Obtener el código actual en JSON
Route::get('/codigo/actual', [CodigoController::class, 'actual'])->name('codigo.actual');

Route::middleware('session.auth')->group(function () {
    // Página de bienvenida
    /* Route::get('/', function () {
        return view('welcome');
    }); */

    // Panel principal
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    // Perfil del usuario
    Route::get('/perfil', [PerfilController::class, 'show'])->name('perfil');

    // Registrar entrada de fichaje
    Route::post('/fichaje/entrada', [FichajeController::class, 'entrada'])->name('fichaje.entrada');
    // Registrar salida de fichaje
    Route::post('/fichaje/salida', [FichajeController::class, 'salida'])->name('fichaje.salida');
    Route::get('/users', [AdminUserPanelController::class, 'index'])->name('userPanel');
    Route::get('/users/search', [AdminUserPanelController::class, 'search'])->name('userPanel.search');
    /* Route::middleware([AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
        // Gestión de usuarios, etc. (para futuro)
         Route::get('/users', [AdminUserPanelController::class, 'index'])->name('userPanel');
         Route::get('/users/search', [AdminUserPanelController::class, 'search'])->name('userPanel.search');

    }); */
});
