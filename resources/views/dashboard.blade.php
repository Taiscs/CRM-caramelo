<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grupo Caramelo CRM - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;900&display=swap" rel="stylesheet">
    <style>
        /* Variáveis CSS para Cores */
        :root {
            --primary-blue: #6495ED; 
            --light-blue: #ADD8E6; 
            --primary-pink: #FF69B4; 
            --light-pink: #FFB6C1; 
            --white: #FFFFFF;
            --text-dark: #333;
            --text-muted: #6c757d;
            --border-light: #e0e0e0;
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

      /* Cards de Métricas Principais */
/* Cards de Métricas Principais */
.carousel-container {
    position: relative;
    overflow: hidden;
    padding: 0 40px; /* espaço para as setas */
}

.metric-row {
    display: flex;
    overflow-x: auto;
    gap: 15px;
    scroll-behavior: smooth;
}

/* Estilo do card */
.metric-card {
    background: #fff;
    border-radius: 12px;
    padding: 20px;
    text-align: center;
    box-shadow: 0 4px 10px rgba(0,0,0,0.08);
    min-width: 220px;
    flex: 0 0 auto;
    transition: transform 0.2s ease-in-out;
}
.metric-card:hover {
    transform: translateY(-4px);
}

/* Ícones */
.metric-card .icon {
    font-size: 2rem;
    color: #4a6cf7; /* cor do ícone */
    margin-bottom: 10px;
}

/* Valores */
.metric-card .value {
    font-size: 1.6rem;
    font-weight: bold;
}

/* Labels */
.metric-card .label {
    font-size: 0.9rem;
    color: #555;
}

/* Botões do carrossel */
.carousel-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: #fff;
    border: none;
    font-size: 1.8rem;
    cursor: pointer;
    padding: 8px 12px;
    border-radius: 50%;
    box-shadow: 0 2px 6px rgba(0,0,0,0.2);
    z-index: 10;
    transition: background 0.2s;
}
.carousel-btn:hover {
    background: #f0f0f0;
}
.carousel-btn.left { left: 5px; }
.carousel-btn.right { right: 5px; }



/* Forçar alinhamento horizontal */
.row {
    display: flex;
    flex-wrap: nowrap; /* Impede quebra de linha */
    overflow-x: auto; /* Scroll se não couber na tela */
    gap: 10px;
}

        /* Seções de Gráficos e Conteúdo */
        .card-section {
            background-color: var(--white);
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0,0,0,0.1);
            padding: 30px;
            margin-bottom: 30px;
        }
        .card-section h4 {
            color: var(--text-dark);
            margin-bottom: 25px;
            font-weight: 600;
            border-bottom: 1px solid var(--border-light);
            padding-bottom: 15px;
        }
        .card-section canvas {
            max-width: 100%;
            max-height: 250px;
            height: auto;
        }

        /* Seção de Analistas */
        .analyst-highlight-card {
            background-color: var(--primary-blue);
            color: var(--white);
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
            padding: 30px;
            text-align: center;
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
        }
        .analyst-highlight-card::before {
            content: "\f091";
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            position: absolute;
            top: 20px;
            right: 25px;
            font-size: 3rem;
            color: rgba(255,255,255,0.2);
            transform: rotate(15deg);
        }

        .analyst-highlight-card img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid var(--primary-pink);
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        .analyst-highlight-card h5 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 10px;
            color: var(--white);
        }
        .analyst-highlight-card .conversion-rate {
            font-size: 3.5rem;
            font-weight: 900;
            color: var(--primary-pink);
            line-height: 1;
            margin-bottom: 15px;
        }
        .analyst-highlight-card .metrics-small {
            font-size: 0.95rem;
            opacity: 0.9;
        }
        .analyst-highlight-card .metrics-small span {
            font-weight: 600;
            margin: 0 5px;
        }

        /* Lista de Outros Analistas */
        .analyst-list-item {
            display: flex;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px dashed var(--border-light);
        }
        .analyst-list-item:last-child {
            border-bottom: none;
        }
        .analyst-list-item img {
            width: 55px;
            height: 55px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 15px;
            border: 2px solid var(--primary-blue);
        }
        .analyst-list-info h6 {
            margin-bottom: 2px;
            color: var(--primary-blue);
            font-weight: 600;
        }
        .analyst-list-info small {
            color: var(--text-muted);
            font-size: 0.9rem;
        }
        .analyst-list-info small span {
            font-weight: bold;
        }
        .analyst-list-info small .conversion-val {
            color: var(--primary-pink);
        }

        /* Tarefas */
        .task-list-item {
            display: flex;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px dotted var(--border-light);
        }
        .task-list-item:last-child {
            border-bottom: none;
        }
        .task-list-item i {
            margin-right: 10px;
            color: var(--primary-blue);
            font-size: 1.1rem;
        }
        .task-content {
            flex-grow: 1;
        }
        .task-content .task-title {
            font-weight: 500;
            color: var(--text-dark);
        }
        .task-content .task-date {
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        .logo-circle {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            object-fit: cover;
            background-color: white;
            border: 2px solid var(--primary-pink);
        }

        /* Estilo para o Indicador de Carregamento */
        .loading-spinner {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 250px;
            text-align: center;
            color: var(--text-muted);
        }
        .loading-spinner p {
            margin-top: 10px;
        }
        .spinner-border {
            width: 3rem;
            height: 3rem;
            color: var(--primary-blue);
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
    <h2 class="mb-4 text-dark ps-2">Bem-vindo(a) ao Dashboard!</h2>

    <div class="carousel-container">
        <!-- Botão Esquerda -->
        <button class="carousel-btn left" onclick="scrollMetrics(-1)">‹</button>

        <!-- Área de Cards -->
        <div class="metric-row" id="metricRow">

                       <!-- Total de Conversas -->
            <div class="metric-card">
                <div class="icon"><i class="fas fa-comments"></i></div>
                <div class="value text-blue">{{ $total_conversas }}</div>
                <div class="label">Total de Conversas Atvas</div>
            </div>

           <!-- Aguardando Resposta -->
            <div class="metric-card">
                <div class="icon"><i class="fas fa-hourglass-half"></i></div>
                <div class="value text-blue">{{ $total_aguardando_resposta }}</div>
                <div class="label">Aguardando Resposta</div>
            </div>

            <!-- Mensagens não lidas -->
            <div class="metric-card">
                <div class="icon"><i class="fas fa-envelope"></i></div>
                <div class="value text-red">{{ $total_unread_messages }}</div>
                <div class="label">Mensagens Não Lidas</div>
            </div>

 
 
              <div class="metric-card">
                <div class="icon"><i class="fas fa-users"></i></div>
                <div class="value text-blue">{{ $total_clientes }}</div>
                <div class="label">Total de Clientes</div>
            </div>

            <!-- Novos Leads -->
            <div class="metric-card">
                <div class="icon"><i class="fas fa-user-plus"></i></div>
                <div class="value text-pink">{{ $novos_leads }}</div>
                <div class="label">Novos Leads (Mês)</div>
            </div>

            <!-- Taxa de Conversão -->
            <div class="metric-card">
                <div class="icon"><i class="fas fa-percentage"></i></div>
                <div class="value text-blue">{{ $taxa_conversao_formatada }}</div>
                <div class="label">Taxa de Conversão Geral</div>
            </div>

         

            <!-- Vendas Fechadas -->
            <div class="metric-card">  
                <div class="icon"><i class="fas fa-shopping-cart"></i></div>
                <div class="value text-pink">{{ $vendas_fechadas }}</div>
                <div class="label">Vendas</div>
            </div>

            <!-- Provável Comissão -->
            <div class="metric-card">
                <div class="icon"><i class="fas fa-coins"></i></div>
                <div class="value text-pink"></div>
                <div class="label">Provável Comissão</div>
            </div>
        </div>

        <!-- Botão Direita -->
        <button class="carousel-btn right" onclick="scrollMetrics(1)">›</button>
    </div>
</div>


  


<div class="row">
<div class="col-lg-6">
    <div class="card-section">
        <h4>Clientes: Novos vs. Recorrentes</h4>

        <!-- Filtro de ano dentro da mesma card-section -->
        <div class="mb-3">
            <label for="anoFiltro">Ano:</label>
            <select id="anoFiltro" class="form-control">
                <option></option> <!-- opção para todos os anos -->
                 @for ($i = date('Y'); $i >= date('Y') - 5; $i--)
                    <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>
        </div>

        <canvas id="clientGrowthChart"></canvas>
    </div>
</div>

            
            <div class="col-lg-3">
                <div class="card-section">
                    <h4>Leads por Fonte</h4>
                
                    <!-- Indicador de carregamento para o gráfico de Leads -->
                    <div id="leadsLoading" class="loading-spinner">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p>Carregando dados...</p>
                    </div>
                    <canvas id="leadsSourceChart"></canvas>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card-section">
                    <h4>Funil de Vendas</h4>
                    <canvas id="salesFunnelChart"></canvas>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="card-section">
                    <h4>Analista Destaque</h4>
                    <div class="analyst-highlight-card mb-4">
                        <img src="https://media.licdn.com/dms/image/v2/D4D03AQHUKiuia01m4g/profile-displayphoto-shrink_100_100/B4DZO8dH4QGgAY-/0/1734033575553?e=2147483647&v=beta&t=A4hj8F4hA4PL90JQcwKPqtVrY_YifF8uUIhhTeAwgfE" alt="Graça Dias">
                        <h5>Graça dias</h5>
                        <div class="conversion-rate">25.3%</div>
                        <div class="metrics-small">
                            <span>Leads: 92</span> | <span>Vendas: 23</span>
                        </div>
                    </div>

                    <h4>Outros Analistas</h4>
                    <div class="list-group list-group-flush">
                        <div class="analyst-list-item">
                            <img src="https://media.licdn.com/dms/image/v2/D4D03AQHUKiuia01m4g/profile-displayphoto-shrink_100_100/B4DZO8dH4QGgAY-/0/1734033575553?e=2147483647&v=beta&t=A4hj8F4hA4PL90JQcwKPqtVrY_YifF8uUIhhTeAwgfE" alt="Carlos Eduardo">
                            <div class="analyst-list-info">
                                <h6>Laiz Azeredo</h6>
                                <small>Conversão: <span class="conversion-val">18.5%</span> | Vendas: 12</small>
                            </div>
                        </div>
                        <div class="analyst-list-item">
                            <img src="https://media.licdn.com/dms/image/v2/D4D03AQHUKiuia01m4g/profile-displayphoto-shrink_100_100/B4DZO8dH4QGgAY-/0/1734033575553?e=2147483647&v=beta&t=A4hj8F4hA4PL90JQcwKPqtVrY_YifF8uUIhhTeAwgfE" alt="Mariana Oliveira">
                            <div class="analyst-list-info">
                                <h6>Yasminie</h6>
                                <small>Conversão: <span class="conversion-val">22.1%</span> | Vendas: 18</small>
                            </div>
                        </div>
                         <div class="analyst-list-item">
                            <img src="https://media.licdn.com/dms/image/v2/D4D03AQHUKiuia01m4g/profile-displayphoto-shrink_100_100/B4DZO8dH4QGgAY-/0/1734033575553?e=2147483647&v=beta&t=A4hj8F4hA4PL90JQcwKPqtVrY_YifF8uUIhhTeAwgfE" alt="Roberto Santos">
                            <div class="analyst-list-info">
                                <h6>Larissa</h6>
                                <small>Conversão: <span class="conversion-val">16.0%</span> | Vendas: 9</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card-section">
                    <h4>Próximas Tarefas e Lembretes</h4>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="task-list-item">
                                <i class="fas fa-phone-volume"></i>
                                <div class="task-content">
                                    <div class="task-title">Ligar para João Silva</div>
                                    <div class="task-date">08/Jul/2025 - 10:00</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="task-list-item">
                                <i class="fas fa-calendar-check"></i>
                                <div class="task-content">
                                    <div class="task-title">Reunião com Cliente ABC</div>
                                    <div class="task-date">09/Jul/2025 - 14:30</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="task-list-item">
                                <i class="fas fa-envelope"></i>
                                <div class="task-content">
                                    <div class="task-title">Enviar proposta para Maria Souza</div>
                                    <div class="task-date">09/Jul/2025 - 16:00</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="task-list-item">
                                <i class="fas fa-tasks"></i>
                                <div class="task-content">
                                    <div class="task-title">Organizar leads da Campanha Verão</div>
                                    <div class="task-date">10/Jul/2025 - 09:00</div>
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
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="https://yt3.googleusercontent.com/MvJPZt3TigRQuXM98mcKNyz1exQrPPY2FJdCVCOOnzcgGRo7Nr5g-mVsgMPHmOrOTgGpl-_O0g=s900-c-k-c0x00ffffff-no-rj" alt="Logo" class="logo-circle me-2">
                <span><span style="color: var(--primary-pink);"></span></span>
            </a>

            <p class="text-muted mt-2 mb-0">&copy; 2025 Mundo Caramelo CRM. Todos os direitos reservados.</p>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
 // ---Cards ---

 function scrollMetrics(direction) {
    const row = document.getElementById("metricRow");
    const scrollAmount = 250; // pixels por clique
    row.scrollBy({ left: direction * scrollAmount, behavior: 'smooth' });
}



        // --- Dados e Configurações dos Gráficos ---

        // 1. Gráfico de Clientes Novos vs. Recorrentes (Linha)
let clientGrowthChart;

function carregarGrafico(ano) {
    fetch(`/api/graficos/clientes-novos-vs-recorrentes?ano=${ano}`)
        .then(res => res.json())
        .then(data => {
            if(clientGrowthChart) clientGrowthChart.destroy();

            clientGrowthChart = new Chart(document.getElementById('clientGrowthChart'), {
                type: 'line',
                data: {
                    labels: data.labels,
                    datasets: [
                        {
                            label: 'Novos Clientes',
                            data: data.novos_clientes,
                            borderColor: 'var(--primary-pink)',
                            backgroundColor: 'rgba(255, 105, 180, 0.2)',
                            fill: true,
                            tension: 0.4
                        },
                        {
                            label: 'Clientes Recorrentes',
                            data: data.recorrentes,
                            borderColor: 'var(--primary-blue)',
                            backgroundColor: 'rgba(100, 149, 237, 0.2)',
                            fill: true,
                            tension: 0.4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Nº de Clientes'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'bottom',
                        }
                    }
                }
            });
        })
        .catch(err => console.error("Erro ao carregar gráfico:", err));
}

// Inicializa gráfico com ano atual
const anoFiltro = document.getElementById('anoFiltro');
carregarGrafico(anoFiltro.value);

// Atualiza gráfico ao mudar o select
anoFiltro.addEventListener('change', () => {
    carregarGrafico(anoFiltro.value);
});


// 2. Gráfico de Leads por Fonte (Rosca - Donut)

// Define a URL da API usando Blade, variável separada para o gráfico
window.leadsApiUrlChart = "{{ secure_url('api/leads-por-fonte') }}";

const leadsSourceChart = document.getElementById('leadsSourceChart');
const leadsLoading = document.getElementById('leadsLoading');

async function fetchLeadsData() {
    if (!leadsSourceChart || !leadsLoading) return;

    // Mostrar carregando
    leadsLoading.style.display = 'flex';
    leadsSourceChart.style.display = 'none';

    try {
        // Usa a URL exclusiva do gráfico
        const response = await fetch(window.leadsApiUrlChart);

        if (!response.ok) {
            throw new Error(`Erro de rede: ${response.status}`);
        }

        const rawData = await response.json();
        const labels = rawData.map(item => item.fonte);
        const data = rawData.map(item => item.total);

        const backgroundColors = ['#FF6384','#36A2EB','#8A2BE2','#FFD700','#FF4500','#4682B4'];

        const chartData = {
            labels,
            datasets: [{
                data,
                backgroundColor: backgroundColors.slice(0, labels.length),
                hoverOffset: 10
            }]
        };

        const ctx = leadsSourceChart.getContext('2d');

        // Destrói o gráfico antigo antes de criar um novo
        if (window.leadsChartInstance) window.leadsChartInstance.destroy();

        window.leadsChartInstance = new Chart(ctx, {
            type: 'doughnut',
            data: chartData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });

        leadsSourceChart.style.display = 'block';
    } catch (error) {
        console.error("Erro ao buscar os dados do gráfico:", error);
    } finally {
        leadsLoading.style.display = 'none';
    }
}

document.addEventListener('DOMContentLoaded', fetchLeadsData);


        // 3. Gráfico de Funil de Vendas (Barras Horizontais Empilhadas para Simular Funil)
        const salesFunnelCtx = document.getElementById('salesFunnelChart').getContext('2d');
        new Chart(salesFunnelCtx, {
            type: 'bar',
            data: {
                labels: ['Leads', 'Qualificados', 'Proposta', 'Negociação', 'Fechados'],
                datasets: [{
                    label: 'Número de Leads',
                    data: [300, 200, 150, 100, 50],
                    backgroundColor: [
                        'rgba(100, 149, 237, 0.8)',
                        'rgba(100, 149, 237, 0.7)',
                        'rgba(100, 149, 237, 0.6)',
                        'rgba(255, 105, 180, 0.7)',
                        'rgba(255, 105, 180, 0.8)'
                    ],
                    borderColor: [
                        'var(--primary-blue)',
                        'var(--primary-blue)',
                        'var(--primary-blue)',
                        'var(--primary-pink)',
                        'var(--primary-pink)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Quantidade'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.label + ': ' + context.parsed.x;
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
  

