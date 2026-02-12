<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inscricao_bpos', function (Blueprint $table) {
        $table->id();
        $table->string('projeto');
        $table->string('nome');
        $table->string('dataNascimento'); 
        $table->string('cpf'); 
        $table->string('sexo');
        $table->string('celular');
        $table->string('telefone')->nullable();
        $table->string('cidade');
        $table->string('escolaridade');
        $table->string('faculdade')->nullable();
        $table->string('curso')->nullable();
        $table->string('cnh')->nullable();
        $table->text('habilidades')->nullable(); 

        $table->string('funcionario', 1); // Aceita 'S' ou 'N'
        $table->string('ano')->nullable();
        $table->string('funcao')->nullable();
        $table->string('trabalha', 1); // Aceita 'S' ou 'N'
        $table->string('empregado')->nullable(); // Nome da empresa atual
        $table->string('temParente', 1); // Aceita 'S' ou 'N'
        $table->string('grauParente')->nullable();
        $table->string('parente')->nullable();
        $table->timestamps();
    });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inscricao_bpos');
    }

    
};
