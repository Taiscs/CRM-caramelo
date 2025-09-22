<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class GraficosController extends Controller
{
    /**
     * Retorna a contagem de clientes agrupada pela fonte de marketing.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function leadsPorFonte()
    {
        $leads = DB::table('clientes')
            ->join('fonte_capitacao', 'clientes.Marketing', '=', 'fonte_capitacao.id_fonte')
            ->select('fonte_capitacao.nome as fonte', DB::raw('count(*) as total'))
            ->whereNotNull('clientes.Marketing')
            ->groupBy('fonte_capitacao.nome')
            ->get();

        return response()->json($leads);
    }

    /**
     * Retorna os dados de clientes novos vs recorrentes.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function clientesNovosVsRecorrentes(Request $request)
    {
        try {
            $anoSelecionado = $request->query('ano', date('Y'));
            $labels = [];
            $novos_clientes = [];
            $recorrentes = [];

            for ($mesNumero = 1; $mesNumero <= 12; $mesNumero++) {
                $labels[] = \Carbon\Carbon::create($anoSelecionado, $mesNumero, 1)->format('M Y');

                $inicioMes = \Carbon\Carbon::create($anoSelecionado, $mesNumero, 1)->startOfMonth();
                $fimMes = \Carbon\Carbon::create($anoSelecionado, $mesNumero, 1)->endOfMonth();

                // Clientes novos: primeira compra dentro do mês
                $novos = DB::table('vendas')
                    ->select('cliente')
                    ->where('situacao', '!=', 'cancelado')
                    ->whereBetween('cadastro', [$inicioMes, $fimMes])
                    ->groupBy('cliente')
                    ->havingRaw('MIN(cadastro) BETWEEN ? AND ?', [$inicioMes, $fimMes])
                    ->count();
                    // Clientes recorrentes: compraram no mês, mas já tinham comprado antes
                    $recorrente = DB::table('vendas as v')
                        ->where('v.situacao', '!=', 'cancelado')
                        ->whereBetween('v.cadastro', [$inicioMes, $fimMes])
                        ->whereExists(function ($query) use ($inicioMes) {
                            $query->select(DB::raw(1))
                                ->from('vendas as v2')
                                ->whereColumn('v2.cliente', 'v.cliente')
                                ->where('v2.cadastro', '<', $inicioMes)
                                ->where('v2.situacao', '!=', 'cancelado');
                        })
                        ->distinct('v.cliente')
                        ->count();


                $novos_clientes[] = $novos;
                $recorrentes[] = $recorrente;
            }

            return response()->json([
                'labels' => $labels,
                'novos_clientes' => $novos_clientes,
                'recorrentes' => $recorrentes
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ]);
        }
    }


    public function mesesDisponiveis()
    {
        // Meses disponíveis com vendas
        $meses = DB::table('vendas')
            ->select(DB::raw('MONTH(cadastro) as mes'))
            ->distinct()
            ->orderBy('mes', 'asc')
            ->pluck('mes');
        return response()->json($meses);
    }

    public function anosDisponiveis()
    {
        $anos = \DB::table('vendas')
            ->selectRaw('YEAR(cadastro) as ano')
            ->where('situacao', '!=', 'cancelado')
            ->groupBy('ano')
            ->orderByDesc('ano')
            ->pluck('ano');

        return response()->json($anos);
    }

    public function unidadesDisponiveis()
    {
        $unidades = DB::table('unidade')
            ->select('ID', 'NOME')
            ->orderBy('NOME')
            ->get();

        return response()->json($unidades);
    }

    public function vendedoresDisponiveis()
    {
        $vendedores = \DB::table('vendas')
            ->selectRaw('DISTINCT vendedor_id, vendedor')
            ->whereNotNull('vendedor_id')
            ->get();

        return response()->json($vendedores);
    }

    public function situacoesDisponiveis()
    {
        $situacoes = \DB::table('vendas')
            ->selectRaw('DISTINCT situacao')
            ->whereNotNull('situacao')
            ->pluck('situacao');

        return response()->json($situacoes);
    }

    public function vendasTotaisPorVendedor(Request $request) 
    {
        $ano     = $request->input('ano');
        $mes     = $request->input('mes');
        $unidade = $request->input('unidade');
        $vendedor = $request->input('vendedor');
        $situacao = $request->input('situacao');

        $query = DB::table('vendas')
            ->join('consultor_comercial', function($join) {
                $join->on('vendas.vendedor_id', '=', 'consultor_comercial.id')
                    ->where('consultor_comercial.ativo', 1);
            })
            ->select(
                'consultor_comercial.nome_consultor',
                'consultor_comercial.sobrenome_consultor',
                DB::raw('COUNT(*) as quantidade'),
                DB::raw('SUM(total) as valor_total')
            )
            ->where('vendas.situacao', '!=', 'cancelado'); // valor padrão

        if ($ano) {
            $query->whereYear('vendas.cadastro', $ano);
        }
        if ($mes) {
            $query->whereMonth('vendas.cadastro', $mes);
        }
        if ($unidade) {
            $query->where('vendas.unidade', $unidade);
        }
        if ($vendedor) {
            $query->where('vendas.vendedor_id', $vendedor);
        }
        if ($situacao) {
            $query->where('vendas.situacao', $situacao);
        }

        $result = $query->groupBy('vendas.vendedor_id', 'consultor_comercial.nome_consultor', 'consultor_comercial.sobrenome_consultor')
                        ->orderByDesc('valor_total')
                        ->get();

        return response()->json($result);
    }

    public function vendasPorPacote(Request $request)
    {
        $ano = $request->input('ano');
        $mes = $request->input('mes');
        $unidade = $request->input('unidade');
        $vendedor = $request->input('vendedor');
        $situacao = $request->input('situacao');

        $query = DB::table('vendas')
            ->select(
                'pacotes',
                DB::raw('COUNT(*) as quantidade'),
                DB::raw('SUM(total) as valor')
            )
            ->where('situacao', '!=', 'cancelado')
            ->whereNotNull('pacotes')
            ->where('pacotes', '!=', '');

        // Aplica filtros
        if ($ano) $query->whereYear('cadastro', $ano);
        if ($mes) $query->whereMonth('cadastro', $mes);
        if ($unidade) $query->where('unidade', $unidade);
        if ($vendedor) $query->where('vendedor_id', $vendedor);
        if ($situacao) $query->where('situacao', $situacao);

        $query->groupBy('pacotes')->orderByDesc('quantidade');

        $result = $query->get();

        $pacotes = [];
        $maisVendido = null;

        foreach ($result as $row) {
            $pacotes[$row->pacotes] = [
                'quantidade' => (int) $row->quantidade,
                'valor' => (float) $row->valor,
            ];
        }

        if ($result->isNotEmpty()) {
            $maisVendido = $result->first()->pacotes;
        }

        return response()->json([
            'pacotes' => $pacotes,
            'maisVendido' => $maisVendido,
        ]);
    }

 public function vendasPorMes(Request $request)
    {
        try {
            // Coleta todos os parâmetros de filtro da requisição
            $anoSelecionado = $request->query('ano', date('Y'));
            $mesSelecionado = $request->query('mes');
            $unidadeSelecionada = $request->query('unidade');
            $vendedorSelecionado = $request->query('vendedor');
            $situacaoSelecionada = $request->query('situacao');

            $labels = [];
            $valores = [];
            $quantidades = [];
            
            // Define os meses que serão exibidos no gráfico.
            $mesesParaExibir = !empty($mesSelecionado) ? [$mesSelecionado] : range(1, 12);

            foreach ($mesesParaExibir as $mes) {
                $inicioMes = Carbon::createFromDate($anoSelecionado, $mes, 1)->startOfMonth();
                $fimMes = Carbon::createFromDate($anoSelecionado, $mes, 1)->endOfMonth();

                $labels[] = $inicioMes->format('M Y');

                // Inicia a query com o filtro de data
                $query = DB::table('vendas')
                           ->whereBetween('cadastro', [$inicioMes, $fimMes]);

                // Aplica os filtros adicionais somente se eles tiverem um valor válido
                if (!empty($unidadeSelecionada)) {
                    $query->where('unidade', $unidadeSelecionada);
                }

                // Corrige o filtro de vendedor para usar 'vendedor_id'
                if (!empty($vendedorSelecionado)) {
                    $query->where('vendedor_id', $vendedorSelecionado);
                }

                if (!empty($situacaoSelecionada)) {
                    $query->where('situacao', $situacaoSelecionada);
                }

                // Exclui a situação 'cancelado' por padrão, a menos que seja explicitamente solicitada
                if (empty($situacaoSelecionada) || $situacaoSelecionada !== 'cancelado') {
                    $query->where('situacao', '!=', 'cancelado');
                }

                // Executa a query
                $vendasMes = $query->get();

                // Soma os totais e conta as quantidades
                $valores[] = (float) $vendasMes->sum('total');
                $quantidades[] = (int) $vendasMes->count();
            }

            return response()->json([
                'labels' => $labels,
                'valores' => $valores,
                'quantidades' => $quantidades
            ]);
        } catch (\Exception $e) {
            // Retorna um JSON de erro para que o JavaScript não quebre
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ]);
        }
    }
public function vendasPorAno(Request $request)
{
    $anoSelecionado = $request->query('ano'); // opcional
    $mesSelecionado = $request->query('mes'); // opcional
    $unidadeSelecionada = $request->query('unidade');
    $vendedorSelecionado = $request->query('vendedor');
    $situacaoSelecionada = $request->query('situacao');

    $anosQuery = DB::table('vendas')
        ->selectRaw('YEAR(cadastro) as ano')
        ->where('situacao', '!=', 'cancelado');

    if (!empty($anoSelecionado)) {
        $anosQuery->whereYear('cadastro', $anoSelecionado);
    }
    if (!empty($mesSelecionado)) {
        $anosQuery->whereMonth('cadastro', $mesSelecionado);
    }
    if (!empty($unidadeSelecionada)) {
        $anosQuery->where('unidade', $unidadeSelecionada);
    }
    if (!empty($vendedorSelecionado)) {
        $anosQuery->where('vendedor_id', $vendedorSelecionado);
    }
    if (!empty($situacaoSelecionada)) {
        $anosQuery->where('situacao', $situacaoSelecionada);
    }

    $anos = $anosQuery->groupBy('ano')->orderBy('ano')->pluck('ano');

    $labels = [];
    $valores = [];
    $quantidades = [];

    foreach ($anos as $ano) {
        $labels[] = $ano;

        $vendasAnoQuery = DB::table('vendas')
            ->whereYear('cadastro', $ano);

        if (!empty($mesSelecionado)) {
            $vendasAnoQuery->whereMonth('cadastro', $mesSelecionado);
        }
        if (!empty($unidadeSelecionada)) {
            $vendasAnoQuery->where('unidade', $unidadeSelecionada);
        }
        if (!empty($vendedorSelecionado)) {
            $vendasAnoQuery->where('vendedor_id', $vendedorSelecionado);
        }
        if (!empty($situacaoSelecionada)) {
            $vendasAnoQuery->where('situacao', $situacaoSelecionada);
        }
        if (empty($situacaoSelecionada) || $situacaoSelecionada !== 'cancelado') {
            $vendasAnoQuery->where('situacao', '!=', 'cancelado');
        }

        $vendasAno = $vendasAnoQuery->get();
        $valores[] = (float) $vendasAno->sum('total');
        $quantidades[] = (int) $vendasAno->count();
    }

    return response()->json([
        'labels' => $labels,
        'valores' => $valores,
        'quantidades' => $quantidades
    ]);
}

public function anosVendas()
{
    $anos = DB::table('vendas')
        ->selectRaw('YEAR(cadastro) as ano')
        ->where('situacao', '!=', 'cancelado')
        ->groupBy('ano')
        ->orderBy('ano', 'desc')
        ->pluck('ano');

    return response()->json($anos);
}

  public function vendasAnoComparativo(Request $request)
{
    $ano = $request->query('ano', date('Y'));
    $unidade = $request->query('unidade');
    $vendedor = $request->query('vendedor');
    $situacao = $request->query('situacao');

    $labels = [];
    $valores = [];
    $quantidades = [];

    for ($mes = 1; $mes <= 12; $mes++) {
        $inicioMes = \Carbon\Carbon::create($ano, $mes, 1)->startOfMonth();
        $fimMes = \Carbon\Carbon::create($ano, $mes, 1)->endOfMonth();

        $labels[] = $inicioMes->format('M');

        $query = DB::table('vendas')
            ->whereBetween('cadastro', [$inicioMes, $fimMes]);

        // aplica filtros
        if ($unidade) {
            $query->where('unidade', $unidade);
        }
        if ($vendedor) {
            $query->where('vendedor_id', $vendedor);
        }
        if ($situacao) {
            $query->where('situacao', $situacao);
        } else {
            // por padrão ignora cancelado
            $query->where('situacao', '!=', 'cancelado');
        }

        $valores[] = (float) $query->sum('total');
        $quantidades[] = (int) $query->count();
    }

    return response()->json([
        'labels' => $labels,
        'valores' => $valores,
        'quantidades' => $quantidades,
    ]);
}

}