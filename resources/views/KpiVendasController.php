
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consultor;
use App\Models\Venda;

class KpiVendasController extends Controller
{
    public function index(Request $request)
    {
        $ano = $request->query('ano');
        $mes = $request->query('mes');
        $unidade = $request->query('unidade');
        $vendedorId = $request->query('vendedor');
        $situacao = $request->query('situacao');

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

            // Garantir que todos os campos numéricos sejam float/int, tratando NULL
            $totalSold = $vendas->sum(fn($venda) => (float) ($venda->pacotes_valor_manual ?? 0));
            $packagesSold = $vendas->count();
            $newClients = $vendas->filter(fn($venda) => $venda->cliente_id !== null)->unique('cliente_id')->count();

            // Exemplo de campos adicionais seguros
            $additionalsSold = $vendas->sum(fn($venda) => (float) ($venda->desconto ?? 0) + (float) ($venda->acrescimo ?? 0));

            return [
                'id' => $consultor->id,
                'name' => $consultor->nome_consultor . ' ' . $consultor->sobrenome_consultor,
                'photo' => $consultor->foto ? url($consultor->foto) : url('assets/default-avatar.png'),
                'totalSold' => $totalSold,
                'packagesSold' => $packagesSold,
                'newClients' => $newClients,
                'additionalsSold' => $additionalsSold
            ];
        });

        return response()->json([
            'sellerPerformance' => $sellerPerformance
        ]);
    }
}
