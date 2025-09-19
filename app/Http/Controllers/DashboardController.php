<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente; // Model da tabela clientes
use App\Models\Contato; // Model da tabela contatos
use App\Models\Venda; // Model da tabela vendas
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Total de clientes
        $total_clientes = Cliente::count();

        // Total de contatos (pode ser todos ou só últimos 30 dias)
        $total_contatos = Contato::count();

        // Contatos criados nos últimos 30 dias
        $novos_leads = Contato::where('created_at', '>=', Carbon::now()->subDays(30))->count();

        // Calculando a taxa de conversão
        $taxa_conversao = $total_contatos > 0 
            ? ($total_clientes / $total_contatos) * 100 
            : 0;
        $taxa_conversao_formatada = number_format($taxa_conversao, 2, ',', '.') . '%';

        // Total de vendas do mês atual, excluindo canceladas
        $vendas_fechadas_valor = Venda::whereMonth('cadastro', Carbon::now()->month)
                                      ->whereYear('cadastro', Carbon::now()->year)
                                      ->where('situacao', '<>', 'Cancelado') // exclui vendas canceladas
                                      ->sum('total'); // soma a coluna total

        // Formata como R$
        $vendas_fechadas = 'R$ ' . number_format($vendas_fechadas_valor, 2, ',', '.');

        $chat = [];

        return view('dashboard', compact(
            'total_clientes',
            'novos_leads',
            'taxa_conversao_formatada',
            'vendas_fechadas',
            'chat'
        ));
    }
}
