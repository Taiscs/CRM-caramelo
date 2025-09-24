<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OportunidadeController extends Controller
{
    // Página principal do Kanban
    public function index()
    {
        // "Potencial de Ganho" (reengajamento 3 meses)
        $oportunidadesPotencialGanho = DB::select("
            SELECT
                v.id,
                v.cliente_id,
                v.evento,
                v.total,
                c.Nome as cliente_nome,
                c.Email,
                c.Telefone,
                v.data_evento AS data_ultima_festa,
                CONCAT(cc.nome_consultor, ' ', cc.sobrenome_consultor) AS vendedor_nome,
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
                END) - YEAR(v.data_evento)) + CAST(REGEXP_SUBSTR(v.evento, '[0-9]{1,2}') AS UNSIGNED) AS idade_proximo_aniversario,
                'venda' AS origem
            FROM vendas v
            JOIN clientes c ON v.cliente_id = c.Id
            JOIN consultor_comercial cc ON v.vendedor_id = cc.id
            WHERE REGEXP_SUBSTR(v.evento, '[0-9]{1,2}') IS NOT NULL
              AND CAST(REGEXP_SUBSTR(v.evento, '[0-9]{1,2}') AS UNSIGNED) > 0
              AND CONCAT(YEAR(CURDATE()), '-', MONTH(v.data_evento), '-', DAY(v.data_evento)) >= CURDATE()
              AND CONCAT(YEAR(CURDATE()), '-', MONTH(v.data_evento), '-', DAY(v.data_evento)) <= DATE_ADD(CURDATE(), INTERVAL 3 MONTH)
            ORDER BY proximo_aniversario ASC
        ");

        // "Mundo Balada"
        $oportunidadesBalada = DB::select("
            SELECT
                v.id,
                v.cliente_id,
                v.evento,
                v.total,
                c.Nome as cliente_nome,
                c.Email,
                c.Telefone,
                v.data_evento AS data_ultima_festa,
                CONCAT(cc.nome_consultor, ' ', cc.sobrenome_consultor) AS vendedor_nome,
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
                END) - YEAR(v.data_evento)) + CAST(REGEXP_SUBSTR(v.evento, '[0-9]{1,2}') AS UNSIGNED) AS idade_proximo_aniversario,
                'venda' AS origem
            FROM vendas v
            JOIN clientes c ON v.cliente_id = c.Id
            JOIN consultor_comercial cc ON v.vendedor_id = cc.id
            WHERE REGEXP_SUBSTR(v.evento, '[0-9]{1,2}') IS NOT NULL
              AND CAST(REGEXP_SUBSTR(v.evento, '[0-9]{1,2}') AS UNSIGNED) > 0
              AND YEAR(v.data_evento) <= YEAR(CURDATE())
              AND MONTH(v.data_evento) <= MONTH(CURDATE())
            HAVING idade_proximo_aniversario >= 12
            ORDER BY v.data_evento ASC
        ");

        // "Oportunidades Personalizadas"
        $oportunidadesPersonalizadas = DB::select("
            SELECT
                o.id,
                o.cliente_id,
                o.vendedor_id,
                o.descricao_oportunidade,
                o.data_oportunidade,
                c.Nome AS cliente_nome,
                v.evento AS ultimo_evento,
                COALESCE(CONCAT(cc1.nome_consultor, ' ', cc1.sobrenome_consultor),
                         CONCAT(cc2.nome_consultor, ' ', cc2.sobrenome_consultor)) AS vendedor_nome,
                'oportunidade' AS origem
            FROM oportunidades o
            JOIN clientes c ON o.cliente_id = c.Id
            LEFT JOIN (
                SELECT cliente_id, MAX(id) AS ultimo_id
                FROM vendas
                GROUP BY cliente_id
            ) AS ultimas_vendas ON o.cliente_id = ultimas_vendas.cliente_id
            LEFT JOIN vendas v ON ultimas_vendas.ultimo_id = v.id
            LEFT JOIN consultor_comercial cc1 ON v.vendedor_id = cc1.id
            LEFT JOIN consultor_comercial cc2 ON o.vendedor_id = cc2.id
            ORDER BY o.data_oportunidade DESC
        ");

        $kanban = [
            'Oportunidades personalizadas' => $oportunidadesPersonalizadas,
            'Oportunidades mundo balada' => $oportunidadesBalada,
            'Potencial de Ganho' => $oportunidadesPotencialGanho,
        ];

        return view('oportunidades', compact('kanban'));
    }

    // Buscar dados de cliente específico
    public function getClienteData($id)
    {
        $cliente = DB::table('clientes')
            ->select('Nome', 'Telefone', 'Email')
            ->where('id', $id)
            ->first();

        return $cliente 
            ? response()->json($cliente) 
            : response()->json(['error' => 'Cliente não encontrado'], 404);
    }

    // Lista de vendedores para filtro
    public function getVendedores()
    {
        $vendedores = DB::table('consultor_comercial')
            ->select('id as vendedor_id', DB::raw("CONCAT(nome_consultor, ' ', sobrenome_consultor) as vendedor"))
            ->orderBy('nome_consultor')
            ->get();

        return response()->json($vendedores);
    }

    // Oportunidades filtradas pelo analista e/ou search
    public function oportunidadesFiltradas(Request $request)
    {
        // Vendas
        $vendas = DB::table('vendas as v')
            ->join('clientes as c', 'v.cliente_id', '=', 'c.id')
            ->leftJoin('consultor_comercial as cc', 'v.vendedor_id', '=', 'cc.id')
            ->select(
                'v.id', 'v.cliente_id', 'v.evento', 'v.total',
                'c.Nome as cliente_nome',
                DB::raw("CONCAT(cc.nome_consultor, ' ', cc.sobrenome_consultor) as vendedor_nome"),
                'v.data_evento',
                DB::raw("'venda' as origem")
            );

        // Oportunidades personalizadas
        $oportunidades = DB::table('oportunidades as o')
            ->join('clientes as c', 'o.cliente_id', '=', 'c.id')
            ->leftJoin('consultor_comercial as cc', 'o.vendedor_id', '=', 'cc.id')
            ->select(
                'o.id', 'o.cliente_id', DB::raw('o.descricao_oportunidade as evento'),
                DB::raw('NULL as total'),
                'c.Nome as cliente_nome',
                DB::raw("CONCAT(cc.nome_consultor, ' ', cc.sobrenome_consultor) as vendedor_nome"),
                'o.data_oportunidade as data_evento',
                DB::raw("'oportunidade' as origem")
            );

        // Aplica filtros
        if ($request->filled('analyst')) {
            if ($request->analyst != 0) {
                $vendas->where('v.vendedor_id', $request->analyst);
                $oportunidades->where('o.vendedor_id', $request->analyst);
            }
        }

        if ($request->filled('search')) {
            $vendas->where('c.Nome', 'like', '%' . $request->search . '%');
            $oportunidades->where('c.Nome', 'like', '%' . $request->search . '%');
        }

        $resultado = $vendas->get()->merge($oportunidades->get());

        return response()->json($resultado);
    }
}
