<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RelatorioController extends Controller
{
    public function index()
    {
        return view('resultados');
    }

    public function kpis(Request $request)
    {
        // Filtros padrão
        $ano = $request->query('ano', date('Y'));
        $mes = $request->query('mes', date('m'));
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

        // Pacote mais vendido
        $pacoteMaisVendido = (clone $queryVendas)
            ->whereNotNull('pacotes')
            ->where('pacotes', '!=', '')
            ->select('pacotes', DB::raw('COUNT(*) as totalVendido'))
            ->groupBy('pacotes')
            ->orderByDesc('totalVendido')
            ->first();

        $pacote = $pacoteMaisVendido->pacotes ?? '-';
        $quantidadePacote = $pacoteMaisVendido->totalVendido ?? 0;

        return response()->json([
            'pacoteMaisVendido' => [
                'pacote' => $pacote,
                'totalVendido' => $quantidadePacote
            ],
        ]);
    }
}
