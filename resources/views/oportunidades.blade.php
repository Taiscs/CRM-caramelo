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
                        <a class="nav-link active" aria-current="page" href="{{ route('dashboard') }}">Dashboard do Analista</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('clientes') }}">Clientes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('oportunidades') }}">Oportunidades</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('campanhas') }}">Campanhas</a>
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
            {{-- Esses serão populados via JS --}}
        </ul>
    </div>

    {{-- Dropdown para Mês --}}
    <div class="dropdown">
        <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownMonthFilter" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-calendar-alt me-2"></i>Mês
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMonthFilter">
            {{-- Serão populados via JS --}}
        </ul>
    </div>

    {{-- Dropdown para Ano --}}
    <div class="dropdown">
        <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownYearFilter" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-calendar-check me-2"></i>Ano
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownYearFilter">
            {{-- Serão populados via JS --}}
        </ul>
    </div>

    {{-- Dropdown para Unidade --}}
    <div class="dropdown">
        <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownUnitFilter" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-building me-2"></i>Unidade
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownUnitFilter">
            {{-- Serão populados via JS --}}
        </ul>
    </div>
</div>
  

<div class="kanban-board">

    {{-- Coluna de Oportunidades mundo balada --}}
    <div class="kanban-column" id="column-oportunidades-balada">
        <div class="kanban-column-header">
            <h5>Oportunidades mundo balada</h5>
            <div>
                <span class="count" id="count-oportunidades-balada">{{ count($kanban['Oportunidades mundo balada']) }}</span>
                <span class="total-value" id="value-oportunidades-balada">
                    R$ {{ number_format(collect($kanban['Oportunidades mundo balada'])->sum('total'), 2, ',', '.') }}
                </span>
            </div>
        </div>
        <div class="kanban-cards">
            @foreach ($kanban['Oportunidades mundo balada'] as $oportunidade)
               <div class="kanban-card open-client-modal" data-id="opp{{ $oportunidade->id }}" data-cliente-id="{{ $oportunidade->cliente_id }}">
                    <h6>{{ $oportunidade->evento }}</h6>
                    <div class="client-name">Cliente: {{ $oportunidade->cliente_nome }}</div>
                    <div class="value-date">
                        <span class="value">R$ {{ number_format($oportunidade->total, 2, ',', '.') }}</span>
                        <span class="due-date">
                            <i class="far fa-calendar-alt me-1"></i> {{ \Carbon\Carbon::parse($oportunidade->data_ultima_festa)->format('d/M') }}
                        </span>
                    </div>
                    <p>Próximo Aniversário: {{ \Carbon\Carbon::parse($oportunidade->proximo_aniversario)->format('d/m/Y') }}</p>
                    <p>Idade: {{ $oportunidade->idade_proximo_aniversario }} anos</p>
                    <div class="analyst-info">
                        <img src="{{ $oportunidade->foto_vendedor }}" alt="{{ $oportunidade->vendedor_nome }}">
                        {{ $oportunidade->vendedor_nome }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>

  {{-- Coluna de Potencial de Ganho --}}
<div class="kanban-column" id="column-potencial-ganho">
    <div class="kanban-column-header">
        <h5>Potencial de Ganho</h5>
        <div>
            <span class="count" id="count-potencial-ganho">{{ count($kanban['Potencial de Ganho']) }}</span>
            <span class="total-value" id="value-potencial-ganho">
                R$ {{ number_format(collect($kanban['Potencial de Ganho'])->sum('total'), 2, ',', '.') }}
            </span>
        </div>
    </div>
    <div class="kanban-cards">
        @foreach ($kanban['Potencial de Ganho'] as $oportunidade)
            <div class="kanban-card open-client-modal" data-id="opp{{ $oportunidade->id }}" data-cliente-id="{{ $oportunidade->cliente_id }}">
                <h6>{{ $oportunidade->evento }}</h6>
                <div class="client-name">Cliente: {{ $oportunidade->cliente_nome }}</div>
                <div class="value-date">
                    <span class="value">R$ {{ number_format($oportunidade->total, 2, ',', '.') }}</span>
                    <span class="due-date">
                        <i class="far fa-calendar-alt me-1"></i> {{ \Carbon\Carbon::parse($oportunidade->data_ultima_festa)->format('d/M') }}
                    </span>
                </div>
                <p>Próximo Aniversário: {{ \Carbon\Carbon::parse($oportunidade->proximo_aniversario)->format('d/m/Y') }}</p>
                <p>Idade: {{ $oportunidade->idade_proximo_aniversario }} anos</p>
                <div class="analyst-info">
                    <img src="{{ $oportunidade->foto_vendedor }}" alt="{{ $oportunidade->vendedor_nome }}">
                    {{ $oportunidade->vendedor_nome }}
                </div>
            </div>
        @endforeach
    </div>
</div>
        {{-- Coluna de Oportunidades personalizadas --}}
    <div class="kanban-column" id="column-oportunidades-personalizadas">
        <div class="kanban-column-header">
            <h5>Oportunidades personalizadas</h5>
            <div>
                <span class="count" id="count-oportunidades-personalizadas">{{ count($kanban['Oportunidades personalizadas']) }}</span>
            </div>
        </div>
        <div class="kanban-cards">
            @foreach ($kanban['Oportunidades personalizadas'] as $oportunidade)
                <div class="kanban-card open-client-modal" data-id="opp{{ $oportunidade->id }}" data-cliente-id="{{ $oportunidade->cliente_id }}">
                    <h6>{{ $oportunidade->descricao_oportunidade }}</h6>
                    <div class="client-name">Cliente: {{ $oportunidade->cliente_nome }}</div>
                    <div class="value-date">
                        <span class="due-date">
                            <i class="far fa-calendar-alt me-1"></i> Data: {{ \Carbon\Carbon::parse($oportunidade->data_oportunidade)->format('d/M/Y') }}
                        </span>
                    </div>
                    <p>Último Evento: {{ $oportunidade->ultimo_evento ?? 'N/A' }}</p>
                    <div class="analyst-info">
                        <img src="{{ $oportunidade->foto_vendedor }}" alt="{{ $oportunidade->vendedor_nome }}">
                        {{ $oportunidade->vendedor_nome }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    
    {{-- Você pode replicar a mesma estrutura para as outras colunas --}}

</div>
<div class="modal fade" id="clientDetailModal" tabindex="-1" aria-labelledby="clientDetailModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="clientDetailModalLabel">Detalhes do Cliente</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p><strong>Nome:</strong> <span id="clientName"></span></p>
        <p><strong>Email:</strong> <span id="clientEmail"></span></p>
        <p><strong>Telefone:</strong> <span id="clientPhone"></span></p>
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
 document.addEventListener('DOMContentLoaded', function() {

    // --- Função para retornar o ícone correto para cada filtro ---
    function getIconForFilter(filterId) {
        if (filterId === 'dropdownAnalystFilter') return 'fas fa-user-tie';
        if (filterId === 'dropdownMonthFilter') return 'fas fa-calendar-alt';
        if (filterId === 'dropdownYearFilter') return 'fas fa-calendar-check';
        if (filterId === 'dropdownUnitFilter') return 'fas fa-building';
        return '';
    }

    // --- Popula dropdowns dinamicamente ---
    async function populateDropdown(dropdownId, url, valueKey, textKey, defaultText) {
        try {
            const response = await fetch(url);
            if (!response.ok) throw new Error(`Erro ao carregar ${url}`);

            const data = await response.json();
            const dropdown = document.querySelector(`#${dropdownId} + .dropdown-menu`);
            dropdown.innerHTML = '';

            if (defaultText) {
                dropdown.innerHTML += `<li><a class="dropdown-item" href="#">${defaultText}</a></li>`;
            }

            if (Array.isArray(data)) {
                data.forEach(item => {
                    let value, text;
                    if (typeof item === 'object') {
                        value = item[valueKey];
                        text = item[textKey];
                    } else {
                        value = text = item;
                    }
                    dropdown.innerHTML += `<li><a class="dropdown-item" href="#" data-value="${value}">${text}</a></li>`;
                });
            }

        } catch (error) {
            console.error("Erro populando dropdown:", error);
        }
    }

    // --- Aplica filtros e atualiza o Kanban ---
    async function applyFilters(filterId = null, filterValue = null) {
        const currentFilters = {
            analyst: document.getElementById('dropdownAnalystFilter').dataset.selectedValue || '',
            month: document.getElementById('dropdownMonthFilter').dataset.selectedValue || '',
            year: document.getElementById('dropdownYearFilter').dataset.selectedValue || '',
            unit: document.getElementById('dropdownUnitFilter').dataset.selectedValue || '',
            search: document.querySelector('.toolbar input[type="text"]')?.value || ''
        };

        if (filterId && filterValue !== null) {
            const btn = document.getElementById(filterId);
            if (btn) {
                btn.dataset.selectedValue = filterValue;
                btn.innerHTML = `<i class="${getIconForFilter(filterId)} me-2"></i> ${filterValue}`;
            }

            if (filterId === 'dropdownAnalystFilter') currentFilters.analyst = filterValue;
            if (filterId === 'dropdownMonthFilter') currentFilters.month = filterValue;
            if (filterId === 'dropdownYearFilter') currentFilters.year = filterValue;
            if (filterId === 'dropdownUnitFilter') currentFilters.unit = filterValue;
            if (filterId === 'search') currentFilters.search = filterValue;
        }

        try {                              
            const response = await fetch(`https://crm-caramelo.onrender.com/api/api/oportunidades-filtradas?` + new URLSearchParams(currentFilters));
            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            const data = await response.json();
            renderKanbanCards(data);
        } catch (error) {
            console.error('Erro ao aplicar filtros:', error);
        }
    }

    // --- Inicializa dropdowns ---
    async function initDropdowns() {
        await populateDropdown('dropdownAnalystFilter', 'https://crm-caramelo.onrender.com/api/analistas', 'vendedor_id', 'vendedor', 'Todos os Analistas');
        await populateDropdown('dropdownMonthFilter', 'https://crm-caramelo.onrender.com/api/meses-vendas', 'mes', 'mes', 'Todos os Meses');
        await populateDropdown('dropdownYearFilter', 'https://crm-caramelo.onrender.com/api/filtros/anos', 'ano', 'ano', 'Todos os Anos');
        await populateDropdown('dropdownUnitFilter', 'https://crm-caramelo.onrender.com/api/filtros/unidades', 'ID', 'NOME', 'Todas as Unidades');
    }

    // --- Eventos de clique nos dropdowns ---
    document.querySelectorAll('.dropdown-menu').forEach(menu => {
        menu.addEventListener('click', function(event) {
            const target = event.target;
            if (target.classList.contains('dropdown-item')) {
                event.preventDefault();
                const dropdown = this.previousElementSibling;
                const filterId = dropdown.id;
                const filterValue = target.dataset.value || target.textContent;
                dropdown.dataset.selectedValue = filterValue;
                dropdown.innerHTML = `<i class="${getIconForFilter(filterId)} me-2"></i> ${target.textContent}`;
                applyFilters(filterId, filterValue);
            }
        });
    });

    // --- Filtro de busca ---
    const searchInput = document.querySelector('.toolbar input[type="text"]');
    let searchTimeout;
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => applyFilters('search', this.value), 500);
    });

    // Inicializa todos
    initDropdowns();
});


        // CÓDIGO DO MODAL (APENAS SE ESTIVER NO MESMO BLOCO DE SCRIPT)
        const cards = document.querySelectorAll('.open-client-modal');
        const modal = new bootstrap.Modal(document.getElementById('clientDetailModal'));

        cards.forEach(card => {
            card.addEventListener('click', function () {
                const clienteId = this.getAttribute('data-cliente-id');

                if (clienteId) {
                    fetch(`/cliente/${clienteId}`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Cliente não encontrado');
                            }
                            return response.json();
                        })
                        .then(data => {
                            document.getElementById('clientName').textContent = data.Nome;
                            document.getElementById('clientEmail').textContent = data.Email;
                            document.getElementById('clientPhone').textContent = data.Telefone;
                            // Adicione as outras propriedades que você retornou
                            modal.show();
                        })
                        .catch(error => console.error('Erro ao buscar dados do cliente:', error));
                }
            });
        });
 
</script>   



</body>
</html>
