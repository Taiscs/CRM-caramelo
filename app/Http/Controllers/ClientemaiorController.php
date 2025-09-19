<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientemaiorController extends Controller
{
    /**
     * Retorna o cliente que mais comprou, com base em filtros opcionais.
     */
    public function kpiCliente(Request $request)
    {
        // Filtros padrão
        $ano = $request->query('ano', 'all');
        $mes = $request->query('mes', 'all');
        $cliente = $request->query('cliente', 'all');
        $vendedor = $request->query('vendedor', 'all');
        $unidade = $request->query('unidade', 'all');
        $situacao = $request->query('situacao', 'all');

        // Query base
        $queryVendas = DB::table('vendas');

        // Aplica filtros condicionalmente
        if ($ano !== 'all') {
            $queryVendas->whereYear('cadastro', $ano);
        }
        if ($mes !== 'all') {
            $queryVendas->whereMonth('cadastro', $mes);
        }
        if ($cliente !== 'all') {
            $queryVendas->where('cliente', $cliente);
        }
        if ($vendedor !== 'all') {
            $queryVendas->where('vendedor', $vendedor);
        }
        if ($unidade !== 'all') {
            $queryVendas->where('unidade', $unidade);
        }
        if ($situacao !== 'all') {
            $queryVendas->where('situacao', $situacao);
        }

        // Encontra o cliente com maior valor total de compras
        $clienteMaisComprou = (clone $queryVendas)
            ->whereNotNull('cliente')
            ->where('cliente', '!=', '')
            ->select('cliente', DB::raw('COUNT(*) as totalCompras'), DB::raw('SUM(total) as valorTotalCompras'))
            ->groupBy('cliente')
            ->orderByDesc('valorTotalCompras')
            ->first();

        // Retorna os dados em formato JSON
        return response()->json([
            'clienteMaisComprou' => [
                'cliente' => $clienteMaisComprou->cliente ?? '-', 
                'totalCompras' => $clienteMaisComprou->totalCompras ?? 0, 
                'valorTotal' => $clienteMaisComprou->valorTotalCompras ?? 0
            ]
        ]);
    }
}
