<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ConsultorComercial;

class AnalistaController extends Controller
{
    public function index()
    {
        $analistas = ConsultorComercial::get(['id', 'nome_consultor', 'sobrenome_consultor'])
            ->map(function ($analista) {
                return [
                    'id' => $analista->id,
                    'nome_completo' => trim($analista->nome_consultor . ' ' . $analista->sobrenome_consultor),
                ];
            });

        return response()->json($analistas);
    }
}
