<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultor extends Model
{
    use HasFactory;

    protected $table = 'consultor_comercial'; // Nome da tabela se for diferente do padrão
    protected $primaryKey = 'id';
    public $timestamps = false; // Se a tabela não tiver created_at/updated_at
    protected $fillable = [
        'nome_consultor',
        'sobrenome_consultor',
        'unidade',
        'ativo',
        'Foto'
    ];
}
