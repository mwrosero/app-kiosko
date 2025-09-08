<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KioskController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/refreshToken', [KioskController::class, 'refreshToken'])->name('refreshToken');
Route::get('/{mac}', [KioskController::class, 'index'])->name('index');
Route::get('/ingreso/{mac}', [KioskController::class, 'ingreso'])->name('ingreso');
Route::get('/menu/{mac}', [KioskController::class, 'menu'])->name('menu');

Route::get('/proximas-citas/{mac}', [KioskController::class, 'proximasCitas'])->name('proximasCitas');
Route::get('/paquetes-preventivos/{mac}', [KioskController::class, 'paquetesPreventivos'])->name('paquetesPreventivos');
Route::get('/detalle-paquete/{mac}', [KioskController::class, 'detallePaquete'])->name('detallePaquete');

Route::get('/asignar-paquete/{mac}', [KioskController::class, 'asignarPaquete'])->name('asignarPaquete');

Route::get('/carrito/{mac}', [KioskController::class, 'carrito'])->name('carrito');
Route::get('/datos-facturacion/{mac}', [KioskController::class, 'datosFacturacion'])->name('datosFacturacion');
Route::get('/metodos-pago/{mac}', [KioskController::class, 'listaMetodosPago'])->name('listaMetodosPago');
Route::get('/pago-realizado/{mac}', [KioskController::class, 'pagoExitoso'])->name('pagoExitoso');

// Route::get('/kiosko/{mac}', [KioskController::class, 'kiosko'])->name('kiosko');
// Route::get('/ingreso/{mac}', [KioskController::class, 'ingreso'])->name('ingreso');