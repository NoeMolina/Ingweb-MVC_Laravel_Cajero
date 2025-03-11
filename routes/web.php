<?php

use App\Http\Controllers\CajaGeneralController;
use Illuminate\Support\Facades\Route;

Route::get("/",[CajaGeneralController::class, 'index'])->name("home");

Route::get('verCaja',[CajaGeneralController::class, 'verCaja']) ->name('verCaja');

Route::post('abrirCaja', [CajaGeneralController::class, 'abrirCaja'])->name('abrirCaja');

Route::post('agregarBilletes', [CajaGeneralController::class, 'agregarBilletes'])->name('agregarBilletes');

Route::post('canjearCheque', [CajaGeneralController::class, 'canjearCheque'])->name('canjearCheque');