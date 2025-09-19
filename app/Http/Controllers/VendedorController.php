<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VendedorController extends Controller
{
    /**
     * Retorna o vendedor que mais vendeu, com base em filtros opcionais.
     */
    public function kpiVendedor(Request $request)
    {
        // Filtros padrão
        $ano = $request->query('ano', 'all');
        $mes = $request->query('mes', 'all');
        $vendedor = $request->query('vendedor', 'all');
        $unidade = $request->query('unidade', 'all');
        $situacao = $request->query('situacao', 'all');

        // Query base
        $queryVendas = DB::table('vendas');

        // Aplica filtros
        if ($ano !== 'all') {
            $queryVendas->whereYear('cadastro', $ano);
        }
        if ($mes !== 'all') {
            $queryVendas->whereMonth('cadastro', $mes);
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

        // Encontra o vendedor que mais vendeu e o valor total em vendas
        $vendedorMaisVendeu = (clone $queryVendas)
            ->whereNotNull('vendedor')
            ->where('vendedor', '!=', '')
             ->where('situacao', '!=', 'cancelado')
            ->select('vendedor', DB::raw('COUNT(*) as totalVendas'), DB::raw('SUM(pacotes_valor_manual) as valorTotalVendas'))
            ->groupBy('vendedor')
            ->orderByDesc('totalVendas')
            ->first();

        $vendedorComum = $vendedorMaisVendeu->vendedor ?? '-';
        $totalVendasVendedor = $vendedorMaisVendeu->totalVendas ?? 0;
        $valorTotalVendas = $vendedorMaisVendeu->valorTotalVendas ?? 0;

        // Retorna os dados em formato JSON
        return response()->json([
            'vendedorMaisVendeu' => [
                'vendedor' => $vendedorComum, 
                'totalVendas' => $totalVendasVendedor, 
                'valorTotal' => $valorTotalVendas
            ]
        ]);
    }
}
