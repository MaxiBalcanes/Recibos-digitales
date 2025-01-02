<?php
include '../includes/auth.php';
include '../includes/db.php'; // Archivo que conecta a la base de datos
checkAuth('member');

$results = [];
$message = '';
$messageType = '';

// Obtener el ID de usuario autenticado y su legajo
$user_id = $_SESSION['user_id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $user_id) {
    $month = $_POST['month'] ?? '';
    $year = $_POST['year'] ?? '';

    try {
        // Consulta con JOIN
        $query = "
            SELECT pdf_files.nombre, pdf_files.uploaded_at, pdf_files.ruta
            FROM pdf_files
            INNER JOIN users ON pdf_files.nombre LIKE CONCAT('%', users.legajo, '%')
            WHERE users.id = :user_id
        ";

        $params = ['user_id' => $user_id];

        // Agregar filtros de fecha si se proporcionan
        if (!empty($month)) {
            $query .= " AND MONTH(pdf_files.uploaded_at) = :month";
            $params['month'] = $month;
        }
        if (!empty($year)) {
            $query .= " AND YEAR(pdf_files.uploaded_at) = :year";
            $params['year'] = $year;
        }

        // Ordenar por fecha de subida
        $query .= " ORDER BY pdf_files.uploaded_at DESC";

        // Preparar y ejecutar consulta
        $stmt = $pdo->prepare($query);
        $stmt->execute($params);

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($results)) {
            $message = 'No se encontraron recibos de sueldo que coincidan con los filtros proporcionados.';
            $messageType = 'warning';
        } else {
            $message = 'Recibos encontrados con éxito.';
            $messageType = 'success';
        }
    } catch (Exception $e) {
        $message = 'Error al consultar la base de datos: ' . $e->getMessage();
        $messageType = 'error';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar PDF</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        body {
            background: url('https://wallpapers.com/images/hd/light-color-background-u5ajon1xr9puabyq.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: Arial, sans-serif;
        }
        .card {
            background-color: rgba(255, 255, 255, 0.85);
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
        <a class="navbar-brand" href="#"><i class="bi bi-house-door"></i> Sistema de Recibos Digitales</a>
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
    <h2 class="text-center">Buscar Recibos de Sueldo</h2>
    <form method="post">
        <!-- Filtro de Fecha -->
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="month" class="form-label">Mes (opcional)</label>
                <select name="month" id="month" class="form-select">
                <option value="" selected>Selecciona un mes</option>
                    <option value="1">Enero</option>
                    <option value="2">Febrero</option>
                    <option value="3">Marzo</option>
                    <option value="4">Abril</option>
                    <option value="5">Mayo</option>
                    <option value="6">Junio</option>
                    <option value="7">Julio</option>
                    <option value="8">Agosto</option>
                    <option value="9">Septiembre</option>
                    <option value="10">Octubre</option>
                    <option value="11">Noviembre</option>
                    <option value="12">Diciembre</option>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="year" class="form-label">Año (opcional)</label>
                <input type="number" name="year" id="year" class="form-control" placeholder="Ingresa el año" min="2000" max="<?= date('Y'); ?>" value="<?= htmlspecialchars($year); ?>">
            </div>
        </div>
        <button type="submit" class="btn btn-primary w-100"><i class="bi bi-search"></i> Buscar</button>
    </form>

    <!-- Mostrar Resultados -->
    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($results)): ?>
        <div class="mt-4">
            <h4 class="text-center">Resultados de la búsqueda</h4>
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>Nombre del Recibo</th>
                        <th>Fecha de Subida</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $file): ?>
                        <tr>
                            <td><?= htmlspecialchars($file['nombre']); ?></td>
                            <td><?= htmlspecialchars($file['uploaded_at']); ?></td>
                            <td>
                                <a href="<?= htmlspecialchars($file['ruta']); ?>" class="btn btn-info btn-sm" target="_blank">
                                    <i class="bi bi-eye"></i> Ver
                                </a>
                                <a href="<?= htmlspecialchars($file['ruta']); ?>" download class="btn btn-success btn-sm">
                                    <i class="bi bi-download"></i> Descargar
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php if (!empty($message)): ?>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        Swal.fire({
            text: "<?= htmlspecialchars($message); ?>",
            icon: "<?= htmlspecialchars($messageType); ?>",
            confirmButtonText: 'Aceptar'
        });
    });
</script>
<?php endif; ?>
</body>
</html>
