<?php 

use Illuminate\Support\Facades\Route; 
use App\Http\Controllers\Auth\LoginController; 
use App\Http\Controllers\ClienteController; 
use App\Http\Controllers\OportunidadeController; 
use App\Http\Controllers\CampanhaController; 
use App\Http\Controllers\RelatorioController; 
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ContatoController;
use App\Http\Controllers\ConsultorController;
 

// Rota do Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Rota para a página de Clientes 
Route::get('/clientes',[ClienteController::class, 'index'])->name('clientes');

// Rota para a página de Oportunidades 
Route::get('/oportunidades', [OportunidadeController::class, 'index'])->name('oportunidades'); 

// Rota para a página de Campanhas 
Route::get('/campanhas', [CampanhaController::class, 'index'])->name('campanhas'); 

// Rota para a página de Relatórios
Route::get('/relatorios', [RelatorioController::class, 'index'])->name('relatorios'); 

// Rotas de redirecionamento/autenticação 
Route::get('/homologacao', function () { return view('homologacao'); })->name('homologacao'); 
Route::get('/chamados', function () { return view('chamados'); })->name('chamados'); 

// Rota para sincronizar manualmente um contato com a API da Jetsales 
Route::post('/sincronizar-contato', [ContatoController::class, 'sincronizarContato']);

// Rota para KPIs do relatório
Route::get('/relatorios/kpis', [RelatorioController::class, 'kpis'])->name('relatorios.kpis');

//Cadastrar vendedor
Route::get('/vendedor/create', [ConsultorController::class, 'create'])->name('vendedor.create');
Route::post('/vendedor/store', [ConsultorController::class, 'store'])->name('vendedor.store');
Route::put('/vendedor/{id}/foto', [ConsultorController::class, 'updateFoto'])->name('vendedor.updateFoto');
Route::put('/vendedor/{id}/update', [ConsultorController::class, 'update'])->name('vendedor.update');
 



