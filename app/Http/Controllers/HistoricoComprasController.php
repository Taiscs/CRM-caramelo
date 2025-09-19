<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HistoricoComprasController extends Controller
{
    /**
     * Retorna o histórico de vendas de um cliente específico.
     *
     * @param string $cliente O nome do cliente para buscar o histórico.
     * @return \Illuminate\Http\JsonResponse
     */
    public function historicoVendas($cliente)
{
    $historico = DB::table('vendas')
        ->whereRaw('LOWER(cliente) = ?', [strtolower($cliente)])
        ->select('id', 'evento', 'pacotes', 'total', 'situacao', 'data_evento')
        ->orderBy('data_evento', 'desc')
        ->get();

    return response()->json($historico);
}

}