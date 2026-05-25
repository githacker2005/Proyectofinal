<?php

require_once "auth.php";
require_once "../config/database.php";

$id = $_GET["id"] ?? null;

if (!$id || !is_numeric($id)) {
    header("Location: solicitudes.php");
    exit;
}

$error = "";
$success = "";
$solicitud = null;

try {
    $stmt = $pdo->prepare("SELECT * FROM solicitudes WHERE id = :id");
    $stmt->execute([
        ":id" => $id
    ]);
    $solicitud = $stmt->fetch();

    if (!$solicitud) {
        header("Location: solicitudes.php");
        exit;
    }

} catch (PDOException $e) {
    $error = "No se ha podido cargar la solicitud.";
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = trim($_POST["nombre"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $telefono = trim($_POST["telefono"] ?? "");
    $pais_origen = trim($_POST["pais_origen"] ?? "");
    $ciudad_destino = trim($_POST["ciudad_destino"] ?? "");
    $fecha_llegada = trim($_POST["fecha_llegada"] ?? "");
    $tipo_servicio = trim($_POST["tipo_servicio"] ?? "");
    $mensaje = trim($_POST["mensaje"] ?? "");
    $estado = trim($_POST["estado"] ?? "Pendiente");

    if (
        empty($nombre) ||
        empty($email) ||
        empty($telefono) ||
        empty($ciudad_destino) ||
        empty($tipo_servicio) ||
        empty($mensaje)
    ) {
        $error = "Por favor, completa todos los campos obligatorios.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Introduce un correo electrónico válido.";
    } else {
        try {
            $sql = "UPDATE solicitudes 
                    SET nombre = :nombre,
                        email = :email,
                        telefono = :telefono,
                        pais_origen = :pais_origen,
                        ciudad_destino = :ciudad_destino,
                        fecha_llegada = :fecha_llegada,
                        tipo_servicio = :tipo_servicio,
                        mensaje = :mensaje,
                        estado = :estado
                    WHERE id = :id";

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ":nombre" => $nombre,
                ":email" => $email,
                ":telefono" => $telefono,
                ":pais_origen" => $pais_origen,
                ":ciudad_destino" => $ciudad_destino,
                ":fecha_llegada" => !empty($fecha_llegada) ? $fecha_llegada : null,
                ":tipo_servicio" => $tipo_servicio,
                ":mensaje" => $mensaje,
                ":estado" => $estado,
                ":id" => $id
            ]);

            header("Location: solicitudes.php?mensaje=editada");
                exit;

        } catch (PDOException $e) {
            $error = "No se ha podido actualizar la solicitud.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar solicitud - Panel de administración</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="admin-body">

    <header class="admin-header">
        <div>
            <h2>Panel de administración</h2>
            <p>Editar solicitud de cliente</p>
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
            <span class="hero-label">Editar solicitud</span>
            <h1><?= htmlspecialchars($solicitud["nombre"]) ?></h1>
            <p>
                Modifica los datos de la solicitud y actualiza su estado de gestión.
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

        <section class="admin-form-section">
            <form action="editar_solicitud.php?id=<?= htmlspecialchars($solicitud["id"]) ?>" method="POST" class="admin-edit-form">
                <div class="form-row">
                    <div class="form-group">
                        <label for="nombre">Nombre completo</label>
                        <input 
                            type="text" 
                            id="nombre" 
                            name="nombre" 
                            value="<?= htmlspecialchars($solicitud["nombre"]) ?>"
                        >
                    </div>

                    <div class="form-group">
                        <label for="email">Correo electrónico</label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="<?= htmlspecialchars($solicitud["email"]) ?>"
                        >
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input 
                            type="text" 
                            id="telefono" 
                            name="telefono" 
                            value="<?= htmlspecialchars($solicitud["telefono"]) ?>"
                        >
                    </div>

                    <div class="form-group">
                        <label for="pais_origen">País o ciudad de origen</label>
                        <input 
                            type="text" 
                            id="pais_origen" 
                            name="pais_origen" 
                            value="<?= htmlspecialchars($solicitud["pais_origen"] ?? "") ?>"
                        >
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="ciudad_destino">Ciudad de destino</label>
                        <input 
                            type="text" 
                            id="ciudad_destino" 
                            name="ciudad_destino" 
                            value="<?= htmlspecialchars($solicitud["ciudad_destino"]) ?>"
                        >
                    </div>

                    <div class="form-group">
                        <label for="fecha_llegada">Fecha aproximada de llegada</label>
                        <input 
                            type="date" 
                            id="fecha_llegada" 
                            name="fecha_llegada" 
                            value="<?= htmlspecialchars($solicitud["fecha_llegada"] ?? "") ?>"
                        >
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="tipo_servicio">Tipo de servicio</label>
                        <select id="tipo_servicio" name="tipo_servicio">
                            <option value="">Selecciona una opción</option>
                            <option value="busqueda-vivienda" <?= $solicitud["tipo_servicio"] === "busqueda-vivienda" ? "selected" : "" ?>>Búsqueda de vivienda</option>
                            <option value="tramites" <?= $solicitud["tipo_servicio"] === "tramites" ? "selected" : "" ?>>Gestión de trámites</option>
                            <option value="orientacion-ciudad" <?= $solicitud["tipo_servicio"] === "orientacion-ciudad" ? "selected" : "" ?>>Orientación en la ciudad</option>
                            <option value="apoyo-familias" <?= $solicitud["tipo_servicio"] === "apoyo-familias" ? "selected" : "" ?>>Apoyo a familias</option>
                            <option value="relocation-laboral" <?= $solicitud["tipo_servicio"] === "relocation-laboral" ? "selected" : "" ?>>Relocation laboral</option>
                            <option value="acompanamiento" <?= $solicitud["tipo_servicio"] === "acompanamiento" ? "selected" : "" ?>>Acompañamiento personalizado</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="estado">Estado de la solicitud</label>
                        <select id="estado" name="estado">
                            <option value="Pendiente" <?= $solicitud["estado"] === "Pendiente" ? "selected" : "" ?>>Pendiente</option>
                            <option value="Contactado" <?= $solicitud["estado"] === "Contactado" ? "selected" : "" ?>>Contactado</option>
                            <option value="En proceso" <?= $solicitud["estado"] === "En proceso" ? "selected" : "" ?>>En proceso</option>
                            <option value="Finalizado" <?= $solicitud["estado"] === "Finalizado" ? "selected" : "" ?>>Finalizado</option>
                            <option value="Cancelado" <?= $solicitud["estado"] === "Cancelado" ? "selected" : "" ?>>Cancelado</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="mensaje">Mensaje</label>
                    <textarea id="mensaje" name="mensaje"><?= htmlspecialchars($solicitud["mensaje"]) ?></textarea>
                </div>

                <div class="admin-form-actions">
                    <button type="submit">Guardar cambios</button>
                    <a href="solicitudes.php" class="secondary-link">Volver al listado</a>
                </div>
            </form>
        </section>
    </main>

</body>
</html>