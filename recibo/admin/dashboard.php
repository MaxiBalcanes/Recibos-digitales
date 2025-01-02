<?php
include '../includes/auth.php';
checkAuth('admin');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin</title>
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
        <a class="navbar-brand" href="#"><i class="bi bi-house-door"></i> Sistema de Recibos Digitales - Panel Admin</a>
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
    <h1 class="text-center mb-4">Bienvenido, Admin</h1>
    <div class="row justify-content-center">
        <div class="col-md-4 mb-3">
            <a href="upload.php" class="btn btn-primary w-100">
                <i class="bi bi-file-earmark-arrow-up"></i> Subir PDF
            </a>
        </div>
        <div class="col-md-4 mb-3">
            <a href="manage_users.php" class="btn btn-secondary w-100">
                <i class="bi bi-people"></i> Gestionar Usuarios
            </a>
        </div>
    </div>
</div>
</body>
</html>
