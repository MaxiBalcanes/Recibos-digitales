<?php
session_start();
include 'includes/db.php';

// Verificar si el usuario está autenticado y es admin
$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $legajo = $_POST['legajo'];
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Encripta la contraseña

    // Solo los admins pueden asignar el rol "admin"
    $role = ($isAdmin && $_POST['role'] === 'admin') ? 'admin' : 'member';

    try {
        // Insertar usuario en la base de datos
        $stmt = $pdo->prepare("INSERT INTO users (legajo, nombre, correo, password, role) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$legajo, $nombre, $correo, $password, $role]);

        $_SESSION['notification'] = [
            'message' => 'Usuario registrado con éxito.',
            'type' => 'success'
        ];
        header('Location: login.php');
        exit;
    } catch (Exception $e) {
        $_SESSION['notification'] = [
            'message' => 'Error al registrar el usuario: ' . $e->getMessage(),
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
    <title>Registro</title>
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
                    <h2 class="text-center mb-4">Registro de Usuario</h2>
                    <form method="post">
                        <!-- Legajo -->
                        <div class="mb-3">
                            <label for="legajo" class="form-label">Legajo</label>
                            <input type="text" name="legajo" id="legajo" class="form-control" placeholder="Ingresa tu legajo" required>
                        </div>
                        <!-- Nombre -->
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ingresa tu nombre" required>
                        </div>
                        <!-- Correo -->
                        <div class="mb-3">
                            <label for="correo" class="form-label">Correo</label>
                            <input type="email" name="correo" id="correo" class="form-control" placeholder="Ingresa tu correo" required>
                        </div>
                        <!-- Contraseña -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Ingresa tu contraseña" required>
                        </div>
                        <!-- Seleccionar Rol -->
                        <div class="mb-3">
                            <label for="role" class="form-label">Rol</label>
                            <select name="role" id="role" class="form-select" required>
                                <option value="member" selected>Member</option>
                                <?php if ($isAdmin): // Mostrar opción Admin solo si es admin ?>
                                    <option value="admin">Admin</option>
                                <?php endif; ?>
                            </select>
                        </div>
                        <!-- Botón Registrar -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">Registrar</button>
                        </div>
                    </form>
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

<?php include 'includes/footer.php'; ?>
</body>
</html>
