<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mundo Caramelo CRM - Campanhas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;900&display=swap" rel="stylesheet">
    <style>
        /* Variáveis CSS para Cores (replicando de outras telas) */
        :root {
            --primary-blue: #6495ED;   /* Cornflower Blue - Azul suave */
            --light-blue: #ADD8E6;
            --primary-pink: #FF69B4;   /* Hot Pink - Rosa vibrante */
            --light-pink: #FFB6C1;      /* Light Pink */
            --white: #FFFFFF;
            --text-dark: #333;
            --text-muted: #6c757d;
            --border-light: #e0e0e0;
            --status-active: #28a745; /* Verde para ativo */
            --status-paused: #ffc107; /* Amarelo para pausado */
            --status-finished: #6c757d; /* Cinza para finalizado */
        }

        /* Estilos Globais */
        body {
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
            color: var(--text-dark);
        }

        /* Navbar (Cabeçalho) */
        .navbar {
            background-color: var(--light-blue);
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        .navbar-brand {
            font-weight: 700;
            font-size: 1.8rem;
            color: var(--primary-blue) !important;
        }
        .navbar-brand span {
            color: var(--primary-pink);
        }
        .nav-link {
            color: var(--text-dark) !important;
            font-weight: 500;
            margin: 0 10px;
            transition: color 0.3s ease;
        }
        .nav-link:hover, .nav-link.active {
            color: var(--primary-pink) !important;
        }

        /* Barra de Ferramentas */
        .toolbar {
            background-color: var(--white);
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
            padding: 20px 30px;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }
        .toolbar .form-control {
            flex-grow: 1;
            max-width: 300px;
            border-radius: 8px;
            border-color: var(--border-light);
        }
        .toolbar .btn-primary {
            background-color: var(--primary-pink);
            border-color: var(--primary-pink);
            border-radius: 8px;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }
        .toolbar .btn-primary:hover {
            background-color: #e64a9b;
            border-color: #e64a9b;
        }
        .toolbar .btn-outline-secondary {
            border-color: var(--primary-blue);
            color: var(--primary-blue);
            border-radius: 8px;
            font-weight: 500;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .toolbar .btn-outline-secondary:hover {
            background-color: var(--primary-blue);
            color: var(--white);
        }

        /* Cards de Campanha */
        .campaign-card {
            background-color: var(--white);
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.07);
            padding: 25px;
            margin-bottom: 25px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%; /* Garante que os cards na mesma linha tenham a mesma altura */
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .campaign-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0,0,0,0.12);
            cursor: pointer;
        }
        .campaign-card .campaign-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
        }
        .campaign-card h5 {
            font-weight: 700;
            color: var(--primary-blue);
            font-size: 1.3rem;
            margin-bottom: 5px;
        }
        .campaign-card .campaign-type {
            font-size: 0.9rem;
            color: var(--text-muted);
            margin-bottom: 10px;
        }
        .campaign-card .campaign-type i {
            margin-right: 5px;
            color: var(--primary-pink);
        }

        /* Tags de Status da Campanha */
        .status-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
        }
        .status-badge.active {
            background-color: rgba(40, 167, 69, 0.2); /* Verde claro */
            color: var(--status-active);
        }
        .status-badge.paused {
            background-color: rgba(255, 193, 7, 0.2); /* Amarelo claro */
            color: var(--status-paused);
        }
        .status-badge.finished {
            background-color: rgba(108, 117, 125, 0.2); /* Cinza claro */
            color: var(--status-finished);
        }
        .status-badge.draft {
            background-color: rgba(173, 216, 230, 0.2); /* Azul claro */
            color: var(--primary-blue);
        }

        .campaign-card .metrics {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(100px, 1fr)); /* 2 ou 3 colunas dependendo do espaço */
            gap: 15px;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px dashed var(--border-light);
        }
        .campaign-card .metric-item {
            text-align: center;
        }
        .campaign-card .metric-item .value {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--primary-blue);
            line-height: 1;
        }
        .campaign-card .metric-item .label {
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-top: 5px;
        }
        .campaign-card .metric-item .value.pink { color: var(--primary-pink); }
        .campaign-card .metric-item .value.green { color: var(--status-active); }

        .campaign-card .analyst-info {
            display: flex;
            align-items: center;
            font-size: 0.85rem;
            color: var(--text-muted);
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid var(--border-light);
        }
        .campaign-card .analyst-info img {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 10px;
            border: 2px solid var(--primary-blue);
        }

        /* Modal de Detalhes da Campanha / Criação */
        .modal-header {
            background-color: var(--primary-blue);
            color: var(--white);
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            padding: 20px;
        }
        .modal-header .btn-close {
            filter: invert(1);
        }
        .modal-title {
            font-weight: 600;
            font-size: 1.5rem;
        }
        .modal-body .form-label {
            font-weight: 500;
            color: var(--text-dark);
        }
        .modal-body .nav-tabs .nav-link {
            color: var(--primary-blue);
            border-color: var(--border-light);
            font-weight: 600;
        }
        .modal-body .nav-tabs .nav-link.active {
            background-color: var(--primary-blue);
            color: var(--white);
            border-color: var(--primary-blue);
        }
        .modal-footer {
            border-top: 1px solid var(--border-light);
            padding: 15px;
            justify-content: flex-start;
        }
        .modal-footer .btn {
            border-radius: 8px;
            font-weight: 500;
            margin-right: 10px;
        }
        .modal-footer .btn-pink {
            background-color: var(--primary-pink);
            border-color: var(--primary-pink);
            color: var(--white);
        }
        .modal-footer .btn-pink:hover {
            background-color: #e64a9b;
            border-color: #e64a9b;
        }
        .modal-footer .btn-success {
            background-color: var(--status-active);
            border-color: var(--status-active);
            color: var(--white);
        }
        .modal-footer .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }

        .logo-circle {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            object-fit: cover;
            background-color: white;
            border: 2px solid var(--primary-pink); /* opcional */
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg">
    <div class="container-fluid py-2">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('dashboard') }}">
            <img src="https://yt3.googleusercontent.com/MvJPZt3TigRQuXM98mcKNyz1exQrPPY2FJdCVCOOnzcgGRo7Nr5g-mVsgMPHmOrOTgGpl-_O0g=s900-c-k-c0x00ffffff-no-rj" alt="Logo Mundo Caramelo" class="logo-circle me-2">
            <span class="fw-bold">CRM</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{ route('dashboard') }}">Dashboard do Analista</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('clientes') }}">Clientes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('oportunidades') }}">Oportunidades</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('campanhas') }}">Campanhas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('relatorios') }}">Relatórios</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-circle me-1"></i> <span id="analystNameNav">Analista Logado</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#">Meu Perfil</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">Sair</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid py-5">
    <h2 class="mb-4 text-dark ps-2">Gestão de Campanhas de Marketing</h2>

    <div class="toolbar">
        <input type="text" class="form-control" placeholder="Pesquisar campanha...">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#campaignModal" data-mode="create"><i class="fas fa-plus-circle me-2"></i>Criar Nova Campanha</button>
        <div class="dropdown">
            <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownStatusFilter" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-filter me-2"></i>Status
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownStatusFilter">
                <li><a class="dropdown-item" href="#">Todos</a></li>
                <li><a class="dropdown-item" href="#">Ativa</a></li>
                <li><a class="dropdown-item" href="#">Pausada</a></li>
                <li><a class="dropdown-item" href="#">Finalizada</a></li>
                <li><a class="dropdown-item" href="#">Rascunho</a></li>
            </ul>
        </div>
        <div class="dropdown">
            <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownTypeFilter" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-tags me-2"></i>Tipo
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownTypeFilter">
                <li><a class="dropdown-item" href="#">Todos</a></li>
                <li><a class="dropdown-item" href="#">E-mail Marketing</a></li>
                <li><a class="dropdown-item" href="#">SMS</a></li>
                <li><a class="dropdown-item" href="#">Telemarketing</a></li>
                <li><a class="dropdown-item" href="#">Redes Sociais</a></li>
                <li><a class="dropdown-item" href="#">Eventos</a></li>
            </ul>
        </div>
    </div>

    

   
<div class="row">
    @forelse($campaigns as $campaign)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="campaign-card" data-bs-toggle="modal"
                 data-bs-target="#campaignModal"
                 data-campaign-id="{{ $campaign['id'] ?? '' }}"
                 data-mode="view">

                <!-- Cabeçalho da Campanha -->
                <div class="campaign-header">
                    <div>
                        <h5>{{ $campaign['name'] ?? 'Sem Nome' }}</h5>
                        <div class="campaign-type">
                            <i class="fas fa-bullhorn"></i>
                            Campanha
                        </div>
                    </div>
                    <span class="status-badge {{ strtolower($campaign['status'] ?? '') }}">
                        {{ ucfirst($campaign['status'] ?? 'Desconhecido') }}
                    </span>
                </div>

                <!-- Métricas -->
                <div class="metrics">
                    <div class="metric-item">
                        <div class="value pink">{{ $campaign['contactsCount'] ?? 0 }}</div>
                        <div class="label">Contatos que receberam</div>
                    </div>
                    <div class="metric-item">
                        <div class="value">{{ $campaign['lidas'] ?? '0%' }}</div>
                        <div class="label">Contatos que Visualizaram</div>
                    </div>
                    <div class="metric-item">
                        <div class="value green">{{ $campaign['userId'] ?? '-' }}</div>
                        <div class="label">Responsável (ID Usuário)</div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <p class="text-muted">Nenhuma campanha encontrada.</p>
    @endforelse
</div>



    </div>
</div>

<div class="modal fade" id="campaignModal" tabindex="-1" aria-labelledby="campaignModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content rounded-lg">
            <div class="modal-header">
                <h5 class="modal-title" id="campaignModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs mb-3" id="campaignTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="details-tab" data-bs-toggle="tab" data-bs-target="#details" type="button" role="tab" aria-controls="details" aria-selected="true">Detalhes</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="content-tab" data-bs-toggle="tab" data-bs-target="#content" type="button" role="tab" aria-controls="content" aria-selected="false">Conteúdo</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="audience-tab" data-bs-toggle="tab" data-bs-target="#audience" type="button" role="tab" aria-controls="audience" aria-selected="false">Público Alvo</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="metrics-tab" data-bs-toggle="tab" data-bs-target="#metrics" type="button" role="tab" aria-controls="metrics" aria-selected="false">Métricas e Relatórios</button>
                    </li>
                </ul>
                <div class="tab-content" id="campaignTabContent">
                    <div class="tab-pane fade show active" id="details" role="tabpanel" aria-labelledby="details-tab">
                        <form>
                            <div class="mb-3">
                                <label for="campaignName" class="form-label">Nome da Campanha</label>
                                <input type="text" class="form-control" id="campaignName" placeholder="Ex: Campanha de Black Friday">
                            </div>
                            <div class="mb-3">
                                <label for="campaignDescription" class="form-label">Descrição</label>
                                <textarea class="form-control" id="campaignDescription" rows="3" placeholder="Objetivo da campanha, notas importantes..."></textarea>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="campaignType" class="form-label">Tipo de Campanha</label>
                                    <select class="form-select" id="campaignType">
                                        <option value="">Selecione...</option>
                                        <option value="email">E-mail Marketing</option>
                                        <option value="sms">SMS</option>
                                        <option value="telemarketing">Telemarketing</option>
                                        <option value="social">Redes Sociais</option>
                                        <option value="event">Evento</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="campaignStatus" class="form-label">Status</label>
                                    <select class="form-select" id="campaignStatus">
                                        <option value="draft">Rascunho</option>
                                        <option value="active">Ativa</option>
                                        <option value="paused">Pausada</option>
                                        <option value="finished">Finalizada</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="campaignStartDate" class="form-label">Data de Início</label>
                                    <input type="date" class="form-control" id="campaignStartDate">
                                </div>
                                <div class="col-md-6">
                                    <label for="campaignEndDate" class="form-label">Data de Fim</label>
                                    <input type="date" class="form-control" id="campaignEndDate">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="campaignAnalyst" class="form-label">Analista Responsável</label>
                                <select class="form-select" id="campaignAnalyst">
                                    <option value="">Selecione...</option>
                                    <option value="ana">Graça dias</option>
                                    <option value="carlos">Laiz</option>
                                    <option value="mariana">Yasminie</option>
                                    <option value="roberto">Larissa</option>
                                </select>
                            </div>
                        </form>
                    </div>

                    <div class="tab-pane fade" id="content" role="tabpanel" aria-labelledby="content-tab">
                        <h6>Crie o conteúdo da sua campanha aqui:</h6>
                        <div class="mb-3">
                            <label for="emailSubject" class="form-label">Assunto do E-mail (se aplicável)</label>
                            <input type="text" class="form-control" id="emailSubject" placeholder="Ex: Sua oferta exclusiva de Verão!">
                        </div>
                        <div class="mb-3">
                            <label for="campaignContent" class="form-label">Corpo do E-mail / Mensagem SMS</label>
                            <textarea class="form-control" id="campaignContent" rows="10" placeholder="Insira o texto HTML do seu e-mail ou a mensagem do SMS aqui."></textarea>
                            <small class="form-text text-muted">Para e-mail, um editor WYSIWYG real seria ideal.</small>
                        </div>
                        <button class="btn btn-outline-primary"><i class="fas fa-paper-plane me-2"></i>Testar Envio</button>
                    </div>

                    <div class="tab-pane fade" id="audience" role="tabpanel" aria-labelledby="audience-tab">
                        <h6>Defina o público para esta campanha:</h6>
                        <div class="mb-3">
                            <label for="audienceSegment" class="form-label">Segmento de Clientes</label>
                            <select class="form-select" id="audienceSegment">
                                <option value="all">Todos os Contatos</option>
                                <option value="leads">Apenas Leads</option>
                                <option value="active-clients">Clientes Ativos</option>
                                <option value="inactive-clients">Clientes Inativos (Reengajamento)</option>
                                <option value="vip">Clientes VIP</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="audienceCustom" class="form-label">Critérios de Segmentação Avançada (Opcional)</label>
                            <textarea class="form-control" id="audienceCustom" rows="4" placeholder="Ex: Clientes que compraram 'Produto X' nos últimos 3 meses e estão em 'São Paulo'."></textarea>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="metrics" role="tabpanel" aria-labelledby="metrics-tab">
                        <h6>Visão Geral das Métricas da Campanha</h6>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="card p-3 text-center border-0 shadow-sm">
                                    <h5 class="text-muted">Envios/Leads</h5>
                                    <h3 class="text-primary" id="metricLeads">--</h3>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="card p-3 text-center border-0 shadow-sm">
                                    <h5 class="text-muted">Tx. Abertura</h5>
                                    <h3 class="text-pink" id="metricOpenRate">--</h3>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="card p-3 text-center border-0 shadow-sm">
                                    <h5 class="text-muted">Conversões</h5>
                                    <h3 class="text-success" id="metricConversions">--</h3>
                                </div>
                            </div>
                        </div>
                        <p class="text-muted mt-3">Gráficos de desempenho (taxa de abertura por hora, cliques por link, etc.) seriam exibidos aqui.</p>
                        <button class="btn btn-outline-info"><i class="fas fa-chart-bar me-2"></i>Ver Relatório Completo</button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-success" id="btnLaunchCampaign"><i class="fas fa-paper-plane me-2"></i>Lançar Campanha</button>
                <button type="button" class="btn btn-pink" id="btnSaveCampaign"><i class="fas fa-save me-2"></i>Salvar Rascunho</button>
                <button type="button" class="btn btn-danger d-none" id="btnDeleteCampaign"><i class="fas fa-trash-alt me-2"></i>Excluir</button>
            </div>
        </div>
    </div>
</div>

<footer class="footer mt-auto py-3">
    <div class="container text-center">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="https://yt3.googleusercontent.com/MvJPZt3TigRQuXM98mcKNyz1exQrPPY2FJdCVCOOnzcgGRo7Nr5g-mVsgMPHmOrOTgGpl-_O0g=s900-c-k-c0x00ffffff-no-rj" alt="Logo" class="logo-circle me-2">
            <span><span style="color: var(--primary-pink);"></span></span>
        </a>

        <p class="text-muted mt-2 mb-0">&copy; 2025 Mundo Caramelo CRM.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const campaignsData = {
        'camp1': {
            name: 'Boas-Vindas (Novos Leads)',
            description: 'Campanha de e-mail marketing automatizada para novos leads.',
            type: 'email',
            status: 'active',
            startDate: '2025-07-01',
            endDate: '2025-12-31',
            analyst: 'Graça Dias',
            metrics: {
                leadsReached: 1250,
                openRate: '45.2%',
                clickRate: '12.8%',
                conversions: 50
            },
            content: {
                subject: 'Bem-vindo(a) ao Mundo Caramelo!',
                body: 'Olá [Nome do Lead], seja bem-vindo ao Mundo Caramelo! Descubra nossos pacotes incríveis para festas e eventos. [Link para o site]'
            },
            audience: {
                segment: 'leads',
                custom: 'Todos os leads recém-cadastrados.'
            }
        },
        'camp2': {
            name: 'Promoção Relâmpago (Julho)',
            description: 'Campanha de SMS com oferta especial de 10% de desconto para pacotes de festa infantil.',
            type: 'sms',
            status: 'paused',
            startDate: '2025-07-10',
            endDate: '2025-07-15',
            analyst: 'Laiz',
            metrics: {
                leadsReached: 800,
                openRate: 'N/A', // SMS não tem taxa de abertura
                clickRate: '8.5%',
                conversions: 15
            },
            content: {
                subject: 'N/A',
                body: 'Mundo Caramelo: 10% OFF em festas infantis! Use o código FESTA10. Valido ate 15/07. Saiba mais: [Link]'
            },
            audience: {
                segment: 'active-clients',
                custom: 'Clientes ativos que ainda não fecharam um evento em 2025.'
            }
        },
        'camp3': {
            name: 'Lançamento Novo Pacote Festa Teen',
            description: 'Campanha de redes sociais para divulgar o novo pacote "Festa Teen - Balada Neon".',
            type: 'social',
            status: 'draft',
            startDate: '',
            endDate: '',
            analyst: 'Yasminie',
            metrics: {
                leadsReached: 0,
                openRate: '0%',
                clickRate: '0%',
                conversions: 0
            },
            content: {
                subject: 'N/A',
                body: 'Prepare-se para a balada mais épica! 🚀 Apresentamos o novo pacote Festa Teen - Balada Neon! 🌟 Iluminação, DJ e muita diversão! Saiba mais: [Link]'
            },
            audience: {
                segment: 'all',
                custom: 'Adolescentes e pais de adolescentes interessados em festas.'
            }
        },
        'camp4': {
            name: 'Mundo Caramelo',
            description: 'Webinar gratuito sobre "Como planejar a festa perfeita para seu filho".',
            type: 'event',
            status: 'finished',
            startDate: '2025-05-15',
            endDate: '2025-05-15',
            analyst: 'Larissa',
            metrics: {
                leadsReached: 250, // Participantes
                openRate: 'N/A',
                clickRate: 'N/A',
                conversions: 10
            },
            content: {
                subject: 'N/A',
                body: 'Participe do nosso webinar exclusivo e aprenda a planejar a festa dos sonhos! Inscrições abertas: [Link]'
            },
            audience: {
                segment: 'leads',
                custom: 'Leads interessados em dicas de festas e eventos.'
            }
        }
    };

    document.addEventListener('DOMContentLoaded', function() {
        const campaignModal = document.getElementById('campaignModal');
        campaignModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget; // Botão que disparou o modal
            const campaignId = button.dataset.campaignId;
            const mode = button.dataset.mode; // 'create' ou 'view'

            const modalTitle = document.getElementById('campaignModalLabel');
            const btnLaunch = document.getElementById('btnLaunchCampaign');
            const btnSave = document.getElementById('btnSaveCampaign');
            const btnDelete = document.getElementById('btnDeleteCampaign');

            // Resetar formulário e visibilidade dos botões
            document.getElementById('campaignName').value = '';
            document.getElementById('campaignDescription').value = '';
            document.getElementById('campaignType').value = '';
            document.getElementById('campaignStatus').value = 'draft';
            document.getElementById('campaignStartDate').value = '';
            document.getElementById('campaignEndDate').value = '';
            document.getElementById('campaignAnalyst').value = '';
            document.getElementById('emailSubject').value = '';
            document.getElementById('campaignContent').value = '';
            document.getElementById('audienceSegment').value = 'all';
            document.getElementById('audienceCustom').value = '';

            btnLaunch.classList.remove('d-none');
            btnSave.classList.remove('d-none');
            btnDelete.classList.add('d-none'); // Esconde o delete por padrão

            // Resetar métricas
            document.getElementById('metricLeads').textContent = '--';
            document.getElementById('metricOpenRate').textContent = '--';
            document.getElementById('metricConversions').textContent = '--';

            // Resetar abas
            const firstTab = new bootstrap.Tab(document.getElementById('details-tab'));
            firstTab.show();


            if (mode === 'create') {
                modalTitle.textContent = 'Criar Nova Campanha';
                // Campos já estão vazios
            } else if (mode === 'view' && campaignId) {
                modalTitle.textContent = 'Detalhes da Campanha';
                const campaign = campaignsData[campaignId];

                if (campaign) {
                    document.getElementById('campaignName').value = campaign.name;
                    document.getElementById('campaignDescription').value = campaign.description;
                    document.getElementById('campaignType').value = campaign.type;
                    document.getElementById('campaignStatus').value = campaign.status;
                    document.getElementById('campaignStartDate').value = campaign.startDate;
                    document.getElementById('campaignEndDate').value = campaign.endDate;
                    document.getElementById('campaignAnalyst').value = campaign.analyst;
                    document.getElementById('emailSubject').value = campaign.content.subject;
                    document.getElementById('campaignContent').value = campaign.content.body;
                    document.getElementById('audienceSegment').value = campaign.audience.segment;
                    document.getElementById('audienceCustom').value = campaign.audience.custom;

                    // Preencher Métricas
                    document.getElementById('metricLeads').textContent = campaign.metrics.leadsReached;
                    document.getElementById('metricOpenRate').textContent = campaign.metrics.openRate;
                    document.getElementById('metricConversions').textContent = campaign.metrics.conversions;

                    // Ajustar visibilidade dos botões baseado no status
                    if (campaign.status === 'active') {
                        btnLaunch.classList.add('d-none');
                        btnSave.textContent = 'Atualizar Campanha';
                        btnDelete.classList.remove('d-none');
                    } else if (campaign.status === 'finished') {
                        btnLaunch.classList.add('d-none');
                        btnSave.classList.add('d-none');
                        btnDelete.classList.remove('d-none');
                    } else { // draft ou paused
                        btnLaunch.classList.remove('d-none');
                        btnSave.textContent = 'Salvar Rascunho';
                        btnDelete.classList.remove('d-none');
                    }
                }
            }
        });

        // Event listeners para botões (simulação)
        document.getElementById('btnLaunchCampaign').addEventListener('click', function() {
            alert('Campanha Lançada! (Simulação)');
            // Aqui você faria a lógica para mudar o status para 'active' no backend
            // e fechar o modal ou atualizar a lista de campanhas.
            const modal = bootstrap.Modal.getInstance(campaignModal);
            modal.hide();
        });

        document.getElementById('btnSaveCampaign').addEventListener('click', function() {
            alert('Campanha Salva! (Simulação)');
            // Aqui você faria a lógica para salvar/atualizar a campanha no backend
            const modal = bootstrap.Modal.getInstance(campaignModal);
            modal.hide();
        });

        document.getElementById('btnDeleteCampaign').addEventListener('click', function() {
            if (confirm('Tem certeza que deseja excluir esta campanha?')) {
                alert('Campanha Excluída! (Simulação)');
                // Lógica para excluir no backend
                const modal = bootstrap.Modal.getInstance(campaignModal);
                modal.hide();
            }
        });
    });
</script>

</body>
</html>
