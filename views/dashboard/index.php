<?php
require_once __DIR__ . '/../../config/config.php';
if (!isLoggedIn()) redirect('login.php');
$user = getCurrentUser();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Ryan's Travels - Administración</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { 
            background: #f8f9fa; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .sidebar { 
            min-height: 100vh; 
            background: linear-gradient(180deg, #003366 0%, #00509e 100%);
            color: #fff; 
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }
        .sidebar .nav-link { 
            color: rgba(255,255,255,0.8); 
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            margin: 0.25rem 0.5rem;
            transition: all 0.3s ease;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active { 
            background: rgba(255,255,255,0.1);
            color: #fff;
            transform: translateX(5px);
        }
        .sidebar .nav-link i {
            width: 20px;
            margin-right: 10px;
        }
        .main-content {
            padding: 2rem;
        }
        .card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 1rem 1rem 0 0 !important;
            border: none;
        }
        .stats-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 1rem;
        }
        .stats-number {
            font-size: 2.5rem;
            font-weight: bold;
        }
        .chart-container {
            position: relative;
            height: 300px;
        }
        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
        }
        .alert-security {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
            color: white;
            border: none;
        }
        .alert-success-custom {
            background: linear-gradient(135deg, #00b894 0%, #00a085 100%);
            color: white;
            border: none;
        }
    </style>
</head>
<body>
<div class="container-fluid p-0">
    <div class="row g-0">
        <!-- Sidebar -->
        <nav class="col-md-3 col-lg-2 sidebar">
            <div class="p-3">
                <div class="text-center mb-4">
                    <h4 class="navbar-brand mb-0">
                        <i class="bi bi-airplane"></i> Ryan's Travels
                    </h4>
                    <small class="text-light opacity-75">Panel de Administración</small>
                </div>

                <hr class="text-light opacity-25">

                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="dashboard.php">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#contenidoMenu">
                            <i class="bi bi-globe"></i> Gestión de Contenido
                            <i class="bi bi-chevron-down float-end"></i>
                        </a>
                        <div class="collapse" id="contenidoMenu">
                            <ul class="nav flex-column ms-3">
                                <li><a class="nav-link py-1" href="#"><i class="bi bi-play-circle"></i> Video Home</a></li>
                                <li><a class="nav-link py-1" href="#"><i class="bi bi-star"></i> Productos Destacados</a></li>
                                <li><a class="nav-link py-1" href="#"><i class="bi bi-calendar-event"></i> Eventos</a></li>
                                <li><a class="nav-link py-1" href="#"><i class="bi bi-info-circle"></i> Nosotros</a></li>
                                <li><a class="nav-link py-1" href="#"><i class="bi bi-people"></i> Nuestro Equipo</a></li>
                                <li><a class="nav-link py-1" href="#"><i class="bi bi-building"></i> Oficinas</a></li>
                                <li><a class="nav-link py-1" href="#"><i class="bi bi-envelope"></i> Contacto</a></li>
                                <li><a class="nav-link py-1" href="#"><i class="bi bi-share"></i> Redes Sociales</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="bi bi-briefcase"></i> Productos Turísticos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="bi bi-building"></i> Gestión de Agencias
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="bi bi-cash-stack"></i> Tarifas y Tarifarios
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="bi bi-gear"></i> Configuración General
                        </a>
                    </li>
                </ul>

                <hr class="text-light opacity-25 mt-4">

                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="controllers/AuthController.php?action=logout">
                            <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="col-md-9 col-lg-10 main-content">
            <!-- Header -->
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
                <h1 class="h2"><i class="bi bi-speedometer2"></i> Dashboard</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i> <?= htmlspecialchars($user['nombre']) ?>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#"><i class="bi bi-person"></i> Mi Perfil</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-gear"></i> Configuración</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="controllers/AuthController.php?action=logout">
                                <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
                            </a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <div class="card stats-card">
                        <div class="card-body text-center">
                            <i class="bi bi-graph-up display-4 mb-2"></i>
                            <h5>Ventas del Mes</h5>
                            <div class="stats-number">$125,430</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card alert-success-custom">
                        <div class="card-body text-center">
                            <i class="bi bi-eye display-4 mb-2"></i>
                            <h5>Visitas Web</h5>
                            <div class="stats-number">12,345</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stats-card">
                        <div class="card-body text-center">
                            <i class="bi bi-people display-4 mb-2"></i>
                            <h5>Clientes Activos</h5>
                            <div class="stats-number">1,234</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card alert-security">
                        <div class="card-body text-center">
                            <i class="bi bi-shield-exclamation display-4 mb-2"></i>
                            <h5>Alertas Seguridad</h5>
                            <div class="stats-number">0</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="bi bi-bar-chart"></i> Ventas por Período</h5>
                        </div>
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="ventasPeriodo"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="bi bi-geo-alt"></i> Ventas por Destino</h5>
                        </div>
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="ventasDestino"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4 mt-2">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="bi bi-building"></i> Ventas por Agencia</h5>
                        </div>
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="ventasAgencia"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="bi bi-clock-history"></i> Actividad Reciente</h5>
                        </div>
                        <div class="card-body">
                            <div class="list-group list-group-flush">
                                <div class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Nueva reserva</div>
                                        Bariloche - 3 días
                                    </div>
                                    <small>hace 2h</small>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Pago confirmado</div>
                                        Iguazú - 2 días
                                    </div>
                                    <small>hace 4h</small>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Nueva consulta</div>
                                        Mendoza - 5 días
                                    </div>
                                    <small>hace 6h</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Configuración de Chart.js
Chart.defaults.font.family = "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif";
Chart.defaults.color = '#666';

// Gráfico de Ventas por Período
const ctxPeriodo = document.getElementById('ventasPeriodo').getContext('2d');
const ventasPeriodo = new Chart(ctxPeriodo, {
    type: 'line',
    data: {
        labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio'],
        datasets: [{
            label: 'Ventas ($)',
            data: [45000, 52000, 48000, 61000, 55000, 67000],
            borderColor: '#003366',
            backgroundColor: 'rgba(0, 51, 102, 0.1)',
            borderWidth: 3,
            fill: true,
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return '$' + value.toLocaleString();
                    }
                }
            }
        }
    }
});

// Gráfico de Ventas por Destino
const ctxDestino = document.getElementById('ventasDestino').getContext('2d');
const ventasDestino = new Chart(ctxDestino, {
    type: 'bar',
    data: {
        labels: ['Bariloche', 'Iguazú', 'Salta', 'Mendoza', 'Ushuaia'],
        datasets: [{
            label: 'Ventas',
            data: [85, 120, 65, 95, 45],
            backgroundColor: [
                '#003366',
                '#00509e',
                '#0066cc',
                '#3399ff',
                '#66b3ff'
            ],
            borderRadius: 8
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Gráfico de Ventas por Agencia
const ctxAgencia = document.getElementById('ventasAgencia').getContext('2d');
const ventasAgencia = new Chart(ctxAgencia, {
    type: 'doughnut',
    data: {
        labels: ['Agencia Central', 'Agencia Norte', 'Agencia Sur', 'Online'],
        datasets: [{
            data: [35, 25, 20, 20],
            backgroundColor: [
                '#003366',
                '#00509e',
                '#0066cc',
                '#3399ff'
            ],
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});
</script>
</body>
</html>