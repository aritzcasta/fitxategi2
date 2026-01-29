<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RecuperarContrasenaController;
use App\Http\Controllers\CodigoController;
use App\Http\Controllers\FichajeController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\PanelAdminController;

// Rutas de autenticación (login, register, logout, etc.)
Auth::routes(['verify' => true]);

// Recuperar contraseña
Route::get('/password', [RecuperarContrasenaController::class, 'showLinkRequestForm'])->name('Reset-password');
Route::post('/password/email', [RecuperarContrasenaController::class, 'sendResetLinkEmail'])->name('password.email');



Route::middleware(['session.auth', 'verified'])->group(function () {
    // Página de bienvenida (usar el mismo controlador que /home)
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('root');

    // Panel principal
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    // Perfil del usuario
    Route::get('/perfil', [PerfilController::class, 'show'])->name('perfil');

    // Rutas de administración — requieren rol admin
    Route::middleware(\App\Http\Middleware\RequireAdmin::class)->group(function () {

        // Ver página del código actual
        Route::get('/codigo', [CodigoController::class, 'show'])->name('codigo');

        // Obtener el código actual en JSON
        Route::get('/codigo/actual', [CodigoController::class, 'actual'])->name('codigo.actual');

        // Panel de administración
        Route::get('/admin/panel', [PanelAdminController::class, 'index'])->name('admin.panel');
        // Justificaciones (fichajes justificados)
        Route::get('/admin/justificaciones', [PanelAdminController::class, 'justificaciones'])->name('admin.justificaciones');

        // Festivos
        Route::get('/admin/festivos', [PanelAdminController::class, 'festivos'])->name('admin.festivos');
        Route::post('/admin/festivos', [PanelAdminController::class, 'festivosStore'])->name('admin.festivos.store');
        Route::delete('/admin/festivos', [PanelAdminController::class, 'festivosDestroyMany'])->name('admin.festivos.destroyMany');
        Route::delete('/admin/festivos/{id}', [PanelAdminController::class, 'festivosDestroy'])->name('admin.festivos.destroy');

        // Lista de usuarios en panel admin
        Route::get('/admin/usuarios', [PanelAdminController::class, 'usuarios'])->name('admin.usuarios');

        Route::get('/admin/usuarios/{id}/edit', [PanelAdminController::class, 'usuarioEdit'])->name('admin.usuarios.edit');

        Route::patch('/admin/usuarios/{id}', [PanelAdminController::class, 'usuarioUpdate'])->name('admin.usuarios.update');

        // Empresas
        Route::get('/admin/empresas', [PanelAdminController::class, 'empresas'])->name('admin.empresas');

        // Crear empresa
        Route::get('/admin/crearempresas', [PanelAdminController::class, 'empresaCreate'])->name('admin.crearempresas');
        Route::post('/admin/empresas', [PanelAdminController::class, 'empresaStore'])->name('admin.empresas.store');

        Route::get('/admin/empresas/{id}', [PanelAdminController::class, 'empresaShow'])->name('admin.empresas.show');

        // Exportar empresa (Excel / PDF)
        Route::get('/admin/empresas/{id}/export/excel', [PanelAdminController::class, 'empresaExportExcel'])->name('admin.empresas.export.excel');
        
        Route::get('/admin/empresas/{id}/export/pdf', [PanelAdminController::class, 'empresaExportPdf'])->name('admin.empresas.export.pdf');
    });

    // Registrar entrada de fichaje
    Route::post('/fichaje/entrada', [FichajeController::class, 'entrada'])->name('fichaje.entrada');
    // Registrar salida de fichaje
    Route::post('/fichaje/salida', [FichajeController::class, 'salida'])->name('fichaje.salida');
    // Justificar falta (descripcion + foto opcional)
    Route::post('/fichaje/justificar', [FichajeController::class, 'justificar'])->name('fichaje.justificar');
});
