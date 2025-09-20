<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mundo Caramelo CRM - Clientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;900&display=swap" rel="stylesheet">
    <style>
        /* Variáveis CSS para Cores */
        :root {
            --primary-blue: #6495ED;   /* Cornflower Blue - Azul suave */
            --light-blue: #ADD8E6;       /* Light Blue */
            --primary-pink: #FF69B4;   /* Hot Pink - Rosa vibrante */
            --light-pink: #FFB6C1;      /* Light Pink */
            --white: #FFFFFF;
            --text-dark: #333;
            --text-muted: #6c757d;
            --border-light: #e0e0e0;
        }

        /* Estilos Globais */
        body {
            background-color: #f8f9fa; /* Um cinza muito claro para o fundo */
            font-family: 'Poppins', sans-serif; /* Fonte moderna e limpa */
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

        /* Toolbar */
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
        .toolbar .form-control,
        .toolbar .dropdown-toggle {
            border-radius: 8px;
            border-color: var(--border-light);
        }
        .toolbar .btn-primary {
            background-color: var(--primary-blue);
            border-color: var(--primary-blue);
            border-radius: 8px;
            font-weight: 500;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }
        .toolbar .btn-primary:hover {
            background-color: #5383DE; /* Um tom mais escuro de azul */
            border-color: #5383DE;
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

        /* Tabela de Clientes */
        .client-table-container {
            background-color: var(--white);
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0,0,0,0.1);
            padding: 20px;
            overflow-x: auto; /* Permite scroll horizontal em telas pequenas */
        }
        .client-table {
            width: 100%;
            margin-bottom: 0;
            border-collapse: separate; /* Para border-radius nas células */
            border-spacing: 0; /* Para evitar espaçamento extra */
        }
        .client-table thead th {
            background-color: var(--light-blue);
            color: var(--primary-blue);
            font-weight: 600;
            padding: 15px;
            border-bottom: 2px solid var(--primary-blue);
            vertical-align: middle;
        }
        .client-table tbody tr {
            cursor: pointer;
            transition: background-color 0.2s ease;
        }
        .client-table tbody tr:hover {
            background-color: #f1f1f1;
        }
        .client-table tbody td {
            padding: 15px;
            vertical-align: middle;
            border-bottom: 1px solid var(--border-light);
        }
        .client-table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Estilos para Status Tags */
        .status-tag {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            color: var(--white);
        }
        .status-tag.active {
            background-color: #28a745; /* Verde */
        }
        .status-tag.lead {
            background-color: var(--primary-pink); /* Rosa */
        }
        .status-tag.inactive {
            background-color: var(--text-muted); /* Cinza */
        }

        /* Estilo para links na tabela */
        .name-link {
            color: var(--primary-blue);
            text-decoration: none;
            font-weight: 600;
        }
        .name-link:hover {
            text-decoration: underline;
        }

        /* Ícones de Ação na Tabela */
        .action-icons i {
            margin-right: 10px;
            cursor: pointer;
            color: var(--text-muted);
            transition: color 0.2s ease;
        }
        .action-icons i:hover {
            color: var(--primary-blue);
        }
        .action-icons i.fa-trash-alt:hover {
            color: #dc3545; /* Vermelho para excluir */
        }

        /* Paginação */
        .pagination-container {
            padding: 20px 0 10px 0;
            display: flex;
            justify-content: flex-end; /* Alinha a paginação à direita */
        }
        .pagination .page-item .page-link {
            border-radius: 8px;
            margin: 0 4px;
            color: var(--primary-blue);
            border-color: var(--primary-blue);
            transition: background-color 0.2s ease, color 0.2s ease;
        }
        .pagination .page-item.active .page-link,
        .pagination .page-item .page-link:hover {
            background-color: var(--primary-blue);
            color: var(--white);
            border-color: var(--primary-blue);
        }

        /* Modal de Detalhes do Cliente */
        .modal-content {
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        }
        .modal-header {
            background-color: var(--primary-blue);
            color: var(--white);
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
            border-bottom: none;
            padding: 20px 25px;
        }
        .modal-header .btn-close {
            filter: invert(1); /* Torna o X branco */
        }
        .modal-title {
            font-weight: 700;
            font-size: 1.5rem;
        }
        .modal-body {
            padding: 30px 25px;
        }
        .modal-body h6 {
            color: var(--primary-blue);
            font-weight: 600;
            margin-bottom: 15px;
            padding-bottom: 5px;
            border-bottom: 1px solid var(--border-light);
        }
        .modal-body .info-item {
            margin-bottom: 10px;
            font-size: 0.95rem;
        }
        .modal-body .info-item strong {
            color: var(--text-dark);
            margin-right: 5px;
        }
        .modal-body .history-item {
            border-left: 3px solid var(--primary-pink);
            padding-left: 10px;
            margin-bottom: 10px;
        }
        .modal-body .history-item .date {
            font-size: 0.85rem;
            color: var(--text-muted);
        }
        .modal-body .history-item .type {
            font-weight: 600;
            color: var(--text-dark);
            margin-top: 2px;
        }
        .modal-body .history-item .details {
            font-size: 0.9rem;
            color: var(--text-muted);
        }
        .modal-footer {
            border-top: 1px solid var(--border-light);
            padding: 20px 25px;
            justify-content: flex-start; /* Alinha botões à esquerda */
            gap: 10px;
        }
        .modal-footer .btn {
            border-radius: 8px;
            font-weight: 500;
            padding: 10px 15px;
        }
        .modal-footer .btn-pink {
            background-color: var(--primary-pink);
            border-color: var(--primary-pink);
            color: var(--white);
        }
        .modal-footer .btn-pink:hover {
            background-color: #e65a9e; /* Um tom mais escuro de rosa */
            border-color: #e65a9e;
        }

        /* --- Estilos para o Termômetro de Receptividade --- */
        .receptivity-thermometer {
            display: flex;
            align-items: center;
            font-size: 1.1rem; /* Tamanho do ícone */
        }

        .receptivity-thermometer i {
            margin-right: 5px;
            transition: color 0.3s ease;
        }

        /* Cores para os Níveis de Receptividade */
        .receptivity-0 i { color: #ccc; } /* Cinza - Nada Receptivo */
        .receptivity-1 i { color: #FFD700; } /* Dourado/Amarelo - Pouco Receptivo */
        .receptivity-2 i { color: #FFA500; } /* Laranja - Moderadamente Receptivo */
        .receptivity-3 i { color: #FF4500; } /* Laranja avermelhado - Receptivo */
        .receptivity-4 i { color: #DC143C; } /* Vermelho escuro - Muito Receptivo */
        .receptivity-5 i { color: #8B0000; } /* Vermelho intenso - Extremamente Receptivo */

        /* Adicional para a label */
        .receptivity-label {
            font-size: 0.9rem;
            color: var(--text-muted);
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
    <h2 class="mb-4 text-dark ps-2">Gestão de Clientes e Leads</h2>

<div class="toolbar">
    <!-- Pesquisa rápida -->
    <input type="text" class="form-control" placeholder="Pesquisar clientes por nome, e-mail, telefone..." id="searchInput">
    <button type="button" class="btn btn-primary">
        <i class="fas fa-plus-circle me-2"></i>Adicionar Novo Cliente
    </button>

    <!-- Tipo de cliente -->
    <div class="dropdown">
        <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownClientTypeFilter" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-users me-2"></i>Tipo de Cliente: <span id="currentClientTypeFilter">Todos</span>
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownClientTypeFilter">
            <li><a class="dropdown-item filter-client-type" href="#" data-filter-type="all">Todos</a></li>
            <li><a class="dropdown-item filter-client-type" href="#" data-filter-type="active">Clientes</a></li>
            <li><a class="dropdown-item filter-client-type" href="#" data-filter-type="lead">Leads</a></li>
        </ul>
    </div>

    <!-- Status -->
    <div class="dropdown">
        <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownStatusFilter" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-filter me-2"></i>Status
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownStatusFilter">
            <li><a class="dropdown-item" href="#">Todos</a></li>
            <li><a class="dropdown-item" href="#">Clientes Ativos</a></li>
            <li><a class="dropdown-item" href="#">Leads</a></li>
            <li><a class="dropdown-item" href="#">Inativos</a></li>
        </ul>
    </div>

    <!-- Fonte (marketing) -->
    <div class="dropdown">
        <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownSourceFilter" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-bullhorn me-2"></i>Fonte
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownSourceFilter">
            <!-- JS vai popular dinamicamente -->
        </ul>
    </div>
  
    <!-- Analista -->
<div class="dropdown">
    <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownAnalystFilter" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fas fa-user-tie me-2"></i>Analista
    </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownAnalystFilter">
        <li>
            <input type="text" class="form-control mx-2 my-2" id="searchAnalistaInput" placeholder="Pesquisar analista...">
        </li>
        <!-- JS popula os itens aqui -->
    </ul>
</div>

</div>

<!-- Tabela de clientes/leads -->
<div class="client-table-container mt-3">
    <table class="table client-table">
        <thead>
            <tr>
                <th scope="col"><input type="checkbox"></th>
                <th scope="col">Nome</th>
                <th scope="col">E-mail</th>
                <th scope="col">Telefone</th>
                <th scope="col">Origem</th>
                <th scope="col">Fonte</th>
                <th scope="col">Status</th>
                <th scope="col">Analista</th>
                <th scope="col">Data de Cadastro</th>
                <th scope="col">Ações</th>
            </tr>
        </thead>
        <tbody id="clientsTableBody"></tbody>
    </table>

    <!-- Paginação -->
    <nav class="pagination-container" aria-label="Navegação de Clientes">
        <ul class="pagination"></ul>
    </nav>
</div>


<div class="modal fade" id="clientDetailModal" tabindex="-1" aria-labelledby="clientDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-lg">
            <div class="modal-header">
                <h5 class="modal-title" id="clientDetailModalLabel">Detalhes do Cliente: <span id="modalClientName"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Informações Gerais</h6>
                        <div class="info-item">
                            <strong>E-mail:</strong> <span id="modalClientEmail"></span>
                        </div>
                        <div class="info-item">
                            <strong>Telefone:</strong> <span id="modalClientPhone"></span>
                        </div>
                        <div class="info-item">
                            <strong>Status:</strong> <span id="modalClientStatus"></span>
                        </div>
                        <div class="info-item">
                            <strong>Fonte de Captação:</strong> <span id="modalClientSource"></span>
                        </div>
                        <div class="info-item">
                            <strong>Analista Responsável:</strong> <span id="modalClientAnalyst"></span>
                        </div>
                        <div class="info-item">
                            <strong>Receptividade:</strong> <span id="modalClientReceptivity"></span>
                        </div>
                        <div class="info-item">
                            <strong>Data de Cadastro:</strong> <span id="modalClientCreated"></span>
                        </div>
                        <div class="info-item">
                            <strong>Última Atualização:</strong> <span id="modalClientUpdated"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6>Histórico de Interações</h6>
                        <div id="modalClientInteractions">
                            </div>
                        <h6 class="mt-4">Oportunidades</h6>
                        <ul class="list-unstyled" id="modalClientOpportunities">
                            </ul>
                             <h6 class="mt-4">Histórico de Compras</h6>
                            <ul class="list-unstyled" id="modalClientPurchases">
                            </ul>
                    </div>
                </div>
                <h6 class="mt-4">Notas Internas</h6>
                <p id="modalClientNotes"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-pink"><i class="fas fa-paper-plane me-2"></i>Enviar E-mail</button>
                <button type="button" class="btn btn-outline-primary"><i class="fas fa-phone-alt me-2"></i>Ligar</button>
                <button type="button" class="btn btn-outline-primary"><i class="fas fa-calendar-alt me-2"></i>Agendar Tarefa</button>
                <button type="button" class="btn btn-outline-primary"><i class="fas fa-robot me-2"></i>Iniciar Chat</button>
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
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// =========================
// Variáveis globais
// =========================
let filtroTipo = 'all';
let filtroStatus = 'all';
let filtroFonte = 'all';
let filtroAnalista = 'all';
let currentPage = 1;
let searchQuery = '';

const perPage = 20;
const maxPageButtons = 10;
// A base da API agora usa o caminho relativo "api"
const API_BASE = "api";


const searchInput = document.getElementById('searchInput');
searchInput.addEventListener('input', e => {
    searchQuery = e.target.value;
    currentPage = 1; // volta para a primeira página ao pesquisar
    fetchLeadsTodos();
});

// =========================
// Popular filtros de fontes
// =========================
async function popularFontes() {
    try {
        // Correção aqui: Adicionando a barra "/"
        const response = await fetch(`${API_BASE}/fontes`);
        if (!response.ok) throw new Error("Erro ao buscar fontes");
        const fontes = await response.json();

        const filtroFonteMenu = document.querySelector("#dropdownSourceFilter + .dropdown-menu");
        filtroFonteMenu.innerHTML = '';

        // Adiciona opção "Todos"
        const liTodos = document.createElement("li");
        liTodos.innerHTML = `<a class="dropdown-item" href="#" data-id="all">Todos</a>`;
        liTodos.querySelector('a').addEventListener('click', e => {
            e.preventDefault();
            filtroFonte = 'all';
            currentPage = 1;
            fetchLeadsTodos();
        });
        filtroFonteMenu.appendChild(liTodos);

        fontes.forEach(fonte => {
            const li = document.createElement("li");
            li.innerHTML = `<a class="dropdown-item" href="#" data-id="${fonte.id_fonte}">${fonte.nome}</a>`;
            li.querySelector('a').addEventListener('click', e => {
                e.preventDefault();
                filtroFonte = fonte.id_fonte;
                currentPage = 1;
                fetchLeadsTodos();
            });
            filtroFonteMenu.appendChild(li);
        });

    } catch (error) {
        console.error("Erro ao popular filtros de fontes:", error);
    }
}


// =========================
// Popular filtro de Analistas (consultor_comercial)
// =========================
async function popularAnalistas() {
    try {
        // Correção aqui: Adicionando a barra "/"
        const response = await fetch(`${API_BASE}/analistas`);
        if (!response.ok) throw new Error("Erro ao buscar analistas");
        const analistas = await response.json();

        const filtroAnalistaMenu = document.querySelector("#dropdownAnalystFilter + .dropdown-menu");
        filtroAnalistaMenu.querySelectorAll('li:not(:first-child)').forEach(li => li.remove()); // Limpa itens antigos

        // Adiciona opção "Todos"
        const liTodos = document.createElement("li");
        liTodos.innerHTML = `<a class="dropdown-item" href="#" data-id="all">Todos</a>`;
        liTodos.querySelector('a').addEventListener('click', e => {
            e.preventDefault();
            filtroAnalista = 'all';
            currentPage = 1;
            fetchLeadsTodos();
        });
        filtroAnalistaMenu.appendChild(liTodos);

        // Popula os analistas
        analistas.forEach(analista => {
            const li = document.createElement("li");
            li.innerHTML = `<a class="dropdown-item" href="#" data-id="${analista.id}">${analista.nome_completo}</a>`;
            li.querySelector('a').addEventListener('click', e => {
                e.preventDefault();
                filtroAnalista = analista.id;
                currentPage = 1;
                fetchLeadsTodos();
            });
            filtroAnalistaMenu.appendChild(li);
        });

        // =========================
        // Filtragem com debounce
        // =========================
        const searchInput = document.getElementById('searchAnalistaInput');
        let debounceTimer;
        searchInput.addEventListener('input', e => {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                const query = e.target.value.toLowerCase();
                filtroAnalistaMenu.querySelectorAll('li a[data-id]').forEach(a => {
                    if (a.textContent.toLowerCase().includes(query) || a.dataset.id === 'all') {
                        a.parentElement.style.display = '';
                    } else {
                        a.parentElement.style.display = 'none';
                    }
                });
            }, 200); // espera 200ms após digitar
        });

    } catch (error) {
        console.error("Erro ao popular filtros de analistas:", error);
    }
}


// =========================
// Adicionar eventos para filtros estáticos
// =========================
function adicionarEventosFiltros() {
    // Tipo de cliente
    document.querySelectorAll('.filter-client-type').forEach(el => {
        el.addEventListener('click', e => {
            e.preventDefault();
            filtroTipo = el.dataset.filterType;
            document.getElementById('currentClientTypeFilter').innerText = el.innerText;
            currentPage = 1;
            fetchLeadsTodos();
        });
    });

    // Status
    document.querySelectorAll('#dropdownStatusFilter .dropdown-item').forEach(el => {
        el.addEventListener('click', e => {
            e.preventDefault();
            const text = el.innerText.toLowerCase();
            if (text.includes('ativo')) filtroStatus = 'ativo';
            else if (text.includes('inativo')) filtroStatus = 'inativo';
            else filtroStatus = 'all';
            currentPage = 1;
            fetchLeadsTodos();
        });
    });
}

// =========================
// Buscar leads com filtros e paginação
// =========================
async function fetchLeadsTodos(page = currentPage) {
    const tbody = document.getElementById('clientsTableBody');
    try {
        // Correção aqui: Adicionando a barra "/"
        const url = `${API_BASE}/leads-todos?page=${page}&per_page=${perPage}&tipo=${filtroTipo}&status=${filtroStatus}&fonte=${filtroFonte}&vendedor=${filtroAnalista}&search=${encodeURIComponent(searchQuery)}`;

        const response = await fetch(url);
        if (!response.ok) throw new Error(`Erro de rede: ${response.status}`);
        const data = await response.json();

        tbody.innerHTML = '';
      
        data.data.forEach(item => {
            const tr = document.createElement('tr');
            tr.dataset.id = item.id;
            tr.innerHTML = `
                <td><input type="checkbox"></td>
                <td>${item.nome || '-'}</td>
                <td>${item.email || '-'}</td>
                <td>${item.numero || '-'}</td>
                <td>${item.origem === 'cliente' ? 'Cliente' : 'Lead'}</td>
                <td>${item.fonte || '-'}</td>
                <td>${item.status == 1 ? 'Ativo' : item.status == 0 ? 'Inativo' : '-'}</td>
                <td>${item.analista || '-'}</td>
                <td>${item.data_cadastro || '-'}</td>
                <td><button class="btn btn-sm btn-primary show-modal-btn">Detalhes</button></td>
            `;
            tbody.appendChild(tr);
        });

        atualizarPaginacao(data.last_page);
        
        // =============================================
        // Chama a função para adicionar os listeners aos novos botões criados
        // =============================================
        addModalListeners();

    } catch (error) {
        console.error('Erro ao buscar leads:', error);
    }
}

// =========================
// Paginação
// =========================
function atualizarPaginacao(lastPage) {
    const paginationContainer = document.querySelector('.pagination');
    paginationContainer.innerHTML = '';

    const createPageItem = (label, pageNumber, disabled = false, active = false) => {
        const li = document.createElement('li');
        li.className = `page-item ${disabled ? 'disabled' : ''} ${active ? 'active' : ''}`;
        const a = document.createElement('a');
        a.className = 'page-link';
        a.href = '#';
        a.textContent = label;
        a.addEventListener('click', e => {
            e.preventDefault();
            if (!disabled && currentPage !== pageNumber) {
                currentPage = pageNumber;
                fetchLeadsTodos();
            }
        });
        li.appendChild(a);
        return li;
    };

    paginationContainer.appendChild(createPageItem('Anterior', currentPage - 1, currentPage === 1));

    let startPage = Math.max(1, currentPage - Math.floor(maxPageButtons / 2));
    let endPage = startPage + maxPageButtons - 1;
    if (endPage > lastPage) {
        endPage = lastPage;
        startPage = Math.max(1, endPage - maxPageButtons + 1);
    }

    for (let i = startPage; i <= endPage; i++) {
        paginationContainer.appendChild(createPageItem(i, i, false, i === currentPage));
    }

    paginationContainer.appendChild(createPageItem('Próxima', currentPage + 1, currentPage === lastPage));
}

// =========================
// Inicialização
// =========================
window.addEventListener("DOMContentLoaded", async () => {
    await popularFontes();
    await popularAnalistas(); // popula filtro de analistas
    adicionarEventosFiltros();
    fetchLeadsTodos();
});


   // =========================
// Abrir modal com detalhes
// =========================
// Função para adicionar o listener de clique
function addModalListeners() {
    document.querySelectorAll('.show-modal-btn').forEach(button => {
        button.addEventListener('click', async (e) => {
            const tr = e.target.closest('tr');
            const rawId = tr.dataset.id;
            
            // Verifica se o ID contém ":" e pega apenas a parte numérica antes dele
            const id = rawId ? rawId.split(':')[0] : null;

            if (!id) {
                console.error("ID do cliente não encontrado.");
                return;
            }

            try {
                // Correção aqui: Adicionando a barra "/"
                const response = await fetch(`${API_BASE}/lead-detalhes/${id}`);
                if (!response.ok) throw new Error('Erro ao buscar detalhes do cliente');
                const data = await response.json();

                // Preenche o modal
                document.getElementById('modalClientName').innerText = data.nome || '-';
                document.getElementById('modalClientEmail').innerText = data.email || '-';
                document.getElementById('modalClientPhone').innerText = data.numero || '-';
                document.getElementById('modalClientStatus').innerText = data.status == 1 ? 'Ativo' : data.status == 0 ? 'Inativo' : '-';
                document.getElementById('modalClientSource').innerText = data.fonte || '-';
                document.getElementById('modalClientAnalyst').innerText = data.analista || '-';
                document.getElementById('modalClientReceptivity').innerText = data.receptividade || '-';
                document.getElementById('modalClientCreated').innerText = data.data_cadastro || '-';
                document.getElementById('modalClientUpdated').innerText = data.data_atualizacao || '-';
                document.getElementById('modalClientNotes').innerText = data.notas || '-';

                // Preenche o histórico de interações
                const interactionsContainer = document.getElementById('modalClientInteractions');
                interactionsContainer.innerHTML = '';
                if (data.interacoes && data.interacoes.length > 0) {
                    data.interacoes.forEach(interacao => {
                        const div = document.createElement('div');
                        div.classList.add('info-item');
                        div.innerHTML = `<strong>${interacao.data}:</strong> ${interacao.descricao}`;
                        interactionsContainer.appendChild(div);
                    });
                } else {
                    interactionsContainer.innerHTML = '<p>Nenhuma interação registrada.</p>';
                }

                // Preenche as oportunidades
                const opportunitiesContainer = document.getElementById('modalClientOpportunities');
                opportunitiesContainer.innerHTML = '';
                if (data.oportunidades && data.oportunidades.length > 0) {
                    data.oportunidades.forEach(op => {
                        const li = document.createElement('li');
                        li.innerText = op.descricao;
                        opportunitiesContainer.appendChild(li);
                    });
                } else {
                    opportunitiesContainer.innerHTML = '<p>Nenhuma oportunidade em andamento.</p>';
                }
                
    
// =========================
// Preenche Histórico de compras
// =========================
const purchasesContainer = document.getElementById('modalClientPurchases');
purchasesContainer.innerHTML = '<li>Carregando...</li>';

try {
    const purchaseResponse = await fetch(
        `${API_BASE}/relatorios/historico-vendas/${encodeURIComponent(data.nome)}`
    );

    if (!purchaseResponse.ok) {
        throw new Error('Erro ao buscar histórico de compras');
    }

    const purchases = await purchaseResponse.json();

    purchasesContainer.innerHTML = '';

    if (purchases.length > 0) {
        purchases.forEach(purchase => {
            const li = document.createElement('li');
            li.innerHTML = `
                <strong>${purchase.evento}</strong> - ${purchase.situacao}<br>
                Pacotes: ${purchase.pacotes}<br>
                Total: ${Number(purchase.total).toLocaleString('pt-BR', {
                    style: 'currency',
                    currency: 'BRL',
                    minimumFractionDigits: 2
                })}<br>
                Data: ${purchase.data_evento || '-'}
            `;
            purchasesContainer.appendChild(li);
        });
    } else {
        purchasesContainer.innerHTML = '<li>Nenhuma compra registrada.</li>';
    }
} catch (err) {
    console.error('Erro ao carregar histórico de compras:', err);
    purchasesContainer.innerHTML = '<li>Erro ao carregar histórico.</li>';
}

// =========================
// Mostra o modal
// =========================
const modal = new bootstrap.Modal(document.getElementById('clientDetailModal'));
modal.show();

} catch (err) {
    console.error('Erro ao carregar detalhes do cliente:', err);

    // Exibe mensagem de erro amigável
    const errorMessageElement = document.getElementById('errorMessage');
    if (errorMessageElement) {
        errorMessageElement.innerText =
            'Erro ao carregar detalhes do cliente. Verifique o console para mais informações.';
        errorMessageElement.style.display = 'block';
        setTimeout(() => {
            errorMessageElement.style.display = 'none';
        }, 5000); // Esconde a mensagem depois de 5 segundos
    }
}

        });
    });
}
       // Gráfico de Meta de Conversão
       const canvas = document.getElementById('conversionGoalChart');
       if (canvas) {
           const ctx = canvas.getContext('2d');
           // A lógica do gráfico aqui
           const meta = 100;
           // Não use `clientsData`, pois não está definido em seu código
           // const atingido = clientsData.filter(c => c.status === 'Ativo').length;
           // Em vez disso, você precisaria buscar os dados da API para o gráfico
           const atingido = 0; // Temporário

           document.getElementById('conversionGoalValue').textContent = meta;
           document.getElementById('conversionCurrentValue').textContent = atingido;
           document.getElementById('conversionPercentageText').textContent = `${Math.round((atingido / meta) * 100)}%`;

           new Chart(ctx, {
               type: 'doughnut',
               data: {
                   labels: ['Atingido', 'Faltante'],
                   datasets: [{
                       data: [atingido, meta - atingido],
                       backgroundColor: ['#4CAF50', '#E0E0E0'],
                       borderWidth: 0
                   }]
               },
               options: {
                   cutout: '75%',
                   plugins: {
                       legend: {
                           display: false
                       }
                   }
               }
           });
       }
   
</script>


</body>
</html><?php /**PATH C:\xampp\htdocs\laravel_app\resources\views/clientes.blade.php ENDPATH**/ ?>