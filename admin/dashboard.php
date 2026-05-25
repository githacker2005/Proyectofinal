<?php

require_once "auth.php";
require_once "../config/database.php";

$totalSolicitudes = 0;
$totalServicios = 0;
$solicitudesPendientes = 0;

try {
    $stmt = $pdo->query("SELECT COUNT(*) AS total FROM solicitudes");
    $totalSolicitudes = $stmt->fetch()["total"];

    $stmt = $pdo->query("SELECT COUNT(*) AS total FROM servicios");
    $totalServicios = $stmt->fetch()["total"];

    $stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM solicitudes WHERE estado = :estado");
    $stmt->execute([
        ":estado" => "Pendiente"
    ]);
    $solicitudesPendientes = $stmt->fetch()["total"];

} catch (PDOException $e) {
    $error = "No se han podido cargar los datos del panel.";
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de administración - Relocation Services</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="admin-body">

    <header class="admin-header">
        <div>
            <h2>Panel de administración</h2>
            <p>Bienvenido/a, <?= htmlspecialchars($_SESSION["admin_nombre"]) ?></p>
        </div>

        <nav>
            <ul>
                <li><a href="dashboard.php">Inicio panel</a></li>
                <li><a href="../index.php">Ver web</a></li>
                <li><a href="logout.php">Cerrar sesión</a></li>
            </ul>
        </nav>
    </header>

    <main class="admin-main">
        <section class="page-hero">
            <span class="hero-label">Administración</span>
            <h1>Resumen general</h1>
            <p>
                Desde este panel se gestionarán las solicitudes de clientes y los servicios
                ofrecidos por la empresa.
            </p>
        </section>

        <?php if (!empty($error)): ?>
            <div class="form-message error-message-general">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <section class="admin-stats-grid">
            <article class="admin-stat-card">
                <span><?= $totalSolicitudes ?></span>
                <h3>Solicitudes totales</h3>
                <p>Solicitudes recibidas desde el formulario de contacto.</p>
            </article>

            <article class="admin-stat-card">
                <span><?= $solicitudesPendientes ?></span>
                <h3>Solicitudes pendientes</h3>
                <p>Solicitudes que todavía no han sido gestionadas.</p>
            </article>

            <article class="admin-stat-card">
                <span><?= $totalServicios ?></span>
                <h3>Servicios registrados</h3>
                <p>Servicios disponibles en la base de datos.</p>
            </article>
        </section>

        <section class="admin-actions">
            <h2>Próximas funciones del panel</h2>

            <div class="cards-grid">
                <article>
                    <h3>Gestión de solicitudes</h3>
                    <p>Consultar, editar y eliminar solicitudes de clientes.</p>
                </article>

                <article>
                    <h3>Gestión de servicios</h3>
                    <p>Crear, modificar y eliminar servicios de relocation.</p>
                </article>

                <article>
                    <h3>Seguimiento interno</h3>
                    <p>Organizar los estados de cada solicitud recibida.</p>
                </article>
            </div>
        </section>
    </main>

</body>
</html>