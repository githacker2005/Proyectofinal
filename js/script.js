document.addEventListener("DOMContentLoaded", function () {
    const contactForm = document.getElementById("contactForm");

    if (!contactForm) {
        return;
    }

    const formMessage = document.getElementById("formMessage");

    contactForm.addEventListener("submit", function (event) {
        clearErrors();

        let isValid = true;

        const nombre = document.getElementById("nombre");
        const email = document.getElementById("email");
        const telefono = document.getElementById("telefono");
        const ciudadDestino = document.getElementById("ciudad_destino");
        const tipoServicio = document.getElementById("tipo_servicio");
        const mensaje = document.getElementById("mensaje");
        const privacidad = document.getElementById("privacidad");

        if (nombre.value.trim().length < 3) {
            showError(nombre, "El nombre debe tener al menos 3 caracteres.");
            isValid = false;
        }

        if (!validateEmail(email.value.trim())) {
            showError(email, "Introduce un correo electrónico válido.");
            isValid = false;
        }

        if (telefono.value.trim().length < 9) {
            showError(telefono, "Introduce un teléfono válido.");
            isValid = false;
        }

        if (ciudadDestino.value.trim() === "") {
            showError(ciudadDestino, "Indica la ciudad de destino.");
            isValid = false;
        }

        if (tipoServicio.value === "") {
            showError(tipoServicio, "Selecciona un tipo de servicio.");
            isValid = false;
        }

        if (mensaje.value.trim().length < 10) {
            showError(mensaje, "El mensaje debe tener al menos 10 caracteres.");
            isValid = false;
        }

        if (!privacidad.checked) {
            showError(privacidad, "Debes aceptar la política de privacidad.");
            isValid = false;
        }

        if (!isValid) {
            event.preventDefault();
            formMessage.textContent = "Revisa los campos marcados antes de enviar el formulario.";
            formMessage.className = "form-message error-message-general";
        }
    });

    function showError(input, message) {
        input.classList.add("input-error");

        const error = document.createElement("small");
        error.classList.add("field-error");
        error.textContent = message;

        const formGroup = input.closest(".form-group") || input.closest(".form-check");

        if (formGroup) {
            formGroup.appendChild(error);
        }
    }

    function clearErrors() {
        const errors = document.querySelectorAll(".field-error");
        const inputs = document.querySelectorAll(".input-error");

        errors.forEach(function (error) {
            error.remove();
        });

        inputs.forEach(function (input) {
            input.classList.remove("input-error");
        });

        formMessage.textContent = "";
        formMessage.className = "form-message";
    }

    function validateEmail(email) {
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailPattern.test(email);
    }
});