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

Route::get('/turno/{mac}', [KioskController::class, 'turno'])->name('turno');
Route::get('/turno-paciente-nuevo/{mac}', [KioskController::class, 'turnoPacienteNuevo'])->name('turnoPacienteNuevo');

Route::get('/proximas-citas/{mac}', [KioskController::class, 'proximasCitas'])->name('proximasCitas');
Route::get('/paquetes-preventivos/{mac}', [KioskController::class, 'paquetesPreventivos'])->name('paquetesPreventivos');
Route::get('/detalle-paquete/{mac}', [KioskController::class, 'detallePaquete'])->name('detallePaquete');
Route::get('/asignar-paquete/{mac}', [KioskController::class, 'asignarPaquete'])->name('asignarPaquete');
Route::get('/mis-paquetes/{mac}', [KioskController::class, 'misPreventivos'])->name('misPreventivos');
Route::get('/detalle-paquete-comprado/{mac}', [KioskController::class, 'detallePaqueteComprado'])->name('detallePaqueteComprado');

Route::get('/cita-elegir-paciente/{mac}', [KioskController::class, 'citaElegirPaciente'])->name('citaElegirPaciente');
Route::get('/cita-elegir-modalidad/{mac}', [KioskController::class, 'citaElegirModalidad'])->name('citaElegirModalidad');
Route::get('/cita-elegir-datos/{mac}', [KioskController::class, 'citaElegirDatos'])->name('citaElegirDatos');
Route::get('/citas-elegir-fecha-doctor/{mac}', [KioskController::class, 'citaElegirFecha'])->name('citaElegirFecha');
Route::get('/citas-revisa-tus-datos/{mac}', [KioskController::class, 'citaReservar'])->name('citaReservar');

Route::get('/tratamientos/{mac}', [KioskController::class, 'tratamientos'])->name('tratamientos');
Route::get('/detalle-tratamiento/{mac}', [KioskController::class, 'detalleTratamiento'])->name('detalleTratamiento');

Route::get('/chequeos/{mac}', [KioskController::class, 'chequeos'])->name('chequeos');

Route::get('/carrito/{mac}', [KioskController::class, 'carrito'])->name('carrito');
Route::get('/datos-facturacion/{mac}', [KioskController::class, 'datosFacturacion'])->name('datosFacturacion');
Route::get('/metodos-pago/{mac}', [KioskController::class, 'listaMetodosPago'])->name('listaMetodosPago');
Route::get('/pago-realizado/{mac}', [KioskController::class, 'pagoExitoso'])->name('pagoExitoso');

Route::get('/host/{mac}', [KioskController::class, 'host'])->name('host');

// Route::get('/ingreso/{mac}', [KioskController::class, 'ingreso'])->name('ingreso');