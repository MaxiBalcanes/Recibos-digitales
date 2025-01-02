<?php
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['pdf_files'])) {
    $files = $_FILES['pdf_files'];
    $uploadDirectory = '../uploads/';
    $successCount = 0;
    $errorCount = 0;

    // Iterar sobre los archivos subidos
    for ($i = 0; $i < count($files['name']); $i++) {
        $nombre = $files['name'][$i];
        $tmp_name = $files['tmp_name'][$i];
        $ruta = $uploadDirectory . $nombre;

        // Verificar si el archivo es un PDF
        $fileType = mime_content_type($tmp_name);
        if ($fileType !== 'application/pdf') {
            $errorCount++;
            continue; // Saltar archivos no válidos
        }

        // Mover el archivo al directorio de subida
        if (move_uploaded_file($tmp_name, $ruta)) {
            // Insertar registro en la base de datos
            $stmt = $pdo->prepare("INSERT INTO pdf_files (nombre, ruta) VALUES (?, ?)");
            $stmt->execute([$nombre, $ruta]);
            $successCount++;
        } else {
            $errorCount++;
        }
    }

    // Mensaje final
    echo "Archivos subidos exitosamente: $successCount<br>";
    echo "Archivos con errores: $errorCount<br>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir PDFs</title>
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
<div class="container">
    <h2 class="my-4">Subir Recibos PDF</h2>
    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="pdf_files" class="form-label">Archivos PDF</label>
            <input type="file" name="pdf_files[]" id="pdf_files" class="form-control" multiple required>
        </div>
        <button type="submit" class="btn btn-primary"><i class="bi bi-upload"></i> Subir</button>
    </form>
</div>
</body>
</html>
