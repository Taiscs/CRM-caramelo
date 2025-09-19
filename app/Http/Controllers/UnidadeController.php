<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UnidadeController extends Controller
{
    /**
     * Retorna o total de vendas por unidade, com filtros completos.
     * Inclui a quantidade de vendas e o valor total.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function vendasPorUnidade(Request $request)
    {
        // Obtém todos os parâmetros de filtro da requisição
        $ano      = $request->input('ano');
        $mes      = $request->input('mes');
        $situacao = $request->input('situacao');
        $vendedor = $request->input('vendedor');
        $unidade  = $request->input('unidade'); // Adicionado o filtro de unidade

        $query = DB::table('vendas')
            ->join('unidade', 'vendas.unidade', '=', 'unidade.ID')
            ->groupBy('unidade.NOME')
            ->select(
                'unidade.NOME',
                DB::raw('SUM(vendas.total) as totalVendas'),
                DB::raw('COUNT(vendas.id) as totalRegistros')
            );

        // Aplica todos os filtros recebidos na requisição
        if ($ano) {
            $query->whereYear('vendas.cadastro', $ano);
        }
        if ($mes) {
            $query->whereMonth('vendas.cadastro', $mes);
        }
        if ($situacao) {
            $query->where('vendas.situacao', $situacao);
        }
        if ($vendedor) {
            $query->where('vendas.vendedor_id', $vendedor);
        }
        if ($unidade) {
            $query->where('vendas.unidade', $unidade); // Aplica o filtro da unidade
        }

        $vendasPorUnidade = $query->get();

        return response()->json($vendasPorUnidade);
    }

    /**
     * Retorna a lista de anos disponíveis nas vendas.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function anosDisponiveis()
    {
        $anos = DB::table('vendas')
            ->select(DB::raw('YEAR(cadastro) as ano'))
            ->distinct()
            ->orderBy('ano', 'desc')
            ->get();

        return response()->json($anos);
    }
}
