<?php
include '../includes/auth.php';
checkAuth('admin');
include '../includes/db.php';

// Validar que se reciba un ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['notification'] = [
        'message' => 'ID de usuario no proporcionado.',
        'type' => 'error'
    ];
    header('Location: manage_users.php');
    exit;
}

$user_id = $_GET['id'];
$message = '';
$messageType = '';

// Obtener los datos del usuario
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    $_SESSION['notification'] = [
        'message' => 'Usuario no encontrado.',
        'type' => 'error'
    ];
    header('Location: manage_users.php');
    exit;
}

// Actualizar los datos del usuario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $legajo = $_POST['legajo'] ?? '';
    $nombre = $_POST['nombre'] ?? '';
    $correo = $_POST['correo'] ?? '';
    $role = $_POST['role'] ?? '';

    try {
        $stmt = $pdo->prepare("UPDATE users SET legajo = ?, nombre = ?, correo = ?, role = ? WHERE id = ?");
        $stmt->execute([$legajo, $nombre, $correo, $role, $user_id]);

        $_SESSION['notification'] = [
            'message' => 'Usuario actualizado con éxito.',
            'type' => 'success'
        ];
        header('Location: manage_users.php');
        exit;
    } catch (Exception $e) {
        $message = 'Error al actualizar usuario: ' . $e->getMessage();
        $messageType = 'error';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
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
        <a class="navbar-brand" href="manage_users.php"><i class="bi bi-arrow-left"></i> Volver</a>
    </div>
</nav>
<div class="container mt-5">
    <h2 class="text-center mb-4">Editar Usuario</h2>
    <?php if ($message): ?>
        <div class="alert alert-<?= $messageType; ?>"><?= htmlspecialchars($message); ?></div>
    <?php endif; ?>
    <form method="post" class="card p-4 shadow-lg">
        <div class="mb-3">
            <label for="legajo" class="form-label">Legajo</label>
            <input type="text" name="legajo" id="legajo" class="form-control" value="<?= htmlspecialchars($user['legajo']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="form-control" value="<?= htmlspecialchars($user['nombre']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="correo" class="form-label">Correo</label>
            <input type="email" name="correo" id="correo" class="form-control" value="<?= htmlspecialchars($user['correo']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Rol</label>
            <select name="role" id="role" class="form-select" required>
                <option value="member" <?= $user['role'] === 'member' ? 'selected' : ''; ?>>Miembro</option>
                <option value="editor" <?= $user['role'] === 'editor' ? 'selected' : ''; ?>>Editor</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary w-100"><i class="bi bi-save"></i> Guardar Cambios</button>
    </form>
</div>
</body>
</html>
