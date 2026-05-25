<?php

require_once "auth.php";
require_once "../config/database.php";

$error = "";

$titulo = "";
$descripcion = "";
$precio_estimado = "";
$duracion = "";
$activo = 1;

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
            $sql = "INSERT INTO servicios 
                    (titulo, descripcion, precio_estimado, duracion, activo)
                    VALUES
                    (:titulo, :descripcion, :precio_estimado, :duracion, :activo)";

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ":titulo" => $titulo,
                ":descripcion" => $descripcion,
                ":precio_estimado" => !empty($precio_estimado) ? $precio_estimado : null,
                ":duracion" => !empty($duracion) ? $duracion : null,
                ":activo" => $activo
            ]);

            header("Location: servicios.php?mensaje=creado");
            exit;

        } catch (PDOException $e) {
            $error = "No se ha podido crear el servicio.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear servicio - Panel de administración</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="admin-body">

    <header class="admin-header">
        <div>
            <h2>Panel de administración</h2>
            <p>Crear nuevo servicio de relocation</p>
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
            <span class="hero-label">Nuevo servicio</span>
            <h1>Crear servicio</h1>
            <p>
                Añade un nuevo servicio de relocation para que quede registrado en la base de datos.
            </p>
        </section>

        <?php if (!empty($error)): ?>
            <div class="form-message error-message-general">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <section class="admin-form-section">
            <form action="crear_servicio.php" method="POST" class="admin-edit-form">
                <div class="form-group">
                    <label for="titulo">Título del servicio</label>
                    <input 
                        type="text" 
                        id="titulo" 
                        name="titulo" 
                        value="<?= htmlspecialchars($titulo) ?>"
                        placeholder="Ejemplo: Búsqueda de vivienda"
                    >
                </div>

                <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <textarea 
                        id="descripcion" 
                        name="descripcion" 
                        placeholder="Describe brevemente el servicio."
                    ><?= htmlspecialchars($descripcion) ?></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="precio_estimado">Precio estimado</label>
                        <input 
                            type="text" 
                            id="precio_estimado" 
                            name="precio_estimado" 
                            value="<?= htmlspecialchars($precio_estimado) ?>"
                            placeholder="Ejemplo: 150"
                        >
                    </div>

                    <div class="form-group">
                        <label for="duracion">Duración</label>
                        <input 
                            type="text" 
                            id="duracion" 
                            name="duracion" 
                            value="<?= htmlspecialchars($duracion) ?>"
                            placeholder="Ejemplo: Según necesidades"
                        >
                    </div>
                </div>

                <div class="form-check">
                    <input 
                        type="checkbox" 
                        id="activo" 
                        name="activo"
                        <?= $activo ? "checked" : "" ?>
                    >
                    <label for="activo">Servicio activo</label>
                </div>

                <div class="admin-form-actions">
                    <button type="submit">Crear servicio</button>
                    <a href="servicios.php" class="secondary-link">Volver al listado</a>
                </div>
            </form>
        </section>
    </main>

</body>
</html>