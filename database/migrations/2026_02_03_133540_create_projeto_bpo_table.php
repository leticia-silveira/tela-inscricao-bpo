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
    //     Schema::create('projeto_bpo', function (Blueprint $table) {
    //         $table->id();
    //         $table->timestamps();
    //     });
    // }

    public function up()
    {
        Schema::create('projetoBpo', function (Blueprint $table) {
            $table->id('idProjeto'); 
            $table->string('nomeBpo');
            $table->string('tituloBpo')->nullable();
            $table->string('cidade')->nullable();
            $table->date('dataInicio')->nullable();
            $table->date('dataFim')->nullable();
            $table->string('imagem')->nullable();
            $table->string('tipo'); 
            $table->integer('statusProjeto');
            $table->text('explicacaoProjeto')->nullable();
            $table->text('requisitos')->nullable();
            $table->text('criterios')->nullable();
            $table->text('aprovacao')->nullable();
            $table->text('certificacao')->nullable();
            $table->text('oportunidade')->nullable();
            $table->text('disposicoesGerais')->nullable();
            $table->string('titulo')->nullable();
            $table->string('habilidade')->nullable();
            $table->integer('Usuario_id')->nullable();
            
            
            //  View pede {{$p->FormId}} para o botão de cadastro.
            $table->string('FormId')->nullable(); 

            $table->timestamp('dataCriacao')->useCurrent();
            $table->timestamps();
        });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projeto_bpo');
    }
};
