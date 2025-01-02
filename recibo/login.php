<?php
session_start();
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $legajo = $_POST['legajo'];
    $password = $_POST['password'];

    // Consultar el usuario por legajo
    $stmt = $pdo->prepare("SELECT * FROM users WHERE legajo = ?");
    $stmt->execute([$legajo]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Validar credenciales
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['nombre'] = $user['nombre'];
        $_SESSION['legajo'] = $user['legajo']; // Aseguramos guardar el legajo en la sesión

        // Redirigir según el rol
        if ($user['role'] === 'admin') {
            header('Location: admin/dashboard.php');
        } else {
            header('Location: user/search.php');
        }
        exit;
    } else {
        $_SESSION['notification'] = [
            'message' => 'Legajo o contraseña incorrectos.',
            'type' => 'error'
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="scripts/sweetalert-notifications.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        body {
            background: url('https://wallpapers.com/images/hd/light-color-background-u5ajon1xr9puabyq.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: Arial, sans-serif;
        }
        .card {
            background-color: rgba(255, 255, 255, 0.85); /* Fondo translúcido */
            border-radius: 15px;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="login.php"><i class="bi bi-house-door"></i> Sistema de Recibos Digitales</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
            </ul>
        </div>
    </div>
</nav>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-body">
                <div class="text-center mb-4">
                <img src="img/logo1.png" alt="Logo" class="mb-3" style="width: 100px; height: auto;">
                    </div>
                    <h2 class="text-center mb-4">Iniciar Sesión</h2>
                    <form method="post">
                        <!-- Input de Legajo -->
                        <div class="mb-3">
                            <label for="legajo" class="form-label">Legajo</label>
                            <input type="text" name="legajo" id="legajo" class="form-control" placeholder="Ingresa tu legajo" required>
                        </div>
                        <!-- Input de Contraseña con Mostrar/Ocultar -->
                        <div class="mb-3 position-relative">
                            <label for="password" class="form-label">Contraseña</label>
                            <div class="input-group">
                                <input type="password" name="password" id="password" class="form-control" placeholder="Ingresa tu contraseña" required>
                                <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                    <i class="bi bi-eye-slash" id="togglePasswordIcon"></i>
                                </button>
                            </div>
                        </div>
                        <!-- Botón de Iniciar Sesión -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">Iniciar Sesión</button>
                        </div>
                    </form>
                    <!-- Enlace a Registro -->
                    <p class="text-center mt-3">
                        ¿No tienes una cuenta? <a href="register.php">Regístrate</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
if (isset($_SESSION['notification'])):
?>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            showNotification(
                "<?= $_SESSION['notification']['message']; ?>",
                "<?= $_SESSION['notification']['type']; ?>"
            );
        });
    </script>
<?php
unset($_SESSION['notification']);
endif;
?>

<script>
    // Mostrar/Ocultar Contraseña
    const togglePasswordButton = document.getElementById('togglePassword');
    const passwordField = document.getElementById('password');
    const passwordIcon = document.getElementById('togglePasswordIcon');

    togglePasswordButton.addEventListener('click', () => {
        const isPasswordVisible = passwordField.type === 'text';
        passwordField.type = isPasswordVisible ? 'password' : 'text';
        passwordIcon.className = isPasswordVisible ? 'bi bi-eye-slash' : 'bi bi-eye';
    });
</script>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

<?php include 'includes/footer.php'; ?>
</body>
</html>