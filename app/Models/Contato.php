<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contato extends Model
{
    use HasFactory;

    protected $table = 'contatos';

    // Campos que podem ser preenchidos via mass assignment
protected $fillable = [
    'nome_consultor',
    'sobrenome_consultor',
    'unidade',
    'ativo',
    'foto'
];

}
