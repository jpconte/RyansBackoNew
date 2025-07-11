<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/User.php';

class AuthController {
    private $db;
    private $user;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->user = new User($this->db);
    }

    // Mostrar formulario de login
    public function showLogin() {
        // Si ya está logueado, redirigir al dashboard
        if (isLoggedIn()) {
            redirect('dashboard.php');
        }

        include __DIR__ . '/../views/auth/login.php';
    }

    // Procesar login
    public function processLogin() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $remember = isset($_POST['remember']);

            // Validaciones básicas
            if (empty($email) || empty($password)) {
                $_SESSION['error'] = 'Por favor complete todos los campos';
                redirect('login.php');
                return;
            }

            // Intentar autenticar
            if ($this->user->authenticate($email, $password)) {
                // Login exitoso
                $_SESSION['user_id'] = $this->user->id;
                $_SESSION['user_name'] = $this->user->nombre;
                $_SESSION['user_email'] = $this->user->email;
                $_SESSION['user_role'] = $this->user->role;
                $_SESSION['user_tipo_id'] = $this->user->tipo_usuario_id;

                // Si marcó "recordarme", establecer cookie
                if ($remember) {
                    $token = bin2hex(random_bytes(32));
                    setcookie('remember_token', $token, time() + (86400 * 30), '/'); // 30 días
                    // Aquí podrías guardar el token en la base de datos
                }

                $_SESSION['success'] = 'Bienvenido, ' . $this->user->nombre;
                redirect('dashboard.php');
            } else {
                $_SESSION['error'] = 'Credenciales incorrectas';
                redirect('login.php');
            }
        }
    }

    // Cerrar sesión
    public function logout() {
        // Limpiar todas las variables de sesión
        $_SESSION = array();

        // Destruir la cookie de sesión
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Limpiar cookie de recordar
        if (isset($_COOKIE['remember_token'])) {
            setcookie('remember_token', '', time() - 3600, '/');
        }

        // Destruir la sesión
        session_destroy();

        redirect('login.php');
    }
}

// Manejar las acciones
$action = $_GET['action'] ?? 'login';
$authController = new AuthController();

switch ($action) {
    case 'login':
        $authController->showLogin();
        break;
    case 'process_login':
        $authController->processLogin();
        break;
    case 'logout':
        $authController->logout();
        break;
    default:
        $authController->showLogin();
        break;
}
?>