<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InscricaoController;


Route::get('/', [InscricaoController::class, 'home'])->name('menuInicial');

// Exibe a página de detalhes do curso (ex: /projeto/trator)
Route::get('/projeto/{tipo}', [InscricaoController::class, 'projeto'])->name('projeto.detalhes');

// Abre o formulário de inscrição (ex: /projetos/trator/questionario)
Route::get('/projetos/{id}/questionario', [InscricaoController::class, 'create'])->name('inscricao.create');

// Processa o envio do formulário (POST)
Route::post('/inscricao/salvar', [InscricaoController::class, 'store'])->name('inscricao.store');

// Tela de sucesso após inscrição
Route::get('/inscricao/sucesso/{tipo}', function($tipo) {
    return view('inscricaoBpo.sucesso', compact('tipo'));
})->name('inscricao.sucesso');


// Lista todos os candidatos
Route::get('/candidatos', [InscricaoController::class, 'lista'])->name('inscricao.lista');


Route::delete('/inscricao/{id}', [InscricaoController::class, 'destroy'])->name('inscricao.destroy');