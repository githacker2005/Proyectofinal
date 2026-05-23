<?php

require_once "config/database.php";

$pageTitle = "Contacto - Relocation Services";

$mensajeExito = "";
$mensajeError = "";

$nombre = "";
$email = "";
$telefono = "";
$pais_origen = "";
$ciudad_destino = "";
$fecha_llegada = "";
$tipo_servicio = "";
$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = trim($_POST["nombre"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $telefono = trim($_POST["telefono"] ?? "");
    $pais_origen = trim($_POST["pais_origen"] ?? "");
    $ciudad_destino = trim($_POST["ciudad_destino"] ?? "");
    $fecha_llegada = trim($_POST["fecha_llegada"] ?? "");
    $tipo_servicio = trim($_POST["tipo_servicio"] ?? "");
    $mensaje = trim($_POST["mensaje"] ?? "");
    $privacidad = isset($_POST["privacidad"]);

    if (
        empty($nombre) ||
        empty($email) ||
        empty($telefono) ||
        empty($ciudad_destino) ||
        empty($tipo_servicio) ||
        empty($mensaje)
    ) {
        $mensajeError = "Por favor, completa todos los campos obligatorios.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensajeError = "Introduce un correo electrónico válido.";
    } elseif (!$privacidad) {
        $mensajeError = "Debes aceptar el uso de tus datos para enviar la solicitud.";
    } else {
        try {
            $sql = "INSERT INTO solicitudes 
                    (nombre, email, telefono, pais_origen, ciudad_destino, fecha_llegada, tipo_servicio, mensaje)
                    VALUES 
                    (:nombre, :email, :telefono, :pais_origen, :ciudad_destino, :fecha_llegada, :tipo_servicio, :mensaje)";

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ":nombre" => $nombre,
                ":email" => $email,
                ":telefono" => $telefono,
                ":pais_origen" => $pais_origen,
                ":ciudad_destino" => $ciudad_destino,
                ":fecha_llegada" => !empty($fecha_llegada) ? $fecha_llegada : null,
                ":tipo_servicio" => $tipo_servicio,
                ":mensaje" => $mensaje
            ]);

            $mensajeExito = "Solicitud enviada correctamente. Nos pondremos en contacto contigo próximamente.";

            $nombre = "";
            $email = "";
            $telefono = "";
            $pais_origen = "";
            $ciudad_destino = "";
            $fecha_llegada = "";
            $tipo_servicio = "";
            $mensaje = "";

        } catch (PDOException $error) {
            $mensajeError = "No se ha podido guardar la solicitud. Inténtalo de nuevo más tarde.";
        }
    }
}

include "includes/header.php";
?>

<section class="page-hero">
    <span class="hero-label">Contacto</span>
    <h1>Solicita información sobre tu proceso de relocation</h1>
    <p>
        Completa el formulario con tus datos principales y nos pondremos en contacto
        para conocer mejor tu situación y ofrecerte una orientación personalizada.
    </p>
</section>

<section class="contact-section">
    <div class="contact-info">
        <h2>Cuéntanos qué necesitas</h2>
        <p>
            Este formulario está pensado para recoger la información básica de personas,
            familias o profesionales que necesitan ayuda durante un proceso de traslado.
        </p>

        <div class="info-box">
            <h3>Información que puedes enviar</h3>
            <ul>
                <li>Ciudad o país de destino</li>
                <li>Fecha aproximada de llegada</li>
                <li>Tipo de servicio que necesitas</li>
                <li>Dudas concretas sobre tu traslado</li>
            </ul>
        </div>
    </div>

    <div class="contact-form-wrapper">
        <h2>Formulario de contacto</h2>

        <?php if (!empty($mensajeExito)): ?>
            <div class="form-message success-message">
                <?= htmlspecialchars($mensajeExito) ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($mensajeError)): ?>
            <div class="form-message error-message-general">
                <?= htmlspecialchars($mensajeError) ?>
            </div>
        <?php endif; ?>

        <form action="contacto.php" method="POST" class="contact-form" id="contactForm" novalidate>
            <div class="form-group">
                <label for="nombre">Nombre completo</label>
                <input 
                    type="text" 
                    id="nombre" 
                    name="nombre" 
                    placeholder="Ejemplo: María López"
                    value="<?= htmlspecialchars($nombre) ?>"
                >
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="email">Correo electrónico</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        placeholder="ejemplo@email.com"
                        value="<?= htmlspecialchars($email) ?>"
                    >
                </div>

                <div class="form-group">
                    <label for="telefono">Teléfono</label>
                    <input 
                        type="text" 
                        id="telefono" 
                        name="telefono" 
                        placeholder="+34 600 000 000"
                        value="<?= htmlspecialchars($telefono) ?>"
                    >
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="pais_origen">País o ciudad de origen</label>
                    <input 
                        type="text" 
                        id="pais_origen" 
                        name="pais_origen" 
                        placeholder="Ejemplo: Francia"
                        value="<?= htmlspecialchars($pais_origen) ?>"
                    >
                </div>

                <div class="form-group">
                    <label for="ciudad_destino">Ciudad de destino</label>
                    <input 
                        type="text" 
                        id="ciudad_destino" 
                        name="ciudad_destino" 
                        placeholder="Ejemplo: Bilbao"
                        value="<?= htmlspecialchars($ciudad_destino) ?>"
                    >
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="fecha_llegada">Fecha aproximada de llegada</label>
                    <input 
                        type="date" 
                        id="fecha_llegada" 
                        name="fecha_llegada"
                        value="<?= htmlspecialchars($fecha_llegada) ?>"
                    >
                </div>

                <div class="form-group">
                    <label for="tipo_servicio">Tipo de servicio</label>
                    <select id="tipo_servicio" name="tipo_servicio">
                        <option value="">Selecciona una opción</option>
                        <option value="busqueda-vivienda" <?= $tipo_servicio === "busqueda-vivienda" ? "selected" : "" ?>>Búsqueda de vivienda</option>
                        <option value="tramites" <?= $tipo_servicio === "tramites" ? "selected" : "" ?>>Gestión de trámites</option>
                        <option value="orientacion-ciudad" <?= $tipo_servicio === "orientacion-ciudad" ? "selected" : "" ?>>Orientación en la ciudad</option>
                        <option value="apoyo-familias" <?= $tipo_servicio === "apoyo-familias" ? "selected" : "" ?>>Apoyo a familias</option>
                        <option value="relocation-laboral" <?= $tipo_servicio === "relocation-laboral" ? "selected" : "" ?>>Relocation laboral</option>
                        <option value="acompanamiento" <?= $tipo_servicio === "acompanamiento" ? "selected" : "" ?>>Acompañamiento personalizado</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="mensaje">Mensaje</label>
                <textarea 
                    id="mensaje" 
                    name="mensaje" 
                    placeholder="Cuéntanos brevemente tu situación o qué necesitas."
                ><?= htmlspecialchars($mensaje) ?></textarea>
            </div>

            <div class="form-check">
                <input type="checkbox" id="privacidad" name="privacidad">
                <label for="privacidad">
                    Acepto que mis datos sean utilizados para responder a esta solicitud de información.
                </label>
            </div>

            <div id="formMessage" class="form-message"></div>

            <button type="submit">Enviar solicitud</button>
        </form>
    </div>
</section>

<?php
include "includes/footer.php";
?>