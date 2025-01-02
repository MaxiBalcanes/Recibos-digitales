<?php
include '../includes/auth.php';
checkAuth('admin');
include '../includes/db.php';

// Eliminar usuario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user'])) {
    $user_id = $_POST['delete_user'];

    try {
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        $_SESSION['notification'] = [
            'message' => 'Usuario eliminado con éxito.',
            'type' => 'success'
        ];
    } catch (Exception $e) {
        $_SESSION['notification'] = [
            'message' => 'Error al eliminar usuario: ' . $e->getMessage(),
            'type' => 'error'
        ];
    }
    header('Location: manage_users.php');
    exit;
}

// Obtener usuarios
$stmt = $pdo->prepare("SELECT id, legajo, nombre, correo, role FROM users WHERE role != 'admin'");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Usuarios</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../scripts/sweetalert-notifications.js"></script>
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
        <a class="navbar-brand" href="dashboard.php"><i class="bi bi-house-door"></i> Sistema de Recibos Digitales</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                <a class="nav-link" href="../logout.php"><i class="bi bi-box-arrow-right"></i> Cerrar Sesión</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="container mt-4">
    <h2 class="text-center">Gestionar Usuarios</h2>
    <table class="table table-striped table-hover mt-4">
        <thead>
            <tr>
                <th>ID</th>
                <th>Legajo</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $user['id']; ?></td>
                    <td><?= $user['legajo']; ?></td>
                    <td><?= $user['nombre']; ?></td>
                    <td><?= $user['correo']; ?></td>
                    <td>
                        <!-- Botón Editar -->
                        <a href="edit_user.php?id=<?= $user['id']; ?>" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil"></i> Editar
                        </a>

                        <!-- Botón Eliminar -->
                        <form method="post" class="d-inline" onsubmit="return confirmDelete(this);">
                            <input type="hidden" name="delete_user" value="<?= $user['id']; ?>">
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="bi bi-trash"></i> Eliminar
                            </button>
                        </form>
                    </td>

                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script>
function confirmDelete(form) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción no se puede deshacer.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
    return false;
}
</script>
<?php include '../includes/footer.php'; ?>
</body>
</html>
