<?php
$pageTitle = "Contacto - Relocation Services";
include "includes/header.php";
?>

<section>
    <h1>Contacto</h1>
    <p>
        Desde esta página los clientes podrán solicitar información sobre los servicios
        de relocation. Más adelante este formulario se conectará con la base de datos.
    </p>
</section>

<section>
    <h2>Formulario de contacto</h2>

    <form action="#" method="POST">
        <div>
            <label for="nombre">Nombre completo</label>
            <input type="text" id="nombre" name="nombre">
        </div>

        <div>
            <label for="email">Correo electrónico</label>
            <input type="email" id="email" name="email">
        </div>

        <div>
            <label for="telefono">Teléfono</label>
            <input type="text" id="telefono" name="telefono">
        </div>

        <div>
            <label for="mensaje">Mensaje</label>
            <textarea id="mensaje" name="mensaje"></textarea>
        </div>

        <button type="submit">Enviar solicitud</button>
    </form>
</section>

<?php
include "includes/footer.php";
?>