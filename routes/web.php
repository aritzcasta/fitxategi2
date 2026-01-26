<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RecuperarContrasenaController;
use App\Http\Controllers\CodigoController;
use App\Http\Controllers\FichajeController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\PanelAdminController;

// Rutas de autenticación (login, register, logout, etc.)
Auth::routes();

// Recuperar contraseña
Route::get('/password', [RecuperarContrasenaController::class, 'showLinkRequestForm'])->name('Reset-password');
Route::post('/password/email', [RecuperarContrasenaController::class, 'sendResetLinkEmail'])->name('password.email');

// Ver página del código actual
Route::get('/codigo', [CodigoController::class, 'show'])->name('codigo');

// Obtener el código actual en JSON
Route::get('/codigo/actual', [CodigoController::class, 'actual'])->name('codigo.actual');

Route::middleware('session.auth')->group(function () {
    // Página de bienvenida (usar el mismo controlador que /home)
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('root');

    // Panel principal
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    // Perfil del usuario
    Route::get('/perfil', [PerfilController::class, 'show'])->name('perfil');

    // Panel de administración (vacío por ahora) — solo accesible para usuarios autenticados
    Route::get('/admin/panel', [PanelAdminController::class, 'index'])->name('admin.panel');
    // Lista de usuarios en panel admin
    Route::get('/admin/usuarios', [PanelAdminController::class, 'usuarios'])->name('admin.usuarios');

    // Registrar entrada de fichaje
    Route::post('/fichaje/entrada', [FichajeController::class, 'entrada'])->name('fichaje.entrada');
    // Registrar salida de fichaje
    Route::post('/fichaje/salida', [FichajeController::class, 'salida'])->name('fichaje.salida');
});
