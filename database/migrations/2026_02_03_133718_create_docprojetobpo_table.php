<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // public function up(): void
    // {
    //     Schema::create('docprojetobpo', function (Blueprint $table) {
    //         $table->id();
    //         $table->timestamps();
    //     });
    // }

    public function up()
    {
        Schema::create('docprojetobpo', function (Blueprint $table) {
            $table->id('idBpo'); // Primary Key do print
            $table->unsignedBigInteger('Projeto_id')->index(); // FK para a tabela projetoBpo
            $table->string('projeto')->nullable(); // Nome textual do projeto
            $table->string('nome');
            $table->string('cpf', 14);
            $table->date('dataNascimento')->nullable();
            $table->string('celular')->nullable();
            $table->string('telefone')->nullable();
            $table->integer('idade')->nullable();
            $table->string('cnh')->nullable();
            $table->string('cidade')->nullable();
            $table->string('escolaridade')->nullable();
            $table->string('faculdade')->nullable();
            $table->string('estadoCivil')->nullable();
            $table->string('ano')->nullable();
            $table->string('funcao')->nullable();
            $table->string('parente')->nullable();
            $table->text('habilidades')->nullable();
            $table->string('funcionario')->nullable();
            $table->string('empregado')->nullable();
            $table->string('termos')->nullable();
            $table->date('dataEnvio')->nullable();
            $table->string('sexo')->nullable();
            $table->string('horarioTreinamento')->nullable();
            $table->integer('StatusBpo')->default(1); // 1 = Analisar, conforme seu Controller
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('docprojetobpo');
    }
};
