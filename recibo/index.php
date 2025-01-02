<?php
session_start();
if (isset($_SESSION['user_id'])) {
    $role = $_SESSION['role'];
    if ($role === 'admin') {
        header('Location: admin/dashboard.php');
    } else {
        header('Location: user/search.php');
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio - PDF System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
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
<?php include 'includes/header.php'; ?>
<div class="container mt-5">
    <div class="text-center">
        <h1>Bienvenido a Recibos Digitales</h1>
        <p class="mt-3">Gestiona y consulta recibos de sueldo de forma fácil y rápida.</p>
        <div class="mt-4">
            <a href="login.php" class="btn btn-primary btn-lg me-2">Iniciar Sesión</a>
            <a href="register.php" class="btn btn-secondary btn-lg">Registrarse</a>
        </div>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
</body>
</html>
