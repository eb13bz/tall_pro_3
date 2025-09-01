<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\Auth;

Route::get('/', [HomeController::class, 'index'])->middleware('auth');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Módulos con acceso restringido por rol
    
    // Rutas para el Módulo de Usuarios (Solo Administrador)
    Route::middleware([CheckRole::class.':Administrador'])->group(function () {
        Route::resource('usuarios', UserController::class);
    });

    // Rutas para el Módulo de Productos y Categorías (Administrador y Almacenero)
    Route::middleware([CheckRole::class.':Administrador,Almacenero'])->group(function () {
        Route::resource('categorias', CategoriaController::class);
        Route::resource('productos', ProductoController::class);
    });

    // Rutas para el Módulo de Clientes (Acceso de Vendedor y Administrador)
    Route::middleware([CheckRole::class.':Administrador,Vendedor'])->group(function () {
        Route::resource('clientes', ClienteController::class);
    });

    // Rutas para el Módulo de Ventas (¡Orden Importante!)
    // La ruta de historial va ANTES de la ruta de recurso para evitar el conflicto
    Route::middleware([CheckRole::class.':Administrador,Vendedor'])->group(function () {
        Route::get('/ventas/historial', [VentaController::class, 'history'])->name('ventas.history');
        Route::post('/ventas/{venta}/anular', [VentaController::class, 'anular'])->name('ventas.anular');
        Route::resource('ventas', VentaController::class);
    });
    
    // Rutas para el Módulo de Reportes (Solo Administrador)
    Route::middleware([CheckRole::class.':Administrador'])->group(function () {
        Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');
        Route::get('/reportes/ventas', [ReporteController::class, 'reporteVentas'])->name('reportes.ventas');
        Route::get('/reportes/stock-bajo', [ReporteController::class, 'reporteStockBajo'])->name('reportes.stockBajo');
        Route::get('/reportes/clientes-frecuentes', [ReporteController::class, 'reporteClientesFrecuentes'])->name('reportes.clientesFrecuentes');
    });
});

require __DIR__.'/auth.php';