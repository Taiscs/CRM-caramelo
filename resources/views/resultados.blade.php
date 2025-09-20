<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mundo Caramelo CRM - Relatórios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;900&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            --bg-page: #f8f9fa;
        }

        /* Estilos Globais */
        body {
            background-color: var(--bg-page);
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
        .toolbar .form-select {
            max-width: 200px; /* Ajusta largura dos seletores */
            border-radius: 8px;
            border-color: var(--border-light);
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

        /* Cards de Destaque (KPIs) */
        .kpi-card {
            background-color: var(--white);
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.07);
            padding: 25px;
            text-align: center;
            height: 100%; /* Garante altura uniforme */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .kpi-card .icon-wrapper {
            background-color: var(--light-blue);
            border-radius: 50%;
            width: 60px;
            height: 60px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 15px;
        }
        .kpi-card .icon-wrapper i {
            font-size: 1.8rem;
            color: var(--primary-blue);
        }
        .kpi-card .icon-wrapper.pink {
            background-color: var(--light-pink);
        }
        .kpi-card .icon-wrapper.pink i {
            color: var(--primary-pink);
        }
        .kpi-card .title {
            font-size: 16px;
            font-weight: 100;
            color: var(--text-dark);
            margin-bottom: 5px;
        }
        .kpi-card .value {
            font-size: 16px;
            font-weight: 300;
            color: var(--primary-blue);
            line-height: 1;
            margin-bottom: 5px;
        }
        .kpi-card .value.pink { color: var(--primary-pink); }
        .kpi-card .subtitle {
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        /* Card de Gráfico */
        .chart-card {
            background-color: var(--white);
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.07);
            padding: 25px;
            margin-bottom: 30px;
        }
        .chart-card h5 {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 20px;
            font-size: 1.3rem;
            border-bottom: 1px solid var(--border-light);
            padding-bottom: 10px;
        }
        .chart-card .chart-container {
            position: relative;
            height: 400px; /* Altura padrão para os gráficos */
            width: 100%;
        }


      #salesByPackageChart {
    width: 100% !important;
    height: 100% !important;
}


     

        .year-comparison-chart {
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        .year-comparison-chart .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        .year-comparison-chart .chart-header h6 {
            font-weight: 600;
            margin-bottom: 0;
            color: var(--primary-blue);
        }
        .year-comparison-chart .chart-container {
            flex-grow: 1;
        }

        /* Estilos para os Cards de Vendedor na Lateral */
        .seller-card {
            background-color: var(--white);
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.07);
            padding: 20px;
            margin-bottom: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        .seller-card .seller-photo {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 15px;
            border: 3px solid var(--primary-blue);
        }
        .seller-card h6 {
            font-weight: 700;
            color: var(--primary-blue);
            margin-bottom: 15px;
            font-size: 1.1rem;
        }
        .seller-card .seller-stats {
            width: 100%;
            text-align: left;
        }
        .seller-card .stat-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px dashed var(--border-light);
            font-size: 0.95rem;
        }
        .seller-card .stat-item:last-child {
            border-bottom: none;
        }
        .seller-card .stat-item .label {
            color: var(--text-muted);
            font-weight: 500;
        }
        .seller-card .stat-item .value {
            font-weight: 700;
            color: var(--text-dark);
        }
        .seller-card .stat-item .value.money {
            color: var(--primary-pink);
        }

        /* Responsividade */
        @media (max-width: 991.98px) { /* Para telas menores que large (lg) */
            .main-content {
                order: 2; /* Move o conteúdo principal para baixo */
            }
            .sidebar-cards {
                order: 1; /* Move a sidebar para cima */
                margin-bottom: 30px; /* Adiciona espaçamento abaixo da sidebar */
                display: flex; /* Permite que os cards de vendedor fiquem lado a lado em algumas resoluções */
                flex-wrap: wrap;
                justify-content: center;
            }
            .sidebar-cards .seller-card {
                width: 48%; /* Duas colunas em tablets */
                margin-right: 2%;
                margin-left: 2%;
            }
        .chart-comparison-row .col-md-6 {
                display: flex;
                flex-direction: column;
                height: 400px; /* altura fixa */
            }
         
            .year-comparison-chart .chart-container {
                height: 250px; /* Ajuste para telas menores */
            }
        }
        @media (max-width: 575.98px) { /* Para telas extra small (xs) */
            .sidebar-cards .seller-card {
                width: 95%; /* Uma coluna em celulares */
                margin: 0 auto 20px auto;
            }
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

               <li class="nav-item">
                    <a class="nav-link" href="{{ route('vendedor.create') }}">Vendedores</a>
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
    <h2 class="mb-4 text-dark ps-2">Relatórios e Análises</h2>

    <div class="toolbar">
    <div class="col-md-2">
    <label for="filtroAno" class="form-label">Ano</label>
    <select id="filtroAno" class="form-select"></select>
  </div>
  <div class="col-md-2">
    <label for="filtroMes" class="form-label">Mês</label>
    <select id="filtroMes" class="form-select">
      <option value="">Todos</option>
      <option value="1">Janeiro</option>
      <option value="2">Fevereiro</option>
      <option value="3">Março</option>
      <!-- até 12 -->
    </select>
  </div>
  <div class="col-md-2">
    <label for="filtroUnidade" class="form-label">Unidade</label>
    <select id="filtroUnidade" class="form-select"></select>
  </div>
  <div class="col-md-2">
    <label for="filtroVendedor" class="form-label">Vendedor</label>
    <select id="filtroVendedor" class="form-select"></select>
  </div>
  <div class="col-md-2">
    <label for="filtroSituacao" class="form-label">Situação</label>
    <select id="filtroSituacao" class="form-select"></select>
  </div>

        <button class="btn btn-outline-secondary"><i class="fas fa-download me-2"></i>Exportar Dados</button>
    </div>

    <div class="row">
        <div class="col-lg-3 sidebar-cards">
            <div id="sellerCardsContainer"></div>
        </div> 

        <div class="col-lg-9 main-content">
            <div class="row mb-5">
                 <div class="col-lg-3 col-md-6 mb-4">
            <div class="kpi-card">
                <div class="icon-wrapper blue">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="title">Melhor Resultado de Vendas</div>  
                <div class="value blue" id="kpiBestSales"></div>
                <div class="subtitle" id="kpiBestSalesSubtitle"></div>
            </div>
        </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="kpi-card">
                        <div class="icon-wrapper pink">
                            <i class="fas fa-box-open"></i>
                        </div>
                        <div class="title">Pacote Mais Vendido</div>
                        <div class="value pink" id="kpiBestPackage"></div>
                        <div class="subtitle" id="kpiBestPackageQty"></div>
                    </div>
                </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="kpi-card">
                    <div class="icon-wrapper">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="title">Principal Fonte de Captação</div>
                    <div class="value" id="kpiBestSource">Carregando...</div>
                    <div class="subtitle" id="kpiBestSourceSubtitle"></div>
                </div>
            </div>
              <div class="col-lg-3 col-md-6 mb-4">
                <div class="kpi-card">
                    <div class="icon-wrapper pink">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <div class="title">Cliente que Mais Comprou</div>
                    <div class="value pink" id="kpiBestClient">...</div>
                    <div class="subtitle" id="kpiBestClientDetails"></div>
                </div>
            </div>
            </div>

              <!-- Gráfico de Vendas por Unidade -->

            <div class="row">
                <div class="col-lg-6 mb-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="chart-card">
                <h5 class="text-xl font-semibold text-gray-800 mb-4">Ranking de Vendas por Unidade</h5>
                         <div class="chart-container">
                   <canvas id="salesByUnitChart"></canvas>
                        </div>

                
        </div>
    </div>

                </div>
                <div class="col-lg-6 mb-4">
                    <div class="chart-card">
                        <h5>Vendas por Pacote de Festas</h5>
                        <div class="chart-container w-100 h-100">
                            <canvas id="salesByPackageChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 mb-4">
                    <div class="row chart-comparison-row">
                        <div class="col-md-6 mb-4 mb-md-0">
                            <div class="chart-card">
                                <h5>Vendas de Adicionais por Vendedor</h5>
                                <div class="chart-container">
                                    <canvas id="additionalSalesBySellerChart"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="chart-card">
                                <h8>Vendas de Pacotes por Vendedor</h8>
                                <div class="chart-container">
                                    <canvas id="packageSalesBySellerChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 mb-4">
                    <div class="row chart-comparison-row">

                        <!-- Gráfico Vendas por Mês -->
                        <div class="col-md-6 mb-4 mb-md-0">
                            <div class="chart-card">
                                <h5>Vendas por Mês (Últimos 12 Meses)</h5>
                                
                                <!-- Select de ano -->
                                
                       

                                <div class="chart-container">
                                    <canvas id="salesByMonthChart"></canvas>
                                </div>
                            </div>
                        </div>

                        <!-- Gráfico Vendas Totais por Ano -->
                        <div class="col-md-6">
                            <div class="chart-card">
                                <h5>Vendas Totais por Ano</h5>
                                <div class="chart-container">
                                    <canvas id="salesByYearChart"></canvas>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>


              <div class="col-lg-12 mb-4">
    <div class="chart-card">
        <h5 class="mb-4">Comparativo de Vendas Anuais</h5>
        <div class="row year-comparison-row">
            
            <!-- Primeiro gráfico -->
            <div class="col-md-6 mb-4 mb-md-0">
                <div class="year-comparison-chart">
                    <div class="chart-header d-flex align-items-center justify-content-between">
                        <h6>Vendas Anuais</h6>
                        <select class="form-select w-auto" id="yearSelect1">
                            <!-- Opções preenchidas dinamicamente -->
                        </select>
                    </div>
                    <div class="chart-container">
                        <canvas id="yearlySalesChart1"></canvas>
                    </div>
                </div>
            </div>

            <!-- Segundo gráfico -->
            <div class="col-md-6">
                <div class="year-comparison-chart">
                    <div class="chart-header d-flex align-items-center justify-content-between">
                        <h6>Vendas Anuais</h6>
                        <select class="form-select w-auto" id="yearSelect2">
                            <!-- Opções preenchidas dinamicamente -->
                        </select>
                    </div>
                    <div class="chart-container">
                        <canvas id="yearlySalesChart2"></canvas>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>


            </div>
        </div>
    </div>
</div>

<footer class="footer mt-auto py-3">
    <div class="container text-center">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('dashboard') }}">
            <img src="https://yt3.googleusercontent.com/MvJPZt3TigRQuXM98mcKNyz1exQrPPY2FJdCVCOOnzcgGRo7Nr5g-mVsgMPHmOrOTgGpl-_O0g=s900-c-k-c0x00ffffff-no-rj" alt="Logo" class="logo-circle me-2">
            <span><span style="color: var(--primary-pink);"></span></span>
        </a>

        <p class="text-muted mt-2 mb-0">&copy; 2025 Mundo Caramelo CRM. Todos os direitos reservados.</p>
    </div>
</footer>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

<script>

    async function carregarMeses() {
    const filtroMes = document.getElementById('filtroMes');
    try {
        const response = await fetch('api/meses-vendas');
        const meses = await response.json();

        const nomesMeses = [
            '', 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho',
            'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'
        ];

        filtroMes.innerHTML = '<option value="">Todos</option>'; // Reset
        meses.forEach(m => {
            const option = document.createElement('option');
            option.value = m;
            option.textContent = nomesMeses[m];
            filtroMes.appendChild(option);
        });
    } catch (error) {
        console.error('Erro ao carregar meses:', error);
    }
}

document.addEventListener('DOMContentLoaded', carregarMeses);


async function carregarFiltros() {
  try {
    // ---------------------------
    // Anos
    // ---------------------------
    const resAno = await fetch('api/anos-vendas'); // ajustei a rota
    const anos = await resAno.json();
    const anoSelect = document.getElementById('filtroAno');

    anoSelect.innerHTML = `<option value="">Todos</option>` + 
      anos.map(a => `<option value="${a}">${a}</option>`).join('');

    // ---------------------------
    // Meses
    // ---------------------------
    await carregarMeses(); // já popula o filtroMes com "Todos" incluso

    // ---------------------------
    // Unidades
    // ---------------------------
    const resUnidade = await fetch('api/filtros/unidades');
    const unidades = await resUnidade.json();
    const unidadeSelect = document.getElementById('filtroUnidade');
    unidadeSelect.innerHTML = `<option value="">Todas</option>` +
      unidades.map(u => `<option value="${u.ID}">${u.NOME}</option>`).join('');

    // ---------------------------
    // Vendedores
    // ---------------------------
    const resVend = await fetch('api/filtros/vendedores');
    const vendedores = await resVend.json();
    const vendedorSelect = document.getElementById('filtroVendedor');
    vendedorSelect.innerHTML = `<option value="">Todos</option>` +
      vendedores.map(v => `<option value="${v.vendedor_id}">${v.vendedor}</option>`).join('');

    // ---------------------------
    // Situação
    // ---------------------------
    const resSit = await fetch('api/filtros/situacoes');
    const situacoes = await resSit.json();
    const sitSelect = document.getElementById('filtroSituacao');
    sitSelect.innerHTML = `<option value="">Todas</option>` +
      situacoes.map(s => `<option value="${s}">${s}</option>`).join('');

  } catch (err) {
    console.error("❌ Erro ao carregar filtros:", err);
  }
}

document.addEventListener('DOMContentLoaded', carregarFiltros);


// Card Pacote mais vendido
function fetchKpiBestPackage() {
    const ano = $('#filtroAno').val();
    const mes = $('#filtroMes').val();
    const vendedor = $('#filtroVendedor').val();
    const unidade = $('#filtroUnidade').val();
    const situacao = $('#filtroSituacao').val();

    const query = $.param({ ano, mes, vendedor, unidade, situacao });

    $.ajax({
        url: 'api/relatorios/kpis?' + query,
        method: 'GET',
        success: function(data) {
            $('#kpiBestPackage').text(data.pacoteMaisVendido.pacote);
            $('#kpiBestPackageQty').text(data.pacoteMaisVendido.totalVendido + ' unidades vendidas');
        },
        error: function(err) {
            console.error('Erro ao carregar KPIs', err);
            $('#kpiBestPackage').text('Erro');
            $('#kpiBestPackageQty').text('Tente novamente');
        }
    });
}

// Chama ao carregar a página
fetchKpiBestPackage();

// Atualiza quando algum filtro mudar
['filtroAno', 'filtroMes', 'filtroUnidade', 'filtroVendedor', 'filtroSituacao'].forEach(id => {
    const select = document.getElementById(id);
    if (select) {
        select.addEventListener('change', fetchKpiBestPackage);
    }
});

//Melhor vendedor

function fetchKpiBestSeller() {
    const ano = $('#filtroAno').val();
    const mes = $('#filtroMes').val();
    const vendedor = $('#filtroVendedor').val();
    const unidade = $('#filtroUnidade').val();
    const situacao = $('#filtroSituacao').val();

    const query = $.param({ ano, mes, vendedor, unidade, situacao });

    $.ajax({
        url: 'api/relatorios/kpis/vendedor?' + query,
        method: 'GET',
        success: function(data) {
            const vendedor = data.vendedorMaisVendeu;

            const formatter = new Intl.NumberFormat('pt-BR', {
                style: 'currency',
                currency: 'BRL',
                minimumFractionDigits: 2
            });

            $('#kpiBestSales').text(formatter.format(vendedor.valorTotal));
            $('#kpiBestSalesSubtitle').text(vendedor.vendedor);
        },
        error: function(err) {
            console.error('Erro ao carregar KPI do melhor vendedor', err);
            $('#kpiBestSales').text('Erro');
            $('#kpiBestSalesSubtitle').text('Tente novamente');
        }
    });
}

// Chama ao carregar a página
fetchKpiBestSeller();

// Atualiza quando algum filtro mudar
['filtroAno', 'filtroMes', 'filtroUnidade', 'filtroVendedor', 'filtroSituacao'].forEach(id => {
    const select = document.getElementById(id);
    if (select) {
        select.addEventListener('change', fetchKpiBestSeller);
    }
});



  // Requisição para o KPI de Fonte de Captação
      
async function fetchKpiFonte() {
    const ano = document.getElementById('filtroAno').value;
    const mes = document.getElementById('filtroMes').value;
    const unidade = document.getElementById('filtroUnidade').value;
    const vendedor = document.getElementById('filtroVendedor').value;
    const situacao = document.getElementById('filtroSituacao').value;

    const query = new URLSearchParams({ ano, mes, unidade, vendedor, situacao }).toString();

    try {
        const response = await fetch(`api/relatorios/kpis/fonte?${query}`);
        if (!response.ok) throw new Error('Network response was not ok');

        const data = await response.json();
        const fonte = data.fonteMaisVendida.fonte;
        const porcentagem = data.fonteMaisVendida.porcentagem;

        document.getElementById('kpiBestSource').textContent = fonte;
        document.getElementById('kpiBestSourceSubtitle').textContent = `Gerou ${porcentagem}% dos leads`;
    } catch (error) {
        console.error('Problema na operação de fetch:', error);
        document.getElementById('kpiBestSource').textContent = 'Erro';
        document.getElementById('kpiBestSourceSubtitle').textContent = 'Tente novamente';
    }
}

// Chama ao carregar a página
fetchKpiFonte();

// Atualiza quando algum filtro mudar
['filtroAno', 'filtroMes', 'filtroUnidade', 'filtroVendedor', 'filtroSituacao'].forEach(id => {
    const select = document.getElementById(id);
    if (select) {
        select.addEventListener('change', fetchKpiFonte);
    }
});


 // Requisição para o KPI de Cliente que Mais Comprou
    function fetchKpiBestClient() {
    const ano = $('#filtroAno').val();
    const mes = $('#filtroMes').val();
    const cliente = $('#filtroCliente').val();
    const vendedor = $('#filtroVendedor').val();
    const unidade = $('#filtroUnidade').val();
    const situacao = $('#filtroSituacao').val();

    const query = $.param({ ano, mes, cliente, vendedor, unidade, situacao });

    fetch('api/relatorios/kpis/cliente?' + query)
        .then(response => {
            if (!response.ok) {
                throw new Error('Erro na resposta da rede.');
            }
            return response.json();
        })
        .then(data => {
            const kpiBestClient = document.getElementById('kpiBestClient');
            const kpiBestClientDetails = document.getElementById('kpiBestClientDetails');

            const clienteNome = data.clienteMaisComprou.cliente;
            const totalCompras = data.clienteMaisComprou.totalCompras;
            const valorTotal = parseFloat(data.clienteMaisComprou.valorTotal);

            const formatter = new Intl.NumberFormat('pt-BR', {
                style: 'currency',
                currency: 'BRL',
                minimumFractionDigits: 2
            });

            kpiBestClient.textContent = clienteNome;
            kpiBestClientDetails.textContent = `${totalCompras} compras, ${formatter.format(valorTotal)}`;
        })
        .catch(error => {
            console.error('Erro ao carregar KPI do cliente que mais comprou:', error);
            document.getElementById('kpiBestClient').textContent = 'Erro';
            document.getElementById('kpiBestClientDetails').textContent = 'Dados não disponíveis';
        });
}

// Chama ao carregar a página
fetchKpiBestClient();

// Atualiza quando algum filtro mudar
['filtroAno', 'filtroMes', 'filtroUnidade', 'filtroVendedor', 'filtroSituacao', 'filtroCliente'].forEach(id => {
    const select = document.getElementById(id);
    if (select) {
        select.addEventListener('change', fetchKpiBestClient);
    }
});

//vendas por pacote
 
 
let salesByUnitChart, salesByPackageChart, packageSalesBySellerChart, salesByMonthChart, salesByYearChart;
let yearlySalesChart1, yearlySalesChart2;

// Variáveis simuladas (dados de exemplo)
const salesData = {
    monthly: {
        labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
        data: {
            '2023': [80000, 85000, 90000, 75000, 95000, 100000, 110000, 105000, 120000, 115000, 130000, 140000],
            '2024': [100000, 110000, 105000, 120000, 115000, 130000, 140000, 135000, 150000, 145000, 160000, 170000],
            '2025': [120000, 125000, 130000, 140000, 135000, 150000, 160000, 0, 0, 0, 0, 0]
        }
    },
    packagesBySeller: {
        sellers: ['Laiz', 'Yasmine', 'Graça', 'Larissa'],
        data: [35, 42, 30, 48],
        backgroundColor: 'rgba(255, 105, 180, 0.7)',
        borderColor: 'rgba(255, 105, 180, 1)'
    },
    sellerPerformance: [
        { name: 'Laiz', photo: 'https://media.licdn.com/dms/image/D4D03AQHUKiuia01m4g/profile-displayphoto-shrink_100_100/B4DZO8dH4QGgAY-/0/1734033575553?e=2147483647&v=beta&t=A4hj8F4hA4PL90JQcwKPqtVrY_YifF8uUIhhTeAwgfE', totalSold: 1250000, packagesSold: 35, newClients: 15, additionalsSold: 45 },
        { name: 'Yasmine', photo: 'https://media.licdn.com/dms/image/D4D03AQHUKiuia01m4g/profile-displayphoto-shrink_100_100/B4DZO8dH4QGgAY-/0/1734033575553?e=2147483647&v=beta&t=A4hj8F4hA4PL90JQcwKPqtVrY_YifF8uUIhhTeAwgfE', totalSold: 13000000, packagesSold: 42, newClients: 18, additionalsSold: 32 },
        { name: 'Graça', photo: 'https://media.licdn.com/dms/image/D4D03AQHUKiuia01m4g/profile-displayphoto-shrink_100_100/B4DZO8dH4QGgAY-/0/1734033575553?e=2147483647&v=beta&t=A4hj8F4hA4PL90JQcwKPqtVrY_YifF8uUIhhTeAwgfE', totalSold: 110000, packagesSold: 30, newClients: 12, additionalsSold: 40 },
        { name: 'Larissa', photo: 'https://media.licdn.com/dms/image/D4D03AQHUKiuia01m4g/profile-displayphoto-shrink_100_100/B4DZO8dH4QGgAY-/0/1734033575553?e=2147483647&v=beta&t=A4hj8F4hA4PL90JQcwKPqtVrY_YifF8uUIhhTeAwgfE', totalSold: 14500000, packagesSold: 48, newClients: 20, additionalsSold: 36 }
    ]
};

// ------------------ FUNÇÕES ------------------



// Formata valores monetários
function formatCurrency(value) {
    return value.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
}

// Renderiza os cards de vendedores
function renderSellerCards(sellers) {
    const container = document.getElementById('sellerCardsContainer');
    container.innerHTML = '';

    if (!Array.isArray(sellers)) {
        console.error('renderSellerCards: sellers não é um array', sellers);
        container.innerHTML = '<p>Não há dados de vendedores disponíveis.</p>';
        return;
    }

    sellers.forEach(seller => {
        // Define a foto do vendedor ou fallback
        const photoUrl = seller.photo || 'assets/default-avatar.png';

        container.innerHTML += `
            <div class="seller-card">
                <img src="${photoUrl}" alt="${seller.name}" class="seller-photo">
                <h6>${seller.name}</h6>
                <div class="seller-stats">
                    <div class="stat-item">
                        <span class="label">Vendas Totais:</span>
                        <span class="value money">${formatCurrency(seller.totalSold)}</span>
                    </div>
                    <div class="stat-item">
                        <span class="label">Vendas Opcionais:</span>
                        <span class="value money">${formatCurrency(seller.additionalsSold || 0)}</span>
                    </div>
                    <div class="stat-item">
                        <span class="label">Pacotes Vendidos:</span>
                        <span class="value">${seller.packagesSold}</span>
                    </div>
                    <div class="stat-item">
                        <span class="label">Novos Clientes:</span>
                        <span class="value">${seller.newClients}</span>
                    </div>
                </div>
            </div>
        `;
    });
}

// Busca os dados da API e renderiza os cards
async function fetchAndRenderSellerCards() {
    try {
        const ano = document.getElementById('filtroAno').value;
        const mes = document.getElementById('filtroMes').value;
        const unidade = document.getElementById('filtroUnidade').value;
        const vendedor = document.getElementById('filtroVendedor').value;
        const situacao = document.getElementById('filtroSituacao').value;

        const query = new URLSearchParams({ ano, mes, unidade, vendedor, situacao }).toString();

        const response = await fetch(`/api/kpi-vendas?${query}`);
        const data = await response.json();

        // Garante que sellerPerformance seja um array
        const sellers = Array.isArray(data.sellerPerformance) ? data.sellerPerformance : [];
        renderSellerCards(sellers);
    } catch (error) {
        console.error('Erro ao buscar os dados dos vendedores:', error);
        const container = document.getElementById('sellerCardsContainer');
        container.innerHTML = '<p>Não foi possível carregar os dados dos vendedores.</p>';
    }
}

// Chama a função ao carregar a página
document.addEventListener('DOMContentLoaded', () => {
    fetchAndRenderSellerCards();
});


//Grafico de vendas por vendedor
async function renderSalesBySellerChart(filters = {}) {
    try {
        // Monta query string com os filtros
        const params = new URLSearchParams(filters).toString();
        const url = 'api/vendas-totais-por-vendedor' + (params ? '?' + params : '');

        const response = await fetch(url);
        if (!response.ok) throw new Error('Erro na resposta da API');

        const result = await response.json();

        // Ordena pelo valor total
        result.sort((a,b) => b.valor_total - a.valor_total);

        const labels = result.map(r => `${r.nome_consultor.trim()} ${r.sobrenome_consultor.trim()}`);
        const dataQuantidade = result.map(r => r.quantidade);
        const dataValor = result.map(r => r.valor_total);

        const ctx = document.getElementById('packageSalesBySellerChart').getContext('2d');
        if (packageSalesBySellerChart) packageSalesBySellerChart.destroy();

        packageSalesBySellerChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels,
                datasets: [
                    {
                        label: 'Quantidade de Vendas',
                        data: dataQuantidade,
                        backgroundColor: 'rgba(255,105,180,0.7)',
                        borderColor: 'rgba(255,105,180,1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Valor Total (R$)',
                        data: dataValor,
                        backgroundColor: 'rgba(100,149,237,0.7)',
                        borderColor: 'rgba(100,149,237,1)',
                        borderWidth: 1,
                        yAxisID: 'y1'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                indexAxis: 'y',
                scales: {
                    x: {
                        beginAtZero: true,
                        title: { display: true, text: 'Quantidade' }
                    },
                    y1: {
                        position: 'right',
                        beginAtZero: true,
                        ticks: { callback: v => 'R$ ' + Number(v).toLocaleString('pt-BR') },
                        grid: { drawOnChartArea: false }
                    }
                },
                plugins: {
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        callbacks: {
                            label: function(context) {
                                const idx = context.dataIndex;
                                if(context.dataset.label === 'Quantidade de Vendas') {
                                    return `Qtd: ${dataQuantidade[idx]}`;
                                } else {
                                    return `Valor: R$ ${Number(dataValor[idx]).toLocaleString('pt-BR')}`;
                                }
                            }
                        }
                    },
                    title: { display: true, text: '' },
                    legend: { display: true }
                },
                interaction: { mode: 'nearest', axis: 'y', intersect: false }
            }
        });

    } catch(e) {
        console.error('Erro ao buscar vendas por vendedor:', e);
    }
}

// Chamada inicial sem filtros
renderSalesBySellerChart();

// Exemplo: atualizar quando algum filtro mudar
['filtroAno', 'filtroMes', 'filtroUnidade', 'filtroVendedor', 'filtroSituacao'].forEach(id => {
    const select = document.getElementById(id);
    if(select){
        select.addEventListener('change', () => {
            const filters = {
                ano: $('#filtroAno').val(),
                mes: $('#filtroMes').val(),
                unidade: $('#filtroUnidade').val(),
                vendedor: $('#filtroVendedor').val(),
                situacao: $('#filtroSituacao').val()
            };
            renderSalesBySellerChart(filters);
        });
    }
});
const filtros = ['filtroAno', 'filtroMes', 'filtroUnidade', 'filtroVendedor', 'filtroSituacao'];

filtros.forEach(id => {
    const select = document.getElementById(id);
    if(select){
        select.addEventListener('change', () => {
            fetchAndRenderSellerCards(); // atualiza os cards quando o filtro mudar
        });
    }
});

// Chama a função ao carregar a página
document.addEventListener('DOMContentLoaded', () => {
    fetchAndRenderSellerCards();
});
// Renderiza gráfico de vendas por pacote
// Certifique-se de ter importado o plugin ChartDataLabels
Chart.register(ChartDataLabels);

async function fetchSalesByPackageChart(filtros = {}) {
    try {
        const query = new URLSearchParams(filtros).toString();
        const response = await fetch('api/vendas-por-pacote?' + query);
        const data = await response.json();

        // Se não houver dados de pacotes, podemos exibir uma mensagem ou apenas não renderizar o gráfico
        if (!data.pacotes || Object.keys(data.pacotes).length === 0) {
            console.warn("Nenhum dado de pacote encontrado para os filtros selecionados.");
            // Opcional: Destruir o gráfico existente se não houver dados
            if (window.salesByPackageChart && typeof window.salesByPackageChart.destroy === 'function') {
                window.salesByPackageChart.destroy();
                window.salesByPackageChart = null; // Limpa a referência
            }
            return;
        }

        const sortedPacotes = Object.entries(data.pacotes)
            .sort(([, a], [, b]) => b.valor - a.valor)
            .slice(0, 50);

        const labels = sortedPacotes.map(([nome]) => nome);
        const values = sortedPacotes.map(([, pacote]) => pacote.valor);
        const quantities = sortedPacotes.map(([, pacote]) => pacote.quantidade);

        const ctx = document.getElementById('salesByPackageChart').getContext('2d');

        // Adiciona a verificação para garantir que o método .destroy() existe
        if (window.salesByPackageChart && typeof window.salesByPackageChart.destroy === 'function') {
            window.salesByPackageChart.destroy();
        }

        window.salesByPackageChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels,
                datasets: [{
                    data: values,
                    backgroundColor: labels.map((_, i) => `hsl(${i * 30},70%,60%)`),
                    borderColor: '#fff',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                cutout: '10%',
                plugins: {
                    legend: { position: 'right' },
                    title: {
                        display: true,
                        text: 'Vendas por Pacote',
                        font: { size: 16, weight: '600' },
                        padding: { bottom: 20 }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const idx = context.dataIndex;
                                const percent = ((context.raw / values.reduce((a, b) => a + b, 0)) * 100).toFixed(1);
                                return `${labels[idx]}: R$ ${context.raw.toLocaleString('pt-BR')} (${quantities[idx]} unidades, ${percent}%)`;
                            }
                        }
                    },
                    datalabels: {
                        color: '#fff',
                        font: { weight: 'bold', size: 12 },
                        formatter: (value, context) => {
                            const idx = context.dataIndex;
                            return `R$ ${value.toLocaleString('pt-BR')}\n(${quantities[idx]})`;
                        },
                        anchor: 'center',
                        align: 'center'
                    }
                }
            },
            plugins: [ChartDataLabels]
        });

    } catch (e) {
        console.error('Erro ao buscar vendas por pacote:', e);
    }
}

// Inicializa e atualiza ao mudar filtros
document.addEventListener('DOMContentLoaded', () => fetchSalesByPackageChart());
document.querySelectorAll('#filtroAno, #filtroMes, #filtroUnidade, #filtroVendedor, #filtroSituacao')
    .forEach(el => el.addEventListener('change', () => {
        const filtrosAtualizados = {
            ano: document.getElementById('filtroAno').value,
            mes: document.getElementById('filtroMes').value,
            unidade: document.getElementById('filtroUnidade').value,
            vendedor: document.getElementById('filtroVendedor').value,
            situacao: document.getElementById('filtroSituacao').value
        };
        fetchSalesByPackageChart(filtrosAtualizados);
    }));


// Renderiza gráfico de vendas por unidade

document.addEventListener('DOMContentLoaded', function() {
    // Referência global para o gráfico
    let salesByUnitChart;

    // Função que busca os dados e renderiza o gráfico
    async function fetchSalesByUnitChart(filtros = {}) {
        try {
            const query = new URLSearchParams(filtros).toString();
            const response = await fetch('api/vendas-por-unidade?' + query);
            const result = await response.json();

            result.sort((a, b) => parseFloat(b.totalVendas) - parseFloat(a.totalVendas));

            const labels = result.map(u => u.NOME);
            const totalVendas = result.map(u => parseFloat(u.totalVendas));
            const totalRegistros = result.map(u => parseInt(u.totalRegistros));

            const ctx = document.getElementById('salesByUnitChart').getContext('2d');
            if (salesByUnitChart && typeof salesByUnitChart.destroy === 'function') {
                salesByUnitChart.destroy();
            }

            salesByUnitChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels,
                    datasets: [
                        {
                            label: 'Valor Total (R$)',
                            data: totalVendas,
                            backgroundColor: 'rgba(54, 162, 235, 0.7)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Número de Vendas',
                            data: totalRegistros,
                            backgroundColor: 'rgba(255, 99, 132, 0.7)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    indexAxis: 'y',
                    scales: {
                        x: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Valor / Quantidade'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Unidade'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const datasetLabel = context.dataset.label || '';
                                    const value = context.raw;
                                    if (datasetLabel.includes('Valor')) {
                                        return `${datasetLabel}: R$ ${value.toLocaleString('pt-BR')}`;
                                    } else {
                                        return `${datasetLabel}: ${value}`;
                                    }
                                }
                            }
                        },
                        title: {
                            display: true,
                            text: 'Vendas por Unidade',
                            font: { size: 16 }
                        }
                    }
                }
            });

        } catch (e) {
            console.error('Erro ao buscar vendas por unidade:', e);
        }
    }

    // Função para coletar todos os filtros e atualizar o gráfico
    function updateChartWithFilters() {
        const filtros = {
            ano: document.getElementById('filtroAno').value,
            mes: document.getElementById('filtroMes').value,
            unidade: document.getElementById('filtroUnidade').value,
            vendedor: document.getElementById('filtroVendedor').value,
            situacao: document.getElementById('filtroSituacao').value
        };

        fetchSalesByUnitChart(filtros);
    }

    // Adiciona "ouvintes de evento" a cada filtro
    document.getElementById('filtroAno').addEventListener('change', updateChartWithFilters);
    document.getElementById('filtroMes').addEventListener('change', updateChartWithFilters);
    document.getElementById('filtroUnidade').addEventListener('change', updateChartWithFilters);
    document.getElementById('filtroVendedor').addEventListener('change', updateChartWithFilters);
    document.getElementById('filtroSituacao').addEventListener('change', updateChartWithFilters);

    // Chama a função pela primeira vez para carregar o gráfico inicial
    updateChartWithFilters();
});

// ... E no final do seu código JS, adicione a chamada com os filtros
document.querySelectorAll('#filtroAno, #filtroMes, #filtroUnidade, #filtroVendedor, #filtroSituacao')
    .forEach(el => el.addEventListener('change', () => {
        const filtrosAtualizados = {
            ano: document.getElementById('filtroAno').value,
            mes: document.getElementById('filtroMes').value,
            // unidade: O filtro de unidade não se aplica a este gráfico,
            // que já exibe os dados por unidade
            vendedor: document.getElementById('filtroVendedor').value,
            situacao: document.getElementById('filtroSituacao').value
        };
        fetchSalesByUnitChart(filtrosAtualizados);
    }));

document.addEventListener('DOMContentLoaded', () => {
    fetchSalesByUnitChart();
});


// Variável global do gráfico

document.addEventListener('DOMContentLoaded', function() {

    // Função que busca dados de vendas por mês
    async function fetchSalesByMonth(filtros = {}) {
        try {
            const query = new URLSearchParams(filtros).toString();
            const response = await fetch('api/vendas-mes?' + query);
            const data = await response.json();
            return data;
        } catch (e) {
            console.error('Erro ao buscar vendas por mês:', e);
            return { labels: [], valores: [], quantidades: [] };
        }
    }

    // Função para renderizar ou atualizar o gráfico de vendas por mês
    async function renderSalesByMonthChart(filtros) {
        const chartData = await fetchSalesByMonth(filtros);
        const ctx = document.getElementById('salesByMonthChart').getContext('2d');

        if (salesByMonthChart) {
            // Se o gráfico já existe, apenas atualiza os dados
            salesByMonthChart.data.labels = chartData.labels;
            salesByMonthChart.data.datasets[0].data = chartData.valores;
            salesByMonthChart.data.datasets[1].data = chartData.quantidades;
            salesByMonthChart.options.plugins.title.text = `Vendas ${filtros.ano || new Date().getFullYear()}`;
            salesByMonthChart.update();
        } else {
            // Se o gráfico não existe, cria um novo
            salesByMonthChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: chartData.labels,
                    datasets: [
                        {
                            type: 'line',
                            label: 'Valor (R$)',
                            data: chartData.valores,
                            borderColor: 'blue',
                            backgroundColor: 'rgba(100,149,237,0.2)',
                            yAxisID: 'yValor',
                            fill: true,
                            tension: 0.4,
                        },
                        {
                            type: 'bar',
                            label: 'Quantidade',
                            data: chartData.quantidades,
                            borderColor: 'green',
                            backgroundColor: 'rgba(0,255,0,0.4)',
                            yAxisID: 'yQtd',
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        yValor: {
                            type: 'linear',
                            position: 'left',
                            title: { display: true, text: 'R$' }
                        },
                        yQtd: {
                            type: 'linear',
                            position: 'right',
                            title: { display: true, text: 'Quantidade' }
                        }
                    },
                    plugins: {
                        legend: { display: true },
                        title: { display: true, text: `Vendas ${filtros.ano || new Date().getFullYear()}` }
                    }
                }
            });
        }
    }

    // Função para coletar todos os filtros e atualizar o gráfico
    function updateMonthChartWithFilters() {
        // Coleta todos os valores dos seletores de filtro
        const filtros = {
            ano: document.getElementById('filtroAno')?.value,
            mes: document.getElementById('filtroMes')?.value,
            unidade: document.getElementById('filtroUnidade')?.value,
            vendedor: document.getElementById('filtroVendedor')?.value,
            situacao: document.getElementById('filtroSituacao')?.value
        };
        // Chama a função de renderização com os filtros coletados
        renderSalesByMonthChart(filtros);
    }

    // Adiciona "ouvintes de evento" a cada filtro para atualizar o gráfico
    document.getElementById('filtroAno')?.addEventListener('change', updateMonthChartWithFilters);
    document.getElementById('filtroMes')?.addEventListener('change', updateMonthChartWithFilters);
    document.getElementById('filtroUnidade')?.addEventListener('change', updateMonthChartWithFilters);
    document.getElementById('filtroVendedor')?.addEventListener('change', updateMonthChartWithFilters);
    document.getElementById('filtroSituacao')?.addEventListener('change', updateMonthChartWithFilters);

    // Chama a função pela primeira vez ao carregar a página
    updateMonthChartWithFilters();
});


// Esta função busca os dados de vendas por ano com base nos filtros

async function fetchSalesByYear() {
    try {
        // 🔹 Captura os filtros
        const ano = document.getElementById('filtroAno').value || '';
        const mes = document.getElementById('filtroMes').value || '';
        const unidade = document.getElementById('filtroUnidade').value || '';
        const vendedor = document.getElementById('filtroVendedor').value || '';
        const situacao = document.getElementById('filtroSituacao').value || '';

        const params = new URLSearchParams({ ano, mes, unidade, vendedor, situacao });

        // 🔹 Usa a rota correta do seu api.php
        const url = `api/vendas-ano?${params.toString()}`;
        const response = await fetch(url);
        const data = await response.json();

        if (!data || !data.labels) {
            console.warn("⚠️ Nenhum dado retornado da API.");
            return;
        }

        const labels = data.labels;
        const valores = data.valores;
        const quantidades = data.quantidades ?? []; // garante que não dá erro se API não retornar

        const ctx = document.getElementById('salesByYearChart').getContext('2d');

        // Destroi gráfico antigo antes de recriar
        if (salesByYearChart) salesByYearChart.destroy();

        salesByYearChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels,
                datasets: [{
                    label: 'Vendas por Ano',
                    data: valores,
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    title: {
                        display: true,
                        text: '',
                        font: { size: 16 }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const idx = context.dataIndex;
                                const qtd = quantidades[idx] ?? 0;
                                return `${labels[idx]}: R$ ${context.raw.toLocaleString('pt-BR')} (${qtd} vendas)`;
                            }
                        }
                    },
                    datalabels: {
                        anchor: 'end',
                        align: 'end',
                        color: '#000',
                        font: { weight: 'bold', size: 12 },
                        formatter: (value, context) => {
                            const idx = context.dataIndex;
                            const qtd = quantidades[idx] ?? 0;
                            return `R$ ${value.toLocaleString('pt-BR')}\n(${qtd})`;
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'R$ ' + value.toLocaleString('pt-BR');
                            }
                        }
                    }
                }
            },
            plugins: [ChartDataLabels]
        });

    } catch (e) {
        console.error('❌ Erro ao buscar vendas por ano:', e);
    }
}

// 🔹 Atualiza gráfico ao mudar qualquer filtro
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('#filtroAno, #filtroMes, #filtroUnidade, #filtroVendedor, #filtroSituacao')
        .forEach(el => el.addEventListener('change', fetchSalesByYear));

    // Inicializa o gráfico já com valores padrões
    fetchSalesByYear();
});



// ------------------ DOM CONTENT LOADED ------------------
document.addEventListener('DOMContentLoaded', async function() {
    renderSellerCards(salesData);          // Cards de vendedores
    renderPackageSalesBySellerChart(salesData); // Pacotes por vendedor
    await fetchSalesByPackageChart();       // Gráfico de vendas por pacote
    await fetchSalesByUnitChart();          // Gráfico de vendas por unidade
    renderStaticCharts();                   // Gráficos fixos (mensal e anual)

    // Event listeners para selecionar ano nos comparativos
    document.getElementById('yearSelect1').addEventListener('change', updateYearlyComparisonCharts);
    document.getElementById('yearSelect2').addEventListener('change', updateYearlyComparisonCharts);
});


// 2️⃣ Inicialização e escuta dos filtros
document.addEventListener('DOMContentLoaded', () => {
    const filtros = {
        ano: document.getElementById('filtroAno').value,
        mes: document.getElementById('filtroMes').value,
        unidade: document.getElementById('filtroUnidade').value,
        vendedor: document.getElementById('filtroVendedor').value,
        situacao: document.getElementById('filtroSituacao').value
    };

    // Renderiza o gráfico na primeira carga
    renderSalesBySellerChart(filtros);

    // Atualiza o gráfico ao mudar qualquer filtro
    document.querySelectorAll('#filtroAno, #filtroMes, #filtroUnidade, #filtroVendedor, #filtroSituacao')
        .forEach(el => el.addEventListener('change', () => {
            const filtrosAtualizados = {
                ano: document.getElementById('filtroAno').value,
                mes: document.getElementById('filtroMes').value,
                unidade: document.getElementById('filtroUnidade').value,
                vendedor: document.getElementById('filtroVendedor').value,
                situacao: document.getElementById('filtroSituacao').value
            };
            renderSalesBySellerChart(filtrosAtualizados);
        }));
});



// ==================== FUNÇÃO: CARREGAR ANOS ====================
async function carregarAnos() {
    try {
        const res = await fetch('api/anos-vendas');
        const anos = await res.json();

        const select1 = document.getElementById('yearSelect1');
        const select2 = document.getElementById('yearSelect2');

        // Limpa selects
        select1.innerHTML = '';
        select2.innerHTML = '';

        anos.forEach((ano, idx) => {
            const opt1 = new Option(ano, ano, idx === 0, idx === 0);
            const opt2 = new Option(ano, ano, idx === 1, idx === 1);

            select1.add(opt1);
            select2.add(opt2);
        });

    } catch (err) {
        console.error('Erro ao carregar anos:', err);
    }
}

// ==================== FUNÇÃO: ALTERAR TIPO ====================
async function updateYearlyComparisonCharts() {
    const year1 = document.getElementById('yearSelect1').value;
    const year2 = document.getElementById('yearSelect2').value;

    const filtros = {
        unidade: document.getElementById('filtroUnidade').value,
        vendedor: document.getElementById('filtroVendedor').value,
        situacao: document.getElementById('filtroSituacao').value
    };

    const params1 = new URLSearchParams({ ano: year1, ...filtros }).toString();
    const params2 = new URLSearchParams({ ano: year2, ...filtros }).toString();

    const [res1, res2] = await Promise.all([
        fetch(`api/vendas-ano-comparativo?${params1}`).then(r => r.json()),
        fetch(`api/vendas-ano-comparativo?${params2}`).then(r => r.json())
    ]);

    // Função para criar/atualizar chart
    function createOrUpdateChart(chartRef, ctx, labels, valores, quantidades, year, color, title) {
        if (!chartRef) {
            return new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            type: 'bar',
                            label: `Quantidade ${year}`,
                            data: quantidades,
                            backgroundColor: color.bar,
                            yAxisID: 'y1'
                        },
                        {
                            type: 'line',
                            label: `Valor ${year} (R$)`,
                            data: valores,
                            borderColor: color.line,
                            backgroundColor: color.line,
                            yAxisID: 'y2',
                            tension: 0.4,
                            fill: false,
                            borderWidth: 2,
                            pointRadius: 3
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false },
                    plugins: {
                        legend: { position: 'top' },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    if(context.dataset.type === 'line'){
                                        return `R$ ${context.raw.toLocaleString('pt-BR')}`;
                                    } else {
                                        return `${context.raw} vendas`;
                                    }
                                }
                            }
                        },
                        title: {
                            display: true,
                            text: title
                        }
                    },
                    scales: {
                        y1: {
                            type: 'linear',
                            position: 'left',
                            ticks: { callback: v => v }
                        },
                        y2: {
                            type: 'linear',
                            position: 'right',
                            grid: { drawOnChartArea: false },
                            ticks: { callback: v => 'R$ ' + v.toLocaleString('pt-BR') }
                        }
                    }
                }
            });
        } else {
            chartRef.data.labels = labels;
            chartRef.data.datasets[0].data = quantidades;
            chartRef.data.datasets[0].label = `Quantidade ${year}`;
            chartRef.data.datasets[1].data = valores;
            chartRef.data.datasets[1].label = `Valor ${year} (R$)`;
            chartRef.update();
            return chartRef;
        }
    }

    const ctx1 = document.getElementById('yearlySalesChart1').getContext('2d');
    const ctx2 = document.getElementById('yearlySalesChart2').getContext('2d');

    yearlySalesChart1 = createOrUpdateChart(yearlySalesChart1, ctx1, res1.labels, res1.valores, res1.quantidades, year1, {
        bar: 'rgba(54, 162, 235, 0.6)',
        line: 'rgba(54, 162, 235, 1)'
    }, `Vendas Anuais (${year1})`);

    yearlySalesChart2 = createOrUpdateChart(yearlySalesChart2, ctx2, res2.labels, res2.valores, res2.quantidades, year2, {
        bar: 'rgba(255, 99, 132, 0.6)',
        line: 'rgba(255, 99, 132, 1)'
    }, `Vendas Anuais (${year2})`);
}

// Event listeners para filtros e seleção de ano
document.addEventListener('DOMContentLoaded', async () => {
    await carregarAnos();
    await updateYearlyComparisonCharts();

    // Adiciona event listeners aos seletores de ano para atualizar o gráfico
    const yearSelect1 = document.getElementById('yearSelect1');
    const yearSelect2 = document.getElementById('yearSelect2');
    
    if (yearSelect1) {
      yearSelect1.addEventListener('change', updateYearlyComparisonCharts);
    }
    if (yearSelect2) {
      yearSelect2.addEventListener('change', updateYearlyComparisonCharts);
    }
});


</script>

</body>
</html>
      