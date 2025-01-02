<?php


include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $legajo = $_POST['legajo'];
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Encripta la contraseña
    $role = 'admin';

    try {
        // Inserta el nuevo administrador en la base de datos
        $stmt = $pdo->prepare("INSERT INTO users (legajo, nombre, correo, password, role) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$legajo, $nombre, $correo, $password, $role]);

        $_SESSION['notification'] = [
            'message' => 'Nuevo administrador creado con éxito.',
            'type' => 'success'
        ];
    } catch (Exception $e) {
        $_SESSION['notification'] = [
            'message' => 'Error al crear el administrador: ' . $e->getMessage(),
            'type' => 'error'
        ];
    }
    header('Location: add_admin.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Administrador</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../scripts/sweetalert-notifications.js"></script>
</head>
<body>
<?php include '../includes/header.php'; ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-body">
                    <h2 class="text-center mb-4">Agregar Nuevo Administrador</h2>
                    <form method="post">
                        <!-- Legajo -->
                        <div class="mb-3">
                            <label for="legajo" class="form-label">Legajo</label>
                            <input type="text" name="legajo" id="legajo" class="form-control" placeholder="Ingresa el legajo del administrador" required>
                        </div>
                        <!-- Nombre -->
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ingresa el nombre del administrador" required>
                        </div>
                        <!-- Correo -->
                        <div class="mb-3">
                            <label for="correo" class="form-label">Correo</label>
                            <input type="email" name="correo" id="correo" class="form-control" placeholder="Ingresa el correo del administrador" required>
                        </div>
                        <!-- Contraseña -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Ingresa una contraseña" required>
                        </div>
                        <!-- Botón Agregar -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">Crear Administrador</button>
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

<?php include '../includes/footer.php'; ?>
</body>
</html>
