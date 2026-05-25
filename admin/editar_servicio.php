<?php

require_once "auth.php";
require_once "../config/database.php";

$id = $_GET["id"] ?? null;

if (!$id || !is_numeric($id)) {
    header("Location: servicios.php");
    exit;
}

$error = "";
$servicio = null;

try {
    $stmt = $pdo->prepare("SELECT * FROM servicios WHERE id = :id");
    $stmt->execute([
        ":id" => $id
    ]);

    $servicio = $stmt->fetch();

    if (!$servicio) {
        header("Location: servicios.php");
        exit;
    }

} catch (PDOException $e) {
    $error = "No se ha podido cargar el servicio.";
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $titulo = trim($_POST["titulo"] ?? "");
    $descripcion = trim($_POST["descripcion"] ?? "");
    $precio_estimado = trim($_POST["precio_estimado"] ?? "");
    $duracion = trim($_POST["duracion"] ?? "");
    $activo = isset($_POST["activo"]) ? 1 : 0;

    if (empty($titulo) || empty($descripcion)) {
        $error = "El título y la descripción son obligatorios.";
    } elseif (!empty($precio_estimado) && !is_numeric($precio_estimado)) {
        $error = "El precio estimado debe ser un número válido.";
    } else {
        try {
            $sql = "UPDATE servicios
                    SET titulo = :titulo,
                        descripcion = :descripcion,
                        precio_estimado = :precio_estimado,
                        duracion = :duracion,
                        activo = :activo
                    WHERE id = :id";

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ":titulo" => $titulo,
                ":descripcion" => $descripcion,
                ":precio_estimado" => !empty($precio_estimado) ? $precio_estimado : null,
                ":duracion" => !empty($duracion) ? $duracion : null,
                ":activo" => $activo,
                ":id" => $id
            ]);

            header("Location: servicios.php?mensaje=editado");
            exit;

        } catch (PDOException $e) {
            $error = "No se ha podido actualizar el servicio.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar servicio - Panel de administración</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="admin-body">

    <header class="admin-header">
        <div>
            <h2>Panel de administración</h2>
            <p>Editar servicio de relocation</p>
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
            <span class="hero-label">Editar servicio</span>
            <h1><?= htmlspecialchars($servicio["titulo"]) ?></h1>
            <p>
                Modifica los datos del servicio registrado en la base de datos.
            </p>
        </section>

        <?php if (!empty($error)): ?>
            <div class="form-message error-message-general">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <section class="admin-form-section">
            <form action="editar_servicio.php?id=<?= htmlspecialchars($servicio["id"]) ?>" method="POST" class="admin-edit-form">
                <div class="form-group">
                    <label for="titulo">Título del servicio</label>
                    <input 
                        type="text" 
                        id="titulo" 
                        name="titulo" 
                        value="<?= htmlspecialchars($servicio["titulo"]) ?>"
                    >
                </div>

                <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <textarea id="descripcion" name="descripcion"><?= htmlspecialchars($servicio["descripcion"]) ?></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="precio_estimado">Precio estimado</label>
                        <input 
                            type="text" 
                            id="precio_estimado" 
                            name="precio_estimado" 
                            value="<?= htmlspecialchars($servicio["precio_estimado"] ?? "") ?>"
                        >
                    </div>

                    <div class="form-group">
                        <label for="duracion">Duración</label>
                        <input 
                            type="text" 
                            id="duracion" 
                            name="duracion" 
                            value="<?= htmlspecialchars($servicio["duracion"] ?? "") ?>"
                        >
                    </div>
                </div>

                <div class="form-check">
                    <input 
                        type="checkbox" 
                        id="activo" 
                        name="activo"
                        <?= $servicio["activo"] ? "checked" : "" ?>
                    >
                    <label for="activo">Servicio activo</label>
                </div>

                <div class="admin-form-actions">
                    <button type="submit">Guardar cambios</button>
                    <a href="servicios.php" class="secondary-link">Volver al listado</a>
                </div>
            </form>
        </section>
    </main>

</body>
</html>