<?php
$pageTitle = "Contacto - Relocation Services";
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

        <form action="#" method="POST" class="contact-form">
            <div class="form-group">
                <label for="nombre">Nombre completo</label>
                <input type="text" id="nombre" name="nombre" placeholder="Ejemplo: María López">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="email">Correo electrónico</label>
                    <input type="email" id="email" name="email" placeholder="ejemplo@email.com">
                </div>

                <div class="form-group">
                    <label for="telefono">Teléfono</label>
                    <input type="text" id="telefono" name="telefono" placeholder="+34 600 000 000">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="pais_origen">País o ciudad de origen</label>
                    <input type="text" id="pais_origen" name="pais_origen" placeholder="Ejemplo: Francia">
                </div>

                <div class="form-group">
                    <label for="ciudad_destino">Ciudad de destino</label>
                    <input type="text" id="ciudad_destino" name="ciudad_destino" placeholder="Ejemplo: Bilbao">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="fecha_llegada">Fecha aproximada de llegada</label>
                    <input type="date" id="fecha_llegada" name="fecha_llegada">
                </div>

                <div class="form-group">
                    <label for="tipo_servicio">Tipo de servicio</label>
                    <select id="tipo_servicio" name="tipo_servicio">
                        <option value="">Selecciona una opción</option>
                        <option value="busqueda-vivienda">Búsqueda de vivienda</option>
                        <option value="tramites">Gestión de trámites</option>
                        <option value="orientacion-ciudad">Orientación en la ciudad</option>
                        <option value="apoyo-familias">Apoyo a familias</option>
                        <option value="relocation-laboral">Relocation laboral</option>
                        <option value="acompanamiento">Acompañamiento personalizado</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="mensaje">Mensaje</label>
                <textarea id="mensaje" name="mensaje" placeholder="Cuéntanos brevemente tu situación o qué necesitas."></textarea>
            </div>

            <div class="form-check">
                <input type="checkbox" id="privacidad" name="privacidad">
                <label for="privacidad">
                    Acepto que mis datos sean utilizados para responder a esta solicitud de información.
                </label>
            </div>

            <button type="submit">Enviar solicitud</button>
        </form>
    </div>
</section>

<?php
include "includes/footer.php";
?>