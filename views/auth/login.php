<?php require_once __DIR__ . '/../../config/config.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Ryan's Travels - Administración</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .login-container {
            max-width: 600px;
            margin: 0 auto;
        }
        .card {
            border-radius: 1rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border: none;
        }
        .card-header {
            background: #003366;
            color: white;
            border-radius: 1rem 1rem 0 0 !important;
            text-align: center;
            padding: 2rem 1rem 1rem;
        }
        .btn-primary {
            background: #003366;
            border-color: #003366;
        }
        .btn-primary:hover {
            background: #00509e;
            border-color: #00509e;
        }
        .form-control:focus {
            border-color: #003366;
            box-shadow: 0 0 0 0.2rem rgba(0, 51, 102, 0.25);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0"><i class="bi bi-shield-lock"></i> Ryan's Travels</h3>
                    <p class="mb-0 mt-2">Panel de Administración</p>
                </div>
                <div class="card-body p-4">
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle"></i> <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['success'])): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle"></i> <?= $_SESSION['success']; unset($_SESSION['success']); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="<?= BASE_URL ?>controllers/AuthController.php?action=process_login">
<div class="mb-3">
                            <label for="email" class="form-label">
                                <i class="bi bi-envelope"></i> Email
                            </label>
                            <input type="email" class="form-control" name="email" id="email" required autofocus 
                                   placeholder="Ingrese su email">
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">
                                <i class="bi bi-lock"></i> Contraseña
                            </label>
                            <input type="password" class="form-control" name="password" id="password" required 
                                   placeholder="Ingrese su contraseña">
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" name="remember" id="remember">
                            <label class="form-check-label" for="remember">
                                Recordarme por 30 días
                            </label>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2">
                            <i class="bi bi-box-arrow-in-right"></i> Ingresar al Sistema
                        </button>
                    </form>
                </div>
                <div class="card-footer text-center text-muted">
                    <small>&copy; <?= date('Y') ?> Ryan's Travels. Todos los derechos reservados.</small>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>