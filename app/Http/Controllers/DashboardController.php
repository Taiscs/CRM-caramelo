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

        $total_clientes = Cliente::count();

        $novos_leads = Contato::where('created_at', '>=', Carbon::now()->subDays(30))->count();

        $taxa_conversao = $novos_leads > 0 
            ? ($total_clientes / $novos_leads) * 100 
            : 0;
        $taxa_conversao_formatada = number_format($taxa_conversao, 2, ',', '.') . '%';

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
        $leadStatusCounts = [];
        $aguardandoTickets = collect();

        try {
            $data = $jetsales->get('tickets', [
                'searchParam' => '',
                'showAll' => false,
                'withUnreadMessages' => false,
                'isNotAssignedUser' => false,
                'includeNotQueueDefined' => true,
                'isChatBot' => false,
                'pageNumber' => 1,
                'status' => 'open' // pega TODOS os tickets abertos
            ]);

            if (!empty($data)) {
                $total_conversas = (int) ($data['count'] ?? 0);

                if (!empty($data['tickets'])) {
                    $tickets = collect($data['tickets']);

                    // Filtra apenas tickets aguardando resposta
                    $aguardandoTickets = $tickets->filter(function ($ticket) {
                        $answered = is_bool($ticket['answered'])
                            ? $ticket['answered']
                            : filter_var($ticket['answered'], FILTER_VALIDATE_BOOLEAN);

                        return $ticket['status'] === 'open' && !$answered;
                    })->values();

                    $total_aguardando_resposta = $aguardandoTickets->count();

                    // Total de mensagens não lidas
                    $total_unread_messages = $tickets->sum('unreadMessages');

                    // Contagem por status + última mensagem do lead
                    foreach ($aguardandoTickets as &$ticket) {
                        $statusName = $ticket['leadstatus']['queue'] ?? 'Sem Status';
                        $leadStatusCounts[$statusName] = ($leadStatusCounts[$statusName] ?? 0) + 1;

                        // Pega diretamente a última mensagem do lead
                        $ticket['lastMessageFromLead'] = $ticket['lastMessage'] ?? 'Sem mensagem';
                    }
                }
            }
        } catch (\Exception $e) {
            \Log::error("Erro Jetsales API: " . $e->getMessage());
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
            'leadStatusCounts',
            'aguardandoTickets'
        ));
    }
}
