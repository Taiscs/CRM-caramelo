<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FonteController extends Controller
{
    /**
     * Retorna a principal fonte de captação com base em filtros opcionais.
     */
    public function kpiFonte(Request $request)
    {
        // Definição dos filtros com valores padrão 'all'
        $ano = $request->query('ano', 'all');
        $mes = $request->query('mes', 'all');
        $vendedor = $request->query('vendedor', 'all');
        $unidade = $request->query('unidade', 'all');
        $situacao = $request->query('situacao', 'all');

        // Cria a query base para vendas, excluindo as canceladas
        $queryVendas = DB::table('vendas')->where('situacao', '!=', 'cancelado');

        // Aplica os filtros condicionalmente
        if ($ano !== 'all') $queryVendas->whereYear('cadastro', $ano);
        if ($mes !== 'all') $queryVendas->whereMonth('cadastro', $mes);
        if ($vendedor !== 'all') $queryVendas->where('vendedor', $vendedor);
        if ($unidade !== 'all') $queryVendas->where('unidade', $unidade);
        if ($situacao !== 'all') $queryVendas->where('situacao', $situacao);

        // Encontra a principal fonte de captação com base no campo marketing
        $fonteMaisComum = (clone $queryVendas)
            ->whereNotNull('marketing')
            ->where('marketing', '!=', '')
            ->select('marketing', DB::raw('COUNT(*) as totalCaptado'))
            ->groupBy('marketing')
            ->orderByDesc('totalCaptado')
            ->first();

        // Total de leads para calcular a porcentagem
        $totalLeads = (clone $queryVendas)->count();
        $fonte = $fonteMaisComum->marketing ?? '-';
        $porcentagem = ($totalLeads > 0 && $fonteMaisComum) ? round(($fonteMaisComum->totalCaptado / $totalLeads) * 100) : 0;

        // Retorna os dados em formato JSON
        return response()->json([
            'fonteMaisVendida' => ['fonte' => $fonte, 'porcentagem' => $porcentagem]
        ]);
    }
}
