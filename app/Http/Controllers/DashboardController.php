<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Contato;
use App\Models\Venda;
use Carbon\Carbon;
use App\Services\JetsalesService;

class DashboardController extends Controller
{
    public function index(JetsalesService $jetsales)
    {
        // Total de clientes
        $total_clientes = Cliente::count();

        // Novos leads nos últimos 30 dias
        $novos_leads = Contato::where('created_at', '>=', Carbon::now()->subDays(30))->count();

        // Taxa de conversão
        $taxa_conversao = $novos_leads > 0 
            ? ($total_clientes / $novos_leads) * 100 
            : 0;
        $taxa_conversao_formatada = number_format($taxa_conversao, 2, ',', '.') . '%';

        // Vendas fechadas do mês atual (excluindo canceladas)
        $vendas_fechadas_valor = Venda::whereMonth('cadastro', Carbon::now()->month)
                                      ->whereYear('cadastro', Carbon::now()->year)
                                      ->where('situacao', '<>', 'Cancelado')
                                      ->sum('total');
        $vendas_fechadas = 'R$ ' . number_format($vendas_fechadas_valor, 2, ',', '.');

        // Inicializa variáveis dos cards da API
        $total_conversas = 0;
        $total_aguardando_resposta = 0;
        $total_unread_messages = 0;

        // Requisição para API Jetsales via Service
                $data = $jetsales->get('tickets', [
                'searchParam' => '',
                'showAll' => false,
                'withUnreadMessages' => false,
                'isNotAssignedUser' => false,
                'includeNotQueueDefined' => true,
                'isChatBot' => false,
                'pageNumber' => 1,
                'status' => 'open'
            ]);


        if (!empty($data)) {
            $total_conversas = $data['count'] ?? 0;

            if (!empty($data['tickets'])) {
                $tickets = collect($data['tickets']);

                $total_aguardando_resposta = $tickets
                    ->where('status', 'open')
                    ->where('answered', false)
                    ->count();

                $total_unread_messages = $tickets->sum('unreadMessages');
            }
        }

        return view('dashboard', compact(
            'total_clientes',
            'novos_leads',
            'taxa_conversao_formatada',
            'vendas_fechadas',
            'total_conversas',
            'total_aguardando_resposta',
            'total_unread_messages'
        ));
    }
}
