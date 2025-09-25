<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Oportunidade extends Model
{
    use HasFactory;

    /**
     * Define o nome da tabela no banco de dados.
     * @var string
     */
    protected $table = 'oportunidades';
    
    /**
     * Define que o modelo não usará colunas de timestamp (created_at e updated_at).
     * @var bool
     */
    public $timestamps = false;

    /**
     * Define os campos que podem ser preenchidos em massa.
     * @var array<int, string>
     */
    protected $fillable = [
        'vendedor_id',
        'cliente_id',
        'descricao_oportunidade',
        'data_oportunidade',
    ];
}
