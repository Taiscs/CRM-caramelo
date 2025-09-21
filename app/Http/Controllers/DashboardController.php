<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Contato;
use App\Models\Venda;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
   public function index()
{
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

    $response = Http::withToken(env('JETSALES_API_TOKEN'))
        ->get(env('JETSALES_API_URL') . 'tickets', [
            'searchParam' => '',
            'showAll' => 'false',
            'withUnreadMessages' => 'false',
            'isNotAssignedUser' => 'false',
            'includeNotQueueDefined' => 'true',
            'isChatBot' => 'false',
            'pageNumber' => 1,
            'status' => 'open'
        ]);

    $total_conversas = 0;
    $total_aguardando_resposta = 0;

    if ($response->successful()) {
        $data = $response->json();
        $total_conversas = $data['count'] ?? 0;

        if (!empty($data['tickets'])) {
            $total_aguardando_resposta = collect($data['tickets'])
                ->where('status', 'open')
                ->where('answered', false)
                ->count();
        }
    }

    return view('dashboard', compact(
        'total_clientes',
        'novos_leads',
        'taxa_conversao_formatada',
        'vendas_fechadas',
        'total_conversas',
        'total_aguardando_resposta'
    ));
}
}