<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/* |-------------------------------------------------------------------------- | Web Routes |-------------------------------------------------------------------------- | | Here is where you can register web routes for your application. These | routes are loaded by the RouteServiceProvider within a group which | contains the "web" middleware group. Now create something great! | */

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/gerenciador-de-despesa', [App\Http\Controllers\HomeController::class , 'index'])->name('home');
Route::get('/gerenciador-de-despesa/logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::middleware(['editor'])->group(function () {
    Route::get('/gerenciador-de-despesa/despesas', [App\Http\Controllers\DispensaController::class , 'index'])->name('dispensa.index');
    Route::get('/gerenciador-de-despesa/filtrar', [App\Http\Controllers\DispensaController::class , 'show'])->name('dispensa.show');
    Route::get('/gerenciador-de-despesa/cadastrar-despesa/novo', [App\Http\Controllers\DispensaController::class , 'create'])->name('dispensa.create');
    Route::post('/gerenciador-de-despesa/cadastrar-despesa/salvar', [App\Http\Controllers\DispensaController::class , 'store'])->name('dispensa.store');
    Route::get('/gerenciador-de-despesa/editar-despesa/{id}', [App\Http\Controllers\DispensaController::class , 'edit'])->name('dispensa.edit');
    Route::post('/gerenciador-de-despesa/update-despesa/{id}', [App\Http\Controllers\DispensaController::class , 'update'])->name('dispensa.update');
    Route::delete('/gerenciador-de-despesa/excluir-despesa/{id}', [App\Http\Controllers\DispensaController::class , 'destroy'])->name('dispensa.destroy');
});

Route::middleware(['admin'])->group(function () {
    Route::get('/townhalls/listar-orgaos-publicos', [App\Http\Controllers\TownhallsController::class , 'listarTudo'])->name('townhalls.listarTudo');
    Route::get('/townhalls/cadastrar-orgao-publico/novo', [App\Http\Controllers\TownhallsController::class , 'novaPrefeitura'])->name('townhalls.novaPrefeitura');
    Route::post('/townhalls/salvar-orgao-publico/salvar', [App\Http\Controllers\TownhallsController::class , 'salvarPrefeitura'])->name('townhalls.salvarPrefeitura');
    Route::delete('/townhalls/excluir-orgao-publico/{id}', [App\Http\Controllers\TownhallsController::class , 'excluirPrefeitura'])->name('townhalls.excluirPrefeitura');
    Route::get('/townhalls/editar-orgao-publico/{id}', [App\Http\Controllers\TownhallsController::class , 'editarPrefeitura'])->name('townhalls.editarPrefeitura');
    Route::post('/townhalls/update-orgao-publico/{id}', [App\Http\Controllers\TownhallsController::class , 'updatePrefeitura'])->name('townhalls.updatePrefeitura');
    Route::post('/config/updateConfig', [App\Http\Controllers\ConfigController::class , 'updateConfig'])->name('configs.updateConfig');
    Route::get('/config/carregar-config', [App\Http\Controllers\ConfigController::class , 'carregarConfig'])->name('configs.carregarConfig');
    Route::get('/cnae/atualizar-base-cnae', [App\Http\Controllers\CnaeController::class , 'create'])->name('cnae.create');
    Route::post('/cnae/atualizar-base-cnae', [App\Http\Controllers\CnaeController::class , 'update'])->name('cnae.update');
});

Route::middleware(['administrador'])->group(function () {
    Route::get('/gerenciador-de-despesa/listar-usuarios', [App\Http\Controllers\UsersController::class , 'listarTudo'])->name('users.listarTudo');
    Route::get('/gerenciador-de-despesa/cadastrar-usuario/novo', [App\Http\Controllers\UsersController::class , 'novoUsuario'])->name('users.novoUsuario');
    Route::post('/gerenciador-de-despesa/salvar-usuario/salvar', [App\Http\Controllers\UsersController::class , 'salvarUsuario'])->name('users.salvarUsuario');
    Route::delete('/gerenciador-de-despesa/excluir-usuario/{id}', [App\Http\Controllers\UsersController::class , 'excluirUsuario'])->name('users.excluirUsuario');
    Route::get('/gerenciador-de-despesa/editar-usuario/{id}', [App\Http\Controllers\UsersController::class , 'editarUsuario'])->name('users.editarUsuario');
    Route::post('/gerenciador-de-despesa/update-usuario/{id}', [App\Http\Controllers\UsersController::class , 'updateUsuario'])->name('users.updateUsuario');
    Route::get('/gerenciador-de-despesa/log-alteracoes', [App\Http\Controllers\LogsController::class , 'alteracoes'])->name('logs.alteracoes');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/gerenciador-de-despesa/minha-conta', [App\Http\Controllers\UsersController::class , 'minhaConta'])->name('users.minhaConta');
    Route::post('/gerenciador-de-despesa/update-conta/{id}', [App\Http\Controllers\UsersController::class , 'updateConta'])->name('users.updateConta');
    Route::post('/gerenciador-de-despesa/update-senha/{id}', [App\Http\Controllers\UsersController::class , 'updateSenha'])->name('users.updateSenha');
    Route::get('/gerenciador-de-despesa/relatorio/total-despesa', [App\Http\Controllers\RelatorioController::class , 'totalDispensa'])->name('relatorio.totalDispensa');
    Route::get('/gerenciador-de-despesa/relatorio/por-subclasse', [App\Http\Controllers\RelatorioController::class , 'porSubclasse'])->name('relatorio.porSubclasse');
    Route::get('/gerenciador-de-despesa/relatorio/por-subclasse-resumido', [App\Http\Controllers\RelatorioController::class , 'porSubclasseResumido'])->name('relatorio.porSubclasseResumido');
    Route::get('/gerenciador-de-despesa/relatorio/gerar-pdf-total-despesa', [App\Http\Controllers\PDFController::class , 'gerarPdfTotalDispensa'])->name('pdf.gerarPdfTotalDispensa');
    Route::get('/gerenciador-de-despesa/relatorio/gerar-pdf-por-subclasse', [App\Http\Controllers\PDFController::class , 'gerarPdfPorSubclasse'])->name('pdf.gerarPdfPorSubclasse');
    Route::get('/gerenciador-de-despesa/relatorio/gerar-pdf-por-subclasse-resumido', [App\Http\Controllers\PDFController::class , 'gerarPdfPorSubclasseResumido'])->name('pdf.gerarPdfPorSubclasseResumido');
});