<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InscricaoBpo extends Model
{

    // protected $table = 'inscricao_bpos';
    protected $table = 'docprojetobpo';
    protected $primaryKey = 'idBpo';    
    public $timestamps = false;

    

    protected $fillable = [
        'Projeto_id', // ID numérico do projeto
        'cpf', 
        'nome', 
        'dataNascimento', 
        'email', 
        'celular', 
        'telefone', 
        'idade', 
        'cnh', 
        'cidade', 
        'escolaridade', 
        'faculdade', 
        'estadoCivil', 
        'funcionario', 
        'ano', 
        'funcao', 
        'habilidades', 
        'empregado',    
        'empresaAtual', 
        'parente', 
        'StatusBpo', 
        'termos', 
        'Usuario_id', 
        'dataEnvio', 
        'projeto',     
        'sexo', 
        'horarioTreinamento', 
        'dataHoraEnvio', 
        'dataCriacao',
        'curso', 
        'temParente', 
        'grauParente'
    ];

    

    

    
}
