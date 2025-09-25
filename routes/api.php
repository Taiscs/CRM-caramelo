<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RelatorioController;
use App\Http\Controllers\VendedorController;
use App\Http\Controllers\FonteController;
use App\Http\Controllers\ClientemaiorController;
use App\Http\Controllers\ContatoController;
use App\Http\Controllers\GraficosController;
use App\Http\Controllers\LeadsController;
use App\Http\Controllers\FonteCapitacaoController;
use App\Http\Controllers\ConsultorController;
use App\Http\Controllers\AnalistaController;
use App\Http\Controllers\HistoricoComprasController;
use App\Http\Controllers\KpiVendasController;
use App\Http\Controllers\UnidadeController;
use App\Http\Controllers\OportunidadeController;
use App\Http\Controllers\ClienteOportunidadeController;
use App\Http\Controllers\WebhookController;



// Rotas de KPIs e relatórios
Route::get('/relatorios/kpis', [RelatorioController::class, 'kpis']);
Route::get('/relatorios/kpis/vendedor', [VendedorController::class, 'kpiVendedor']);
Route::get('/relatorios/kpis/fonte', [FonteController::class, 'kpiFonte']);
Route::get('/relatorios/kpis/cliente', [ClientemaiorController::class, 'kpiCliente']);
Route::get('/relatorios/historico-vendas/{cliente}', [HistoricoComprasController::class, 'historicoVendas']);

// Webhook da Jetsales
Route::post('/webhook', [ContatoController::class, 'receberWebhook']);

// Sincronização manual de contato
Route::post('/sincronizar-contato', [ContatoController::class, 'sincronizarContato']);

// Rotas de dados
Route::get('/leads-por-fonte', [GraficosController::class, 'leadsPorFonte']);
Route::get('/leads-todos', [LeadsController::class, 'listarTodos']);
Route::get('/fontes', [FonteCapitacaoController::class, 'listarFontes']);
Route::get('/consultores', [ConsultorController::class, 'listarConsultores']);
Route::get('/analistas', [AnalistaController::class, 'index']);
Route::get('/lead-detalhes/{id}', [LeadsController::class, 'detalhes']);
Route::get('/graficos/clientes-novos-vs-recorrentes', [GraficosController::class, 'clientesNovosVsRecorrentes']);
Route::get('/kpi-vendas', [KpiVendasController::class, 'index']);
Route::get('/vendas-por-pacote', [GraficosController::class, 'vendasPorPacote']);
Route::get('/vendas-por-unidade', [UnidadeController::class, 'vendasPorUnidade']);
Route::get('/vendas-totais-por-vendedor', [GraficosController::class, 'vendasTotaisPorVendedor']);
Route::get('/vendas-mes', [GraficosController::class, 'vendasPorMes']);
Route::get('/vendas-ano', [GraficosController::class, 'vendasPorAno']);
Route::get('/vendas-ano-comparativo', [GraficosController::class, 'vendasAnoComparativo']);
Route::get('/anos-vendas', [GraficosController::class, 'anosDisponiveis']);
Route::get('/filtros/anos', [GraficosController::class, 'anosDisponiveis']);
Route::get('/filtros/unidades', [GraficosController::class, 'unidadesDisponiveis']);
Route::get('/filtros/vendedores', [GraficosController::class, 'vendedoresDisponiveis']);
Route::get('/filtros/situacoes', [GraficosController::class, 'situacoesDisponiveis']);
Route::get('/meses-vendas', [GraficosController::class, 'mesesDisponiveis']);
Route::get('/anos-vendas', [RelatorioController::class, 'anosVendas']);
Route::get('oportunidades-filtradas', [OportunidadeController::class, 'oportunidadesFiltradas']);
Route::get('/cliente_oportunidade', [ClienteOportunidadeController::class, 'index']);
Route::post('/webhook/jetsales', [WebhookController::class, 'handle']);










