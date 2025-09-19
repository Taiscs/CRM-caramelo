<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LeadsController extends Controller
{
  public function listarTodos(Request $request)
    {
        $perPage = $request->input('per_page', 20);
        $tipo = $request->input('tipo', 'all');
        $status = $request->input('status', 'all');
        $fonte = $request->input('fonte', 'all');
        $analista = $request->input('analista', $request->input('vendedor', 'all'));
        $search = $request->input('search', null);

        // Clientes
        $clientes = DB::table('clientes')
            ->leftJoin('fonte_capitacao', 'clientes.Marketing', '=', 'fonte_capitacao.id_fonte')
            ->leftJoin('consultor_comercial', 'clientes.Vendedor', '=', 'consultor_comercial.id')
            ->select(
                'clientes.Id as id',
                'clientes.Nome as nome',
                'clientes.Telefone as numero',
                'clientes.Email as email',
                DB::raw("'cliente' as origem"),
                'fonte_capitacao.nome as fonte',
                'clientes.Data_cadastro as data_cadastro',
                'clientes.status as status',
                DB::raw("CONCAT(consultor_comercial.nome_consultor,' ',consultor_comercial.sobrenome_consultor) as analista")
            );

        // Filtros clientes
        if ($tipo === 'active') $clientes->where('clientes.status', '1');
        if ($tipo === 'lead') $clientes->where('clientes.status', '0');
        if ($status === 'ativo') $clientes->where('clientes.status', '1');
        if ($status === 'inativo') $clientes->where('clientes.status', '0');
        if ($fonte !== 'all') $clientes->where('clientes.Marketing', $fonte);
        if ($analista !== 'all') $clientes->where('clientes.Vendedor', $analista);

        if ($search) {
            $clientes->where(function ($q) use ($search) {
                $q->where('clientes.Nome', 'like', "%{$search}%")
                  ->orWhere('clientes.Email', 'like', "%{$search}%")
                  ->orWhere('clientes.Telefone', 'like', "%{$search}%");
            });
        }

        // Contatos
        $contatos = DB::table('contatos')
            ->whereNotIn('numero', function ($query) {
                $query->select('Telefone')->from('clientes');
            })
            ->whereNotIn('email', function ($query) {
                $query->select('Email')->from('clientes');
            })
            ->select(
                'id as id',
                'nome',
                'numero',
                'email',
                DB::raw("'contato' as origem"),
                DB::raw("'Contato' as fonte"),
                'created_at as data_cadastro',
                DB::raw("NULL as status"),
                DB::raw("NULL as analista")
            );

        if ($search) {
            $contatos->where(function ($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('numero', 'like', "%{$search}%");
            });
        }

        // União clientes + contatos
        if ($tipo === 'lead') {
            $queryUnion = $contatos;
        } else {
            $queryUnion = DB::query()->fromSub(
                $clientes->unionAll($contatos),
                'leads_union'
            );
        }

        // Paginação + ordenação
        $dados = $queryUnion->orderByDesc('data_cadastro')->paginate($perPage);

        // Formatar data
        $dados->getCollection()->transform(function ($item) {
            try {
                $item->data_cadastro = Carbon::parse($item->data_cadastro)->format('d/m/Y');
            } catch (\Exception $e) {
                // Caso o campo de data seja nulo ou inválido, apenas retorna o valor original.
                $item->data_cadastro = $item->data_cadastro;
            }
            return $item;
        });

        return response()->json($dados);
    }

    public function detalhes($id)
    {
        // Tenta encontrar na tabela 'clientes' primeiro
        $cliente = DB::table('clientes')
            ->leftJoin('fonte_capitacao', 'clientes.Marketing', '=', 'fonte_capitacao.id_fonte')
            ->leftJoin('consultor_comercial', 'clientes.Vendedor', '=', 'consultor_comercial.id')
            ->select(
                'clientes.Id as id',
                'clientes.Nome as nome',
                'clientes.Telefone as numero',
                'clientes.Email as email',
                'clientes.status as status',
                'clientes.receptividade as receptividade',
                'clientes.notas as notas',
                'clientes.Data_cadastro as data_cadastro',
                'clientes.data_atualizacao as data_atualizacao',
                'fonte_capitacao.nome as fonte',
                DB::raw("CONCAT(consultor_comercial.nome_consultor, ' ', consultor_comercial.sobrenome_consultor) as analista")
            )
            ->where('clientes.Id', $id)
            ->first();

        // Se não for encontrado em 'clientes', tenta na tabela 'contatos'
        if (!$cliente) {
            $cliente = DB::table('contatos')
                ->select(
                    'id as id',
                    'nome',
                    'numero',
                    'email',
                    'created_at as data_cadastro',
                    'updated_at as data_atualizacao',
                    DB::raw("NULL as status"),
                    DB::raw("NULL as notas"),
                    DB::raw("NULL as receptividade"),
                    DB::raw("'Contato' as fonte"),
                    DB::raw("NULL as analista")
                )
                ->where('id', $id)
                ->first();

            if (!$cliente) {
                return response()->json(['message' => 'Cliente/Lead não encontrado.'], 404);
            }
        }

        // Agora, buscar interações e oportunidades
        $interacoes = DB::table('historico_interacoes')
            ->where('cliente_id', $cliente->id)
            ->select('data_interacao as data', 'descricao_interacao as descricao')
            ->orderByDesc('data_interacao')
            ->get();

        $oportunidades = DB::table('oportunidades')
            ->where('cliente_id', $cliente->id)
            ->select('descricao_oportunidade as descricao')
            ->get();

        // Formatar as datas com try-catch
        try {
            if ($cliente->data_cadastro) {
                $cliente->data_cadastro = Carbon::parse($cliente->data_cadastro)->format('d/m/Y');
            }
        } catch (\Exception $e) {
            $cliente->data_cadastro = '-';
        }

        try {
            if ($cliente->data_atualizacao) {
                $cliente->data_atualizacao = Carbon::parse($cliente->data_atualizacao)->format('d/m/Y');
            }
        } catch (\Exception $e) {
            $cliente->data_atualizacao = '-';
        }

        $interacoes->transform(function ($item) {
            try {
                if ($item->data) {
                    $item->data = Carbon::parse($item->data)->format('d/m/Y H:i');
                }
            } catch (\Exception $e) {
                $item->data = '-';
            }
            return $item;
        });

        // Retornar os dados formatados
        return response()->json([
            'nome' => $cliente->nome ?? '-',
            'email' => $cliente->email ?? '-',
            'numero' => $cliente->numero ?? '-',
            'status' => $cliente->status,
            'fonte' => $cliente->fonte ?? '-',
            'analista' => $cliente->analista ?? '-',
            'receptividade' => $cliente->receptividade ?? '-',
            'data_cadastro' => $cliente->data_cadastro ?? '-',
            'data_atualizacao' => $cliente->data_atualizacao ?? '-',
            'notas' => $cliente->notas ?? '-',
            'interacoes' => $interacoes,
            'oportunidades' => $oportunidades,
        ]);
    }
}