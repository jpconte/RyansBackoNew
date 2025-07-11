<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Configuraciones generales
define('BASE_URL', 'https://c2831151.ferozo.com/backo_new/');
define('SITE_NAME', "Ryan's Travel - Administración");

// Zona horaria
date_default_timezone_set('America/Argentina/Buenos_Aires');

// Función para redireccionar
function redirect($url) {
    // Si la URL no es absoluta, la completa con BASE_URL
    if (strpos($url, 'http') !== 0) {
        $url = BASE_URL . ltrim($url, '/');
    }
    header("Location: " . $url);
    exit();
}

// Función para verificar si el usuario está logueado
function isLoggedIn() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

// Función para verificar permisos
function hasPermission($required_role = null) {
    if (!isLoggedIn()) {
        return false;
    }
    if ($required_role === null) {
        return true;
    }
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === $required_role;
}

// Función para obtener el usuario actual
function getCurrentUser() {
    if (isLoggedIn()) {
        return [
            'id' => $_SESSION['user_id'],
            'nombre' => $_SESSION['user_name'],
            'email' => $_SESSION['user_email'],
            'role' => $_SESSION['user_role']
        ];
    }
    return null;
}
?>