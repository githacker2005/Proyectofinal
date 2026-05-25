<?php

require_once "auth.php";
require_once "../config/database.php";

$servicios = [];
$error = "";
$success = "";

if (isset($_GET["mensaje"])) {
    if ($_GET["mensaje"] === "creado") {
        $success = "Servicio creado correctamente.";
    } elseif ($_GET["mensaje"] === "editado") {
        $success = "Servicio actualizado correctamente.";
    } elseif ($_GET["mensaje"] === "eliminado") {
        $success = "Servicio eliminado correctamente.";
    } elseif ($_GET["mensaje"] === "error_eliminar") {
        $error = "No se ha podido eliminar el servicio.";
    }
}

try {
    $sql = "SELECT * FROM servicios ORDER BY fecha_creacion DESC";
    $stmt = $pdo->query($sql);
    $servicios = $stmt->fetchAll();

} catch (PDOException $e) {
    $error = "No se han podido cargar los servicios.";
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servicios - Panel de administración</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="admin-body">

    <header class="admin-header">
        <div>
            <h2>Panel de administración</h2>
            <p>Gestión de servicios de relocation</p>
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
            <span class="hero-label">Servicios</span>
            <h1>Servicios registrados</h1>
            <p>
                En esta sección se muestran los servicios de relocation registrados en la base de datos.
                Más adelante se podrán crear, editar y eliminar desde este panel.
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
                <div>
                    <h2>Listado de servicios</h2>
                    <p>Total: <?= count($servicios) ?> servicios</p>
                </div>

                <a href="crear_servicio.php" class="table-action-link">
                    Crear servicio
                </a>
            </div>
            <?php if (empty($servicios)): ?>
                <div class="empty-message">
                    <p>No hay servicios registrados todavía.</p>
                </div>
            <?php else: ?>

                <div class="table-wrapper">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Título</th>
                                <th>Descripción</th>
                                <th>Precio estimado</th>
                                <th>Duración</th>
                                <th>Activo</th>
                                <th>Fecha</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($servicios as $servicio): ?>
                                <tr>
                                    <td><?= htmlspecialchars($servicio["titulo"]) ?></td>
                                    <td><?= htmlspecialchars($servicio["descripcion"]) ?></td>
                                    <td>
                                        <?php if ($servicio["precio_estimado"] !== null): ?>
                                            <?= htmlspecialchars($servicio["precio_estimado"]) ?> €
                                        <?php else: ?>
                                            No definido
                                        <?php endif; ?>
                                    </td>
                                    <td><?= htmlspecialchars($servicio["duracion"] ?? "No definida") ?></td>
                                    <td>
                                        <span class="status-badge">
                                            <?= $servicio["activo"] ? "Sí" : "No" ?>
                                        </span>
                                    </td>
                                    <td><?= htmlspecialchars($servicio["fecha_creacion"]) ?></td>
                                    <td>
                                        <div class="table-actions">
                                            <a href="editar_servicio.php?id=<?= htmlspecialchars($servicio["id"]) ?>" class="table-action-link">
                                                Editar
                                            </a>

                                            <a 
                                                href="eliminar_servicio.php?id=<?= htmlspecialchars($servicio["id"]) ?>" 
                                                class="table-action-link delete-link"
                                                onclick="return confirm('¿Seguro que quieres eliminar este servicio?');"
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