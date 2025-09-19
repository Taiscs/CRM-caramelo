<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unidade extends Model
{
    use HasFactory;

    protected $table = 'unidade'; // nome exato da tabela no banco
    protected $primaryKey = 'ID'; // chave primária da tabela
    public $timestamps = false;   // se a tabela não tiver created_at / updated_at
}
