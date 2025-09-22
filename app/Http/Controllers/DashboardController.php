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
        // ---------------------------
        // Dados internos do sistema
        // ---------------------------

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

        // ---------------------------
        // Dados da API Jetsales
        // ---------------------------

        $total_conversas = 0;
        $total_aguardando_resposta = 0;
        $total_unread_messages = 0;
        $leadStatusCounts = []; // para gráfico de funil

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

        if (!empty($data) && !empty($data['tickets'])) {
            $tickets = collect($data['tickets']);

            $total_conversas = (int) ($data['count'] ?? 0);

            // Tickets aguardando resposta
            $total_aguardando_resposta = $tickets
                ->filter(function($ticket) {
                    $answered = is_bool($ticket['answered']) 
                        ? $ticket['answered'] 
                        : filter_var($ticket['answered'], FILTER_VALIDATE_BOOLEAN);
                    return $ticket['status'] === 'open' && !$answered;
                })
                ->count();

            // Total de mensagens não lidas
            $total_unread_messages = $tickets->sum('unreadMessages');

            // Contagem apenas de tickets com leadstatus definido
            $leadStatusCounts = $tickets
                ->filter(fn($ticket) => !empty($ticket['leadstatus']['queue']))
                ->groupBy(fn($ticket) => $ticket['leadstatus']['queue'])
                ->map(fn($group) => count($group))
                ->toArray();
        }

        // ---------------------------
        // Envio de dados para a view
        // ---------------------------
        return view('dashboard', compact(
            'total_clientes',
            'novos_leads',
            'taxa_conversao_formatada',
            'vendas_fechadas',
            'total_conversas',
            'total_aguardando_resposta',
            'total_unread_messages',
            'leadStatusCounts' // gráfico de funil
        ));
    }
}
