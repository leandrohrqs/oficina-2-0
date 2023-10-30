<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrcamentoController;
use App\Http\Controllers\SiteController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [SiteController::class, 'index'])->name('site.index');

Route::get('/orcamento/{id}', [SiteController::class, 'details'])->name('orcamento.details');

Route::get('/criar-orcamento', [SiteController::class, 'criarOrcamento'])->name('orcamento.create');

Route::post('insertOrcamento', [SiteController::class,'insertOrcamento'])->name('orcamento.insert');

Route::get('updateOrcamento/{id}', [SiteController::class, 'updateOrcamento'])->name('orcamento.update');

Route::post('insertUpdate', [SiteController::class, 'insertUpdate'])->name('orcamento.insertUpdate');

Route::delete('/orcamento/delete/{id}', [SiteController::class, 'destroy'])->name('orcamento.delete');
