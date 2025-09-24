<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OportunidadeController extends Controller
{

    
    // Página principal do Kanban
    public function index()
    {
        // "Potencial de Ganho" (Reengajamento em 3 meses)
        $sqlPotencialGanho = "
            SELECT
              v.id,
              v.cliente_id,
              v.evento,
              v.total,
              v.situacao,
              c.Nome as cliente_nome,
              c.Email,
              c.Telefone,
              v.data_evento AS data_ultima_festa,
              cc.nome_consultor AS vendedor_nome,
              cc.foto AS foto_vendedor,
              (YEAR(CURDATE()) - YEAR(v.data_evento)) + CAST(REGEXP_SUBSTR(v.evento, '[0-9]{1,2}') AS UNSIGNED) AS idade_neste_ano,
              CASE
                WHEN CONCAT(YEAR(CURDATE()), '-', MONTH(v.data_evento), '-', DAY(v.data_evento)) >= CURDATE()
                THEN CONCAT(YEAR(CURDATE()), '-', MONTH(v.data_evento), '-', DAY(v.data_evento))
                ELSE CONCAT(YEAR(CURDATE()) + 1, '-', MONTH(v.data_evento), '-', DAY(v.data_evento))
              END AS proximo_aniversario,
              (YEAR(CASE
                WHEN CONCAT(YEAR(CURDATE()), '-', MONTH(v.data_evento), '-', DAY(v.data_evento)) >= CURDATE()
                THEN CURDATE()
                ELSE CURDATE() + INTERVAL 1 YEAR
              END) - YEAR(v.data_evento)) + CAST(REGEXP_SUBSTR(v.evento, '[0-9]{1,2}') AS UNSIGNED) AS idade_proximo_aniversario
            FROM
              vendas v
            JOIN
              clientes c ON v.cliente_id = c.Id
            JOIN
              consultor_comercial cc ON v.vendedor_id = cc.id
            WHERE
              REGEXP_SUBSTR(v.evento, '[0-9]{1,2}') IS NOT NULL AND
              CAST(REGEXP_SUBSTR(v.evento, '[0-9]{1,2}') AS UNSIGNED) > 0 AND
              CONCAT(YEAR(CURDATE()), '-', MONTH(v.data_evento), '-', DAY(v.data_evento)) >= CURDATE() AND
              CONCAT(YEAR(CURDATE()), '-', MONTH(v.data_evento), '-', DAY(v.data_evento)) <= DATE_ADD(CURDATE(), INTERVAL 3 MONTH)
            ORDER BY
              proximo_aniversario ASC;";

        $oportunidadesPotencialGanho = DB::select($sqlPotencialGanho);

        // "Mundo Balada"
        $sqlOportunidadesBalada = "
            SELECT
              v.id,
              v.cliente_id, 
              v.evento,
              v.total,
              v.situacao,
              c.Nome as cliente_nome,
              c.Email,
              c.Telefone,
              v.data_evento AS data_ultima_festa,
              cc.nome_consultor AS vendedor_nome,
              cc.foto AS foto_vendedor,
              (YEAR(CURDATE()) - YEAR(v.data_evento)) + CAST(REGEXP_SUBSTR(v.evento, '[0-9]{1,2}') AS UNSIGNED) AS idade_neste_ano,
              CASE
                WHEN CONCAT(YEAR(CURDATE()), '-', MONTH(v.data_evento), '-', DAY(v.data_evento)) >= CURDATE()
                THEN CONCAT(YEAR(CURDATE()), '-', MONTH(v.data_evento), '-', DAY(v.data_evento))
                ELSE CONCAT(YEAR(CURDATE()) + 1, '-', MONTH(v.data_evento), '-', DAY(v.data_evento))
              END AS proximo_aniversario,
              (YEAR(CASE
                WHEN CONCAT(YEAR(CURDATE()), '-', MONTH(v.data_evento), '-', DAY(v.data_evento)) >= CURDATE()
                THEN CURDATE()
                ELSE CURDATE() + INTERVAL 1 YEAR
              END) - YEAR(v.data_evento)) + CAST(REGEXP_SUBSTR(v.evento, '[0-9]{1,2}') AS UNSIGNED) AS idade_proximo_aniversario
            FROM
              vendas v
            JOIN
              clientes c ON v.cliente_id = c.Id
            JOIN
              consultor_comercial cc ON v.vendedor_id = cc.id
            WHERE
              REGEXP_SUBSTR(v.evento, '[0-9]{1,2}') IS NOT NULL AND
              CAST(REGEXP_SUBSTR(v.evento, '[0-9]{1,2}') AS UNSIGNED) > 0 AND
              YEAR(v.data_evento) <= YEAR(CURDATE()) AND
              MONTH(v.data_evento) <= MONTH(CURDATE())
            HAVING
              idade_proximo_aniversario >= 12
            ORDER BY
              v.data_evento ASC;";

        $oportunidadesBalada = DB::select($sqlOportunidadesBalada);

        // "Oportunidades Personalizadas"
        $sqlOportunidadesPersonalizadas = "
            SELECT
                o.id,
                o.cliente_id,
                o.descricao_oportunidade,
                o.data_oportunidade,
                c.Nome AS cliente_nome,
                v.evento AS ultimo_evento,
                cc.nome_consultor AS vendedor_nome,
                cc.foto AS foto_vendedor
            FROM
                oportunidades o
            JOIN clientes c ON o.cliente_id = c.Id
            LEFT JOIN (
                SELECT
                    cliente_id,
                    MAX(id) AS ultimo_id
                FROM
                    vendas
                GROUP BY
                    cliente_id
            ) AS ultimas_vendas ON o.cliente_id = ultimas_vendas.cliente_id
            LEFT JOIN vendas v ON ultimas_vendas.ultimo_id = v.id
            LEFT JOIN consultor_comercial cc ON v.vendedor_id = cc.id
            ORDER BY
                o.data_oportunidade DESC;";

        $oportunidadesPersonalizadas = DB::select($sqlOportunidadesPersonalizadas);

        // Inicializa o Kanban
        $kanban = [
            'Oportunidades personalizadas' => $oportunidadesPersonalizadas,
            'Oportunidades mundo balada' => $oportunidadesBalada,
            'Potencial de Ganho' => [],
            'Proposta Enviada' => [],
            'Negociacao' => [],
            'Fechado - Ganho' => [],
            'Fechado - Perdido' => [],
        ];

        // Popula o Kanban com os resultados de Potencial de Ganho
        foreach ($oportunidadesPotencialGanho as $oportunidade) {
            $status = $oportunidade->situacao ?? 'Potencial de Ganho';
            if (array_key_exists($status, $kanban)) {
                $kanban[$status][] = $oportunidade;
            } else {
                $kanban['Potencial de Ganho'][] = $oportunidade;
            }
        }

        return view('oportunidades', compact('kanban'));
    }

    // Buscar dados de cliente específico
    public function getClienteData($id)
    {
        try {
            $cliente = DB::table('clientes')
                ->select('Nome', 'Telefone', 'Email')
                ->where('id', $id)
                ->first();

            if ($cliente) {
                return response()->json($cliente);
            } else {
                return response()->json(['error' => 'Cliente não encontrado'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao buscar dados do cliente: ' . $e->getMessage()], 500);
        }
    }

    // ====== FILTROS ======
public function getVendedores()
{
    $vendedores = DB::table('consultor_comercial')
        ->select(
            'id as vendedor_id',
            DB::raw("CONCAT(nome_consultor, ' ', sobrenome_consultor) as vendedor")
        )
        ->orderBy('nome_consultor')
        ->get();

    return response()->json($vendedores);
}


    public function getMeses()
    {
        $meses = DB::table('vendas')
            ->select(DB::raw('DISTINCT MONTH(data_evento) as mes'))
            ->orderBy('mes')
            ->get();

        return response()->json($meses);
    }

    public function getAnos()
    {
        $anos = DB::table('vendas')
            ->select(DB::raw('DISTINCT YEAR(data_evento) as ano'))
            ->orderBy('ano', 'desc')
            ->get();

        return response()->json($anos);
    }

    public function getUnidades()
    {
        $unidades = DB::table('unidade')
            ->select('id as ID', 'nome as NOME')
            ->orderBy('nome')
            ->get();

        return response()->json($unidades);
    }

    // ====== OPORTUNIDADES FILTRADAS ======
public function oportunidadesFiltradas(Request $request)
{
    $query = DB::table('vendas as v')
        ->join('clientes as c', 'v.cliente_id', '=', 'c.id')
        ->join('consultor_comercial as cc', 'v.vendedor_id', '=', 'cc.id')
        ->select(
            'v.id',
            'v.cliente_id',
            'v.evento',
            'v.total',
            'v.situacao',
            'c.Nome as cliente_nome',
            'c.Email',
            'c.Telefone',
            'cc.nome_consultor as vendedor_nome',
            'cc.foto as foto_vendedor',
            'v.data_evento'
        );

    if ($request->filled('analyst')) {
        $query->where('v.vendedor_id', (int)$request->analyst);
    }

    if ($request->filled('month')) {
        $query->whereMonth('v.data_evento', (int)$request->month);
    }

    if ($request->filled('year')) {
        $query->whereYear('v.data_evento', (int)$request->year);
    }

    if ($request->filled('unit')) {
        $query->where('v.unidade', (int)$request->unit); // Corrigido de unidade_id para unidade
    }

    if ($request->filled('search')) {
        $query->where(function($q) use ($request) {
            $q->where('c.Nome', 'like', '%' . $request->search . '%')
              ->orWhere('v.evento', 'like', '%' . $request->search . '%');
        });
    }

    // >>> Depuração: mostra a query e os filtros recebidos
    $sql = $query->toSql();
    dd($sql, $request->all());

    $oportunidades = $query->get();

    return response()->json($oportunidades);
}

}
