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
        $aguardando_resposta = collect();

        try {
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
                $total_conversas = (int) ($data['count'] ?? 0);

                if (!empty($data['tickets'])) {
                    $tickets = collect($data['tickets']);

                    // Tickets aguardando resposta (lista + última/penúltima msg)
                    $aguardando_resposta = $tickets->filter(function($ticket) {
                            $answered = is_bool($ticket['answered']) 
                                ? $ticket['answered'] 
                                : filter_var($ticket['answered'], FILTER_VALIDATE_BOOLEAN);

                            return $ticket['status'] === 'open' && !$answered;
                        })
                        ->map(function($ticket) {
                            // Última mensagem
                            $lastMessage = $ticket['lastMessage'] ?? null;

                            // Penúltima mensagem (se houver histórico)
                            $messages = $ticket['messages'] ?? [];
                            $penultima = null;
                            if (is_array($messages) && count($messages) > 1) {
                                $penultima = $messages[count($messages) - 2]['body'] ?? null;
                            }

                            return [
                                'id' => $ticket['id'],
                                'contact' => $ticket['contact'],
                                'createdAt' => $ticket['createdAt'],
                                'updatedAt' => $ticket['updatedAt'] ?? null,
                                'lastMessage' => $lastMessage,
                                'penultimaMessage' => $penultima,
                            ];
                        })
                        ->values();

                    $total_aguardando_resposta = $aguardando_resposta->count();

                    // Total de mensagens não lidas
                    $total_unread_messages = $tickets->sum('unreadMessages');

                    // Contagem por leadstatus
                    foreach ($tickets as $ticket) {
                        $statusName = $ticket['leadstatus']['queue'] ?? 'Sem Status';
                        if (!isset($leadStatusCounts[$statusName])) {
                            $leadStatusCounts[$statusName] = 0;
                        }
                        $leadStatusCounts[$statusName]++;
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
            'aguardando_resposta'
        ));
    }
}
