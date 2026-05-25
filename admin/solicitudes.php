<?php

require_once "auth.php";
require_once "../config/database.php";

$solicitudes = [];
$error = "";
$success = "";

if (isset($_GET["mensaje"])) {
    if ($_GET["mensaje"] === "eliminada") {
        $success = "Solicitud eliminada correctamente.";
    } elseif ($_GET["mensaje"] === "error_eliminar") {
        $error = "No se ha podido eliminar la solicitud.";
    }
}

try {
    $sql = "SELECT * FROM solicitudes ORDER BY fecha_creacion DESC";
    $stmt = $pdo->query($sql);
    $solicitudes = $stmt->fetchAll();

} catch (PDOException $e) {
    $error = "No se han podido cargar las solicitudes.";
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitudes - Panel de administración</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="admin-body">

    <header class="admin-header">
        <div>
            <h2>Panel de administración</h2>
            <p>Gestión de solicitudes de clientes</p>
        </div>

        <nav>
            <ul>
                <li><a href="dashboard.php">Inicio panel</a></li>
                <li><a href="solicitudes.php">Solicitudes</a></li>
                 <li><a href="servicios.php">Servicios</a></li>
                <li><a href="../index.php">Ver web</a></li>
                <li><a href="logout.php">Cerrar sesión</a></li>
            </ul>
        </nav>
    </header>

    <main class="admin-main">
        <section class="page-hero">
            <span class="hero-label">Solicitudes</span>
            <h1>Solicitudes recibidas</h1>
            <p>
                En esta sección se muestran las solicitudes enviadas por los clientes
                desde el formulario de contacto de la web.
            </p>
        </section>

        <?php if (!empty($error)): ?>
            <div class="form-message error-message-general">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <div class="form-message success-message">
                <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>

        <section class="admin-table-section">
            <div class="admin-section-header">
                <h2>Listado de solicitudes</h2>
                <p>Total: <?= count($solicitudes) ?> solicitudes</p>
            </div>

            <?php if (empty($solicitudes)): ?>
                <div class="empty-message">
                    <p>No hay solicitudes registradas todavía.</p>
                </div>
            <?php else: ?>

                <div class="table-wrapper">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Cliente</th>
                                <th>Email</th>
                                <th>Teléfono</th>
                                <th>Destino</th>
                                <th>Servicio</th>
                                <th>Estado</th>
                                <th>Fecha</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($solicitudes as $solicitud): ?>
                                <tr>
                                    <td><?= htmlspecialchars($solicitud["nombre"]) ?></td>
                                    <td><?= htmlspecialchars($solicitud["email"]) ?></td>
                                    <td><?= htmlspecialchars($solicitud["telefono"]) ?></td>
                                    <td><?= htmlspecialchars($solicitud["ciudad_destino"]) ?></td>
                                    <td><?= htmlspecialchars($solicitud["tipo_servicio"]) ?></td>
                                    <td>
                                        <span class="status-badge">
                                            <?= htmlspecialchars($solicitud["estado"]) ?>
                                        </span>
                                    </td>
                                    <td><?= htmlspecialchars($solicitud["fecha_creacion"]) ?></td>
                                    <td>
                                        <div class="table-actions">
                                            <a href="editar_solicitud.php?id=<?= htmlspecialchars($solicitud["id"]) ?>" class="table-action-link">
                                            Editar
                                            </a>

                                            <a 
                                                href="eliminar_solicitud.php?id=<?= htmlspecialchars($solicitud["id"]) ?>" 
                                                class="table-action-link delete-link"
                                                onclick="return confirm('¿Seguro que quieres eliminar esta solicitud?');"
                                            >
                                                Eliminar
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            <?php endif; ?>
        </section>
    </main>

</body>
</html>