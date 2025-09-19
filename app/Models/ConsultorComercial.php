<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsultorComercial extends Model
{
    protected $table = 'consultor_comercial'; // nome da tabela no banco
    protected $primaryKey = 'id';
    public $timestamps = false; // se não tiver created_at e updated_at

    protected $fillable = [
        'nome_consultor',
        'sobrenome_consultor',
        'unidade',
        'ativo'
    ];
}
