<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mundo Caramelo CRM - Oportunidades</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;900&display=swap" rel="stylesheet">
    <style>
        /* Variáveis CSS para Cores (replicando do dashboard e clientes) */
        :root {
            --primary-blue: #6495ED;   /* Cornflower Blue - Azul suave */
            --light-blue: #ADD8E6;       /* Light Blue */
            --primary-pink: #FF69B4;   /* Hot Pink - Rosa vibrante */
            --light-pink: #FFB6C1;      /* Light Pink */
            --white: #FFFFFF;
            --text-dark: #333;
            --text-muted: #6c757d;
            --border-light: #e0e0e0;
            --column-bg: #ECEFF1; /* Fundo mais claro para as colunas do Kanban */
            --success-green: #28a745;
            --danger-red: #dc3545;
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
            max-width: 300px; /* Ajustado para deixar espaço para os filtros */
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

        /* Kanban Board */
        .kanban-board {
            display: flex;
            gap: 20px; /* Espaçamento entre as colunas */
            overflow-x: auto; /* Permite rolagem horizontal se muitas colunas */
            padding-bottom: 20px; /* Espaço para a barra de rolagem */
        }
        .kanban-column {
            background-color: var(--column-bg);
            border-radius: 12px;
            padding: 20px;
            min-width: 300px; /* Largura mínima da coluna */
            flex-shrink: 0; /* Impede que as colunas encolham demais */
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
            display: flex;
            flex-direction: column;
            max-height: calc(100vh - 200px); /* Limita a altura para scroll */
        }
        .kanban-column-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--border-light);
            flex-shrink: 0; /* Impede que o cabeçalho encolha */
        }
        .kanban-column-header h5 {
            font-weight: 700;
            color: var(--primary-blue);
            margin-bottom: 0;
            font-size: 1.2rem;
        }
        .kanban-column-header .count {
            background-color: var(--primary-pink);
            color: var(--white);
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 0.9rem;
            font-weight: 600;
        }
        .kanban-column-header .total-value {
            font-size: 0.95rem;
            color: var(--text-muted);
            font-weight: 500;
            margin-left: 10px;
        }

        .kanban-cards {
            flex-grow: 1;
            overflow-y: auto; /* Permite rolagem vertical para os cards */
            padding-right: 5px; /* Para a barra de rolagem não sobrepor o conteúdo */
            min-height: 50px; /* Garante que a área de drop seja visível */
        }

        .kanban-card {
            background-color: var(--white);
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.08);
            padding: 15px;
            margin-bottom: 15px;
            cursor: grab;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .kanban-card:active {
            cursor: grabbing;
        }
        .kanban-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .kanban-card h6 {
            font-weight: 600;
            color: var(--primary-blue);
            margin-bottom: 5px;
            font-size: 1.05rem;
        }
        .kanban-card .client-name {
            font-size: 0.9rem;
            color: var(--text-muted);
            margin-bottom: 8px;
        }
        .kanban-card .value-date {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        .kanban-card .value {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--primary-pink);
        }
        .kanban-card .due-date {
            font-size: 0.85rem;
            color: var(--text-muted);
        }
        .kanban-card .analyst-info {
            display: flex;
            align-items: center;
            font-size: 0.85rem;
            color: var(--text-muted);
        }
        .kanban-card .analyst-info img {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 8px;
            border: 1px solid var(--border-light);
        }

        /* Estilos específicos para Oportunidades Ganhas/Perdidas */
        .kanban-column.won .kanban-column-header h5 {
            color: var(--success-green);
        }
        .kanban-column.lost .kanban-column-header h5 {
            color: var(--danger-red);
        }
        .kanban-column.won .kanban-card {
            border-left: 5px solid var(--success-green);
        }
        .kanban-column.lost .kanban-card {
            border-left: 5px solid var(--danger-red);
        }

        /* Modal de Detalhes da Oportunidade (Reutilizando estilos do Cliente) */
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
        .modal-body .info-item {
            margin-bottom: 15px;
        }
        .modal-body .info-item strong {
            display: block;
            color: var(--text-dark);
            font-weight: 600;
            margin-bottom: 5px;
        }
        .modal-body .info-item span {
            color: var(--text-muted);
        }
        .modal-body .history-item {
            border-left: 3px solid var(--light-blue);
            padding-left: 15px;
            margin-bottom: 10px;
        }
        .modal-body .history-item .date {
            font-size: 0.8em;
            color: var(--text-muted);
        }
        .modal-body .history-item .type {
            font-weight: 500;
            color: var(--primary-blue);
        }
        .modal-body .history-item .details {
            font-size: 0.9em;
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
        <a class="navbar-brand d-flex align-items-center" href="<?php echo e(route('dashboard')); ?>">
            <img src="https://yt3.googleusercontent.com/MvJPZt3TigRQuXM98mcKNyz1exQrPPY2FJdCVCOOnzcgGRo7Nr5g-mVsgMPHmOrOTgGpl-_O0g=s900-c-k-c0x00ffffff-no-rj" alt="Logo Mundo Caramelo" class="logo-circle me-2">
            <span class="fw-bold">CRM</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
                           <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?php echo e(route('dashboard')); ?>">Dashboard do Analista</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('clientes')); ?>">Clientes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('oportunidades')); ?>">Oportunidades</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('campanhas')); ?>">Campanhas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('relatorios')); ?>">Relatórios</a>
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
    <h2 class="mb-4 text-dark ps-2">Funil de Vendas</h2>

    <div class="toolbar">
        <input type="text" class="form-control" placeholder="Pesquisar oportunidade...">
        <button type="button" class="btn btn-primary"><i class="fas fa-plus-circle me-2"></i>Criar Nova Oportunidade</button>
        <div class="dropdown">
            <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownAnalystFilter" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-user-tie me-2"></i>Analista
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownAnalystFilter">
                <li><a class="dropdown-item" href="#">Todos</a></li>
                <li><a class="dropdown-item" href="#">Graça Dias</a></li>
                <li><a class="dropdown-item" href="#">Yasminie</a></li>
                <li><a class="dropdown-item" href="#">Larissa</a></li>
            </ul>
        </div>
        <div class="dropdown">
            <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownStageFilter" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-filter me-2"></i>Estágio
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownStageFilter">
                <li><a class="dropdown-item" href="#">Todos</a></li>
                <li><a class="dropdown-item" href="#">Qualificação</a></li>
                <li><a class="dropdown-item" href="#">Proposta Enviada</a></li>
                <li><a class="dropdown-item" href="#">Negociação</a></li>
                <li><a class="dropdown-item" href="#">Fechado - Ganho</a></li>
                <li><a class="dropdown-item" href="#">Fechado - Perdido</a></li>
            </ul>
        </div>
        <div class="dropdown">
            <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownDateFilter" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-calendar-alt me-2"></i>Período
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownDateFilter">
                <li><a class="dropdown-item" href="#">Mês Atual</a></li>
                <li><a class="dropdown-item" href="#">Próximo Trimestre</a></li>
                <li><a class="dropdown-item" href="#">Personalizado</a></li>
            </ul>
        </div>
    </div>

    <div class="kanban-board">
        <div class="kanban-column" id="column-qualificacao">
            <div class="kanban-column-header">
                <h5>Qualificação</h5>
                <div>
                    <span class="count" id="count-qualificacao">3</span>
                    <span class="total-value" id="value-qualificacao">R$ 15.000</span>
                </div>
            </div>
            <div class="kanban-cards">
                <div class="kanban-card" data-id="opp1" data-bs-toggle="modal" data-bs-target="#opportunityDetailModal">
                    <h6>Aniversário de 5 Anos - Tema Princesas</h6>
                    <div class="client-name">Cliente: Sra. Lima (Mãe da Alice)</div>
                    <div class="value-date">
                        <span class="value">R$ 5.000</span>
                        <span class="due-date"><i class="far fa-calendar-alt me-1"></i> 20/Set</span>
                    </div>
                    <div class="analyst-info">
                        <img src="https://media.licdn.com/dms/image/v2/D4D03AQHUKiuia01m4g/profile-displayphoto-shrink_100_100/B4DZO8dH4QGgAY-/0/1734033575553?e=2147483647&v=beta&t=A4hj8F4hA4PL90JQcwKPqtVrY_YifF8uUIhhTeAwgfE" alt="Ana Paula">
                        Graça Dias
                    </div>
                </div>
                <div class="kanban-card" data-id="opp2" data-bs-toggle="modal" data-bs-target="#opportunityDetailModal">
                    <h6>Festa Teen - Balada Neon</h6>
                    <div class="client-name">Cliente: Sr. e Sra. Souza (Pais do Lucas)</div>
                    <div class="value-date">
                        <span class="value">R$ 7.500</span>
                        <span class="due-date"><i class="far fa-calendar-alt me-1"></i> 25/Out</span>
                    </div>
                    <div class="analyst-info">
                        <img src="https://media.licdn.com/dms/image/v2/D4D03AQHUKiuia01m4g/profile-displayphoto-shrink_100_100/B4DZO8dH4QGgAY-/0/1734033575553?e=2147483647&v=beta&t=A4hj8F4hA4PL90JQcwKPqtVrY_YifF8uUIhhTeAwgfE" alt="Yasminie">
                        Yasminie
                    </div>
                </div>
                <div class="kanban-card" data-id="opp3" data-bs-toggle="modal" data-bs-target="#opportunityDetailModal">
                    <h6>Chá Revelação - Safari</h6>
                    <div class="client-name">Cliente: Casal Oliveira</div>
                    <div class="value-date">
                        <span class="value">R$ 2.500</span>
                        <span class="due-date"><i class="far fa-calendar-alt me-1"></i> 01/Nov</span>
                    </div>
                    <div class="analyst-info">
                        <img src="https://media.licdn.com/dms/image/v2/D4D03AQHUKiuia01m4g/profile-displayphoto-shrink_100_100/B4DZO8dH4QGgAY-/0/1734033575553?e=2147483647&v=beta&t=A4hj8F4hA4PL90JQcwKPqtVrY_YifF8uUIhhTeAwgfE" alt="Larissa">
                        Larissa
                    </div>
                </div>
            </div>
        </div>

        <div class="kanban-column" id="column-proposta">
            <div class="kanban-column-header">
                <h5>Proposta Enviada</h5>
                <div>
                    <span class="count" id="count-proposta">2</span>
                    <span class="total-value" id="value-proposta">R$ 22.000</span>
                </div>
            </div>
            <div class="kanban-cards">
                <div class="kanban-card" data-id="opp4" data-bs-toggle="modal" data-bs-target="#opportunityDetailModal">
                    <h6>Festa de 15 Anos - Baile de Máscaras</h6>
                    <div class="client-name">Cliente: Sra. Costa (Mãe da Sofia)</div>
                    <div class="value-date">
                        <span class="value">R$ 15.000</span>
                        <span class="due-date"><i class="far fa-calendar-alt me-1"></i> 15/Ago</span>
                    </div>
                    <div class="analyst-info">
                        <img src="https://media.licdn.com/dms/image/v2/D4D03AQHUKiuia01m4g/profile-displayphoto-shrink_100_100/B4DZO8dH4QGgAY-/0/1734033575553?e=2147483647&v=beta&t=A4hj8F4hA4PL90JQcwKPqtVrY_YifF8uUIhhTeAwgfE" alt="Laiz">
                        Laiz
                    </div>
                </div>
                <div class="kanban-card" data-id="opp5" data-bs-toggle="modal" data-bs-target="#opportunityDetailModal">
                    <h6>Aniversário de 7 Anos - Super-Heróis</h6>
                    <div class="client-name">Cliente: Sr. Pedro (Pai do Bruno)</div>
                    <div class="value-date">
                        <span class="value">R$ 7.000</span>
                        <span class="due-date"><i class="far fa-calendar-alt me-1"></i> 10/Set</span>
                    </div>
                    <div class="analyst-info">
                        <img src="https://media.licdn.com/dms/image/v2/D4D03AQHUKiuia01m4g/profile-displayphoto-shrink_100_100/B4DZO8dH4QGgAY-/0/1734033575553?e=2147483647&v=beta&t=A4hj8F4hA4PL90JQcwKPqtVrY_YifF8uUIhhTeAwgfE" alt="Ana Paula">
                        Graça Dias
                    </div>
                </div>
            </div>
        </div>

        <div class="kanban-column" id="column-negociacao">
            <div class="kanban-column-header">
                <h5>Negociação</h5>
                <div>
                    <span class="count" id="count-negociacao">1</span>
                    <span class="total-value" id="value-negociacao">R$ 10.000</span>
                </div>
            </div>
            <div class="kanban-cards">
                <div class="kanban-card" data-id="opp6" data-bs-toggle="modal" data-bs-target="#opportunityDetailModal">
                    <h6>Festa de Formatura Infantil - Pequenos Doutores</h6>
                    <div class="client-name">Cliente: Escola Mundo Feliz</div>
                    <div class="value-date">
                        <span class="value">R$ 10.000</span>
                        <span class="due-date"><i class="far fa-calendar-alt me-1"></i> 05/Ago</span>
                    </div>
                    <div class="analyst-info">
                        <img src="https://media.licdn.com/dms/image/v2/D4D03AQHUKiuia01m4g/profile-displayphoto-shrink_100_100/B4DZO8dH4QGgAY-/0/1734033575553?e=2147483647&v=beta&t=A4hj8F4hA4PL90JQcwKPqtVrY_YifF8uUIhhTeAwgfE" alt="Yasminie">
                        Yasminie
                    </div>
                </div>
            </div>
        </div>

        <div class="kanban-column won" id="column-ganho">
            <div class="kanban-column-header">
                <h5>Fechado - Ganho</h5>
                <div>
                    <span class="count" id="count-ganho">1</span>
                    <span class="total-value" id="value-ganho">R$ 8.000</span>
                </div>
            </div>
            <div class="kanban-cards">
                <div class="kanban-card" data-id="opp7" data-bs-toggle="modal" data-bs-target="#opportunityDetailModal">
                    <h6>Aniversário de 10 Anos - Gamer Zone</h6>
                    <div class="client-name">Cliente: Sra. Pereira (Mãe do Theo)</div>
                    <div class="value-date">
                        <span class="value">R$ 8.000</span>
                        <span class="due-date"><i class="far fa-calendar-alt me-1"></i> 30/Jun</span>
                    </div>
                    <div class="analyst-info">
                        <img src="https://media.licdn.com/dms/image/v2/D4D03AQHUKiuia01m4g/profile-displayphoto-shrink_100_100/B4DZO8dH4QGgAY-/0/1734033575553?e=2147483647&v=beta&t=A4hj8F4hA4PL90JQcwKPqtVrY_YifF8uUIhhTeAwgfE" alt="Larissa">
                        Larissa
                    </div>
                </div>
            </div>
        </div>

        <div class="kanban-column lost" id="column-perdido">
            <div class="kanban-column-header">
                <h5>Fechado - Perdido</h5>
                <div>
                    <span class="count" id="count-perdido">1</span>
                    <span class="total-value" id="value-perdido">R$ 3.000</span>
                </div>
            </div>
            <div class="kanban-cards">
                <div class="kanban-card" data-id="opp8" data-bs-toggle="modal" data-bs-target="#opportunityDetailModal">
                    <h6>Aniversário de 3 Anos - Circo Mágico</h6>
                    <div class="client-name">Cliente: Sra. Santos (Mãe da Clara)</div>
                    <div class="value-date">
                        <span class="value">R$ 3.000</span>
                        <span class="due-date"><i class="far fa-calendar-alt me-1"></i> 20/Jul</span>
                    </div>
                    <div class="analyst-info">
                        <img src="https://media.licdn.com/dms/image/v2/D4D03AQHUKiuia01m4g/profile-displayphoto-shrink_100_100/B4DZO8dH4QGgAY-/0/1734033575553?e=2147483647&v=beta&t=A4hj8F4hA4PL90JQcwKPqtVrY_YifF8uUIhhTeAwgfE" alt="Laiz">
                        Laiz
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="opportunityDetailModal" tabindex="-1" aria-labelledby="opportunityDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-lg">
            <div class="modal-header">
                <h5 class="modal-title" id="opportunityDetailModalLabel">Detalhes da Oportunidade: <span id="modalOpportunityName"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Informações Gerais</h6>
                        <div class="info-item">
                            <strong>Cliente:</strong> <span id="modalOpportunityClient"></span>
                        </div>
                        <div class="info-item">
                            <strong>Valor:</strong> <span id="modalOpportunityValue"></span>
                        </div>
                        <div class="info-item">
                            <strong>Estágio:</strong> <span id="modalOpportunityStage"></span>
                        </div>
                        <div class="info-item">
                            <strong>Atendente Responsável:</strong> <span id="modalOpportunityAnalyst"></span>
                        </div>
                        <div class="info-item">
                            <strong>Data Prevista do Evento:</strong> <span id="modalOpportunityDueDate"></span>
                        </div>
                        <div class="info-item">
                            <strong>Data de Criação:</strong> <span id="modalOpportunityCreated"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6>Pacote/Serviços Envolvidos</h6>
                        <ul class="list-unstyled" id="modalOpportunityProducts">
                            <li>- Pacote Festa Completa Kids</li>
                            <li>- Decoração Temática "Reino Encantado"</li>
                            <li>- Animação com Personagens</li>
                            <li>- Mesa de Doces Personalizada</li>
                        </ul>
                        <h6 class="mt-4">Histórico de Contato</h6>
                        <div id="modalOpportunityInteractions">
                            <div class="history-item">
                                <div class="date">05/Jul/2025 - 10:00</div>
                                <div class="type">E-mail:</div>
                                <div class="details"> Envio de proposta detalhada v2 (incluindo show de mágica).</div>
                            </div>
                            <div class="history-item">
                                <div class="date">01/Jul/2025 - 15:00</div>
                                <div class="type">Reunião:</div>
                                <div class="details"> Apresentação inicial do espaço e pacotes.</div>
                            </div>
                        </div>
                    </div>
                </div>
                <h6 class="mt-4">Notas da Oportunidade</h6>
                <p id="modalOpportunityNotes">Cliente pediu inclusão de máquina de algodão doce e desconto de 5% no pacote. Avaliar viabilidade e contraproposta.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary"><i class="fas fa-pencil-alt me-2"></i>Editar</button>
                <button type="button" class="btn btn-pink"><i class="fas fa-check-circle me-2"></i>Marcar como Fechada</button>
                <button type="button" class="btn btn-danger"><i class="fas fa-times-circle me-2"></i>Marcar como Perdida</button>
                <button type="button" class="btn btn-outline-primary"><i class="fas fa-calendar-alt me-2"></i>Agendar Visita</button>
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

        <p class="text-muted mt-2 mb-0">&copy; 2025 Mundo Caramelo CRM. Todos os direitos reservados.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

<script>
    // Dados de exemplo (em um sistema real, viriam do seu backend)
    const opportunitiesData = {
        'opp1': {
            name: 'Aniversário de 5 Anos - Tema Princesas',
            client: 'Sra. Lima (Mãe da Alice)',
            value: 'R$ 5.000,00',
            stage: 'Qualificação',
            analyst: 'Graça Dias',
            dueDate: '20/Set/2025', // Data do evento
            created: '08/Jul/2025',
            products: ['Pacote Kids Essencial', 'Decoração Tema Princesas', 'Bolo Personalizado 2 Andares'],
            notes: 'Mãe da Alice, muito animada com o tema. Pediu orçamento para show de mágica adicional.'
        },
        'opp2': {
            name: 'Festa Teen - Balada Neon',
            client: 'Sr. e Sra. Souza (Pais do Lucas)',
            value: 'R$ 7.500,00',
            stage: 'Qualificação',
            analyst: 'Yasminie',
            dueDate: '25/Out/2025',
            created: '07/Jul/2025',
            products: ['Pacote Teen Premium', 'Iluminação Especial', 'DJ com repertório personalizado'],
            notes: 'Lucas quer algo moderno e com muita música. Pais preocupados com segurança.'
        },
        'opp3': {
            name: 'Chá Revelação - Safari',
            client: 'Casal Oliveira',
            value: 'R$ 2.500,00',
            stage: 'Qualificação',
            analyst: 'Larissa',
            dueDate: '01/Nov/2025',
            created: '06/Jul/2025',
            products: ['Pacote Chá Revelação', 'Decoração Safari', 'Bolo temático'],
            notes: 'Primeiro filho do casal. Buscam algo íntimo e memorável.'
        },
        'opp4': {
            name: 'Festa de 15 Anos - Baile de Máscaras',
            client: 'Sra. Costa (Mãe da Sofia)',
            value: 'R$ 15.000,00',
            stage: 'Proposta Enviada',
            analyst: 'Laiz',
            dueDate: '15/Ago/2025',
            created: '01/Jul/2025',
            products: ['Pacote Debutante Exclusive', 'Decoração Luxo', 'Atrações Especiais'],
            notes: 'Proposta enviada. Aguardando feedback sobre opções de buffet.'
        },
        'opp5': {
            name: 'Aniversário de 7 Anos - Super-Heróis',
            client: 'Sr. Pedro (Pai do Bruno)',
            value: 'R$ 7.000,00',
            stage: 'Proposta Enviada',
            analyst: 'Graça Dias',
            dueDate: '10/Set/2025',
            created: '28/Jun/2025',
            products: ['Pacote Kids Deluxe', 'Decoração Super-Heróis', 'Oficinas interativas'],
            notes: 'Proposta enviada. Cliente pediu para incluir lembrancinhas personalizadas.'
        },
        'opp6': {
            name: 'Festa de Formatura Infantil - Pequenos Doutores',
            client: 'Escola Mundo Feliz',
            value: 'R$ 10.000,00',
            stage: 'Negociação',
            analyst: 'Yasminie',
            dueDate: '05/Ago/2025',
            created: '20/Jun/2025',
            products: ['Pacote Formatura Kids', 'Cerimônia Simbólica', 'Fotos e Vídeo'],
            notes: 'Escola buscando melhor preço para formatura de 3 turmas. Negociar desconto para volume.'
        },
        'opp7': {
            name: 'Aniversário de 10 Anos - Gamer Zone',
            client: 'Sra. Pereira (Mãe do Theo)',
            value: 'R$ 8.000,00',
            stage: 'Fechado - Ganho',
            analyst: 'Larissa',
            dueDate: '30/Jun/2025',
            created: '15/Jun/2025',
            products: ['Pacote Gamer', 'Estações de Jogos', 'Realidade Virtual'],
            notes: 'Oportunidade fechada! Pagamento 50% adiantado.'
        },
        'opp8': {
            name: 'Aniversário de 3 Anos - Circo Mágico',
            client: 'Sra. Santos (Mãe da Clara)',
            value: 'R$ 3.000,00',
            stage: 'Fechado - Perdido',
            analyst: 'Laiz',
            dueDate: '20/Jul/2025',
            created: '10/Jun/2025',
            products: ['Pacote Circo Simples', 'Decoração Básica'],
            notes: 'Cliente optou por outra empresa com preço mais baixo. Feedback: preço foi o fator decisivo.'
        }
    };

    // Inicialização do Sortable.js para cada coluna do Kanban
    document.addEventListener('DOMContentLoaded', function() {
        const columns = document.querySelectorAll('.kanban-cards');
        columns.forEach(column => {
            new Sortable(column, {
                group: 'kanban', // Permite arrastar entre as colunas
                animation: 150,
                ghostClass: 'sortable-ghost', // Classe para o item sendo arrastado
                onEnd: function (evt) {
                    // Lógica para atualizar o backend quando um card é movido
                    console.log('Oportunidade ' + evt.item.dataset.id + ' movida de ' + evt.from.parentNode.id + ' para ' + evt.to.parentNode.id);
                    // Aqui você faria uma chamada AJAX para o seu PHP
                    // para atualizar o estágio da oportunidade no banco de dados.
                    updateColumnCountsAndValues(); // Atualiza os contadores
                }
            });
        });

        // Função para atualizar contadores e valores das colunas (Exemplo estático)
        function updateColumnCountsAndValues() {
            const stages = ['qualificacao', 'proposta', 'negociacao', 'ganho', 'perdido'];
            stages.forEach(stage => {
                const column = document.getElementById(`column-${stage}`);
                if (column) {
                    const cardsContainer = column.querySelector('.kanban-cards');
                    const cards = cardsContainer.querySelectorAll('.kanban-card');
                    const countSpan = column.querySelector(`#count-${stage}`);
                    const valueSpan = column.querySelector(`#value-${stage}`);

                    let totalValue = 0;
                    cards.forEach(card => {
                        const valueText = card.querySelector('.value').textContent.replace('R$ ', '').replace('.', '').replace(',', '.');
                        totalValue += parseFloat(valueText);
                    });

                    countSpan.textContent = cards.length;
                    valueSpan.textContent = 'R$ ' + totalValue.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                }
            });
        }

        // Exemplo de como popular o modal de detalhes da oportunidade (em um cenário real, viria do PHP/AJAX)
        const opportunityDetailModal = document.getElementById('opportunityDetailModal');
        opportunityDetailModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget; // Botão/Card que disparou o modal
            const opportunityId = button.dataset.id; // Pega o ID da oportunidade do atributo data-id

            const opportunity = opportunitiesData[opportunityId];

            if (opportunity) {
                document.getElementById('modalOpportunityName').textContent = opportunity.name;
                document.getElementById('modalOpportunityClient').textContent = opportunity.client;
                document.getElementById('modalOpportunityValue').textContent = opportunity.value;
                document.getElementById('modalOpportunityStage').textContent = opportunity.stage;
                document.getElementById('modalOpportunityAnalyst').textContent = opportunity.analyst;
                document.getElementById('modalOpportunityDueDate').textContent = opportunity.dueDate;
                document.getElementById('modalOpportunityCreated').textContent = opportunity.created;
                document.getElementById('modalOpportunityNotes').textContent = opportunity.notes;

                const productsList = document.getElementById('modalOpportunityProducts');
                productsList.innerHTML = '';
                opportunity.products.forEach(product => {
                    const li = document.createElement('li');
                    li.textContent = `- ${product}`;
                    productsList.appendChild(li);
                });

                // Você pode adicionar um histórico de interações aqui, se tiver nos dados.
                // Exemplo:
                // const interactionsContainer = document.getElementById('modalOpportunityInteractions');
                // interactionsContainer.innerHTML = '';
                // if (opportunity.interactions && opportunity.interactions.length > 0) {
                //     opportunity.interactions.forEach(interaction => {
                //         const item = document.createElement('div');
                //         item.classList.add('history-item');
                //         item.innerHTML = `
                //             <div class="date">${interaction.date}</div>
                //             <div class="type">${interaction.type}:</div>
                //             <div class="details">${interaction.details}</div>
                //         `;
                //         interactionsContainer.appendChild(item);
                //     });
                // } else {
                //     interactionsContainer.innerHTML = '<p class="text-muted">Nenhuma interação registrada.</p>';
                // }
            }
        });

        // Chamar a função para inicializar os contadores e valores ao carregar a página
        updateColumnCountsAndValues();
    });
</script>

</body>
</html>
<?php /**PATH C:\xampp\htdocs\laravel_app\resources\views/oportunidades.blade.php ENDPATH**/ ?>