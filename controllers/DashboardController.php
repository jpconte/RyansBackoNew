<?php
require_once __DIR__ . '/../config/config.php';

// Verificar si está logueado
if (!isLoggedIn()) {
    redirect('login.php');
}

// Aquí podrías agregar lógica para cargar datos dinámicos del dashboard

// Incluir la vista del dashboard
include __DIR__ . '/../views/dashboard/index.php';
?>