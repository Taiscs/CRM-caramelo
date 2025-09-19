<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consultor;
use App\Models\Venda;

class KpiVendasController extends Controller
{
    public function index(Request $request)
    {
        // Pega os filtros da requisição
        $ano = $request->query('ano');
        $mes = $request->query('mes');
        $unidade = $request->query('unidade');
        $vendedorId = $request->query('vendedor');
        $situacao = $request->query('situacao');

        // Pega todos os consultores ativos
        $consultores = Consultor::where('ativo', 1)->get();

        $sellerPerformance = $consultores->map(function($consultor) use ($ano, $mes, $unidade, $vendedorId, $situacao) {
            $vendas = Venda::where('vendedor_id', $consultor->id)
                ->when($ano, fn($q) => $q->whereYear('cadastro', $ano))
                ->when($mes, fn($q) => $q->whereMonth('cadastro', $mes))
                ->when($unidade, fn($q) => $q->where('unidade', $unidade))
                ->when($vendedorId, fn($q) => $q->where('vendedor_id', $vendedorId))
                ->when($situacao, fn($q) => $q->where('situacao', $situacao))
                ->where('situacao', '!=', 'cancelado')
                ->get();

            $totalSold = $vendas->sum('pacotes_valor_manual'); 
            $packagesSold = $vendas->count();
            $newClients = $vendas->filter(fn($venda) => $venda->cliente_id !== null)->unique('cliente_id')->count();

            return [
                'id' => $consultor->id,
                'name' => $consultor->nome_consultor . ' ' . $consultor->sobrenome_consultor,
                'photo' => $consultor->foto  ? url($consultor->foto)  : url('assets/default-avatar.png'),
                'totalSold' => $totalSold,
                'packagesSold' => $packagesSold,
                'newClients' => $newClients,
                'additionalsSold' => 0
            ];
        });

        return response()->json([
            'sellerPerformance' => $sellerPerformance
        ]);
    }
}
