# Proyecto Final DAW - Relocation Services

Aplicación web desarrollada como Proyecto Final del ciclo de Desarrollo de Aplicaciones Web.

## Descripción del proyecto

Relocation Services es una aplicación web creada para una profesional autónoma dedicada a ofrecer servicios de relocation a personas, familias o profesionales que necesitan ayuda durante un proceso de traslado.

El proyecto incluye una parte pública, donde los usuarios pueden consultar información sobre la empresa y sus servicios, y una parte privada de administración, donde se pueden gestionar solicitudes de clientes y servicios registrados en la base de datos.

## Objetivo

El objetivo principal del proyecto es crear una aplicación web funcional, responsive y conectada a base de datos que permita:

- Presentar los servicios de relocation de forma profesional.
- Recoger solicitudes de clientes mediante un formulario de contacto.
- Gestionar las solicitudes desde un panel privado.
- Administrar los servicios ofrecidos por la empresa.
- Aplicar operaciones CRUD mediante PHP y MySQL.

## Tecnologías utilizadas

- HTML5
- CSS3
- JavaScript
- PHP
- MySQL
- PDO
- Git
- GitHub
- XAMPP

## Funcionalidades principales

### Parte pública

- Página de inicio.
- Página de servicios.
- Página sobre la empresa.
- Página de contacto.
- Formulario de solicitud de información.
- Validaciones con JavaScript.
- Diseño responsive.

### Panel de administración

- Login de administrador.
- Gestión de sesiones.
- Dashboard privado.
- Listado de solicitudes.
- Edición de solicitudes.
- Eliminación de solicitudes.
- Listado de servicios.
- Creación de servicios.
- Edición de servicios.
- Eliminación de servicios.

## Estructura del proyecto

```text
Proyectofinal/
│
├── admin/
│   ├── auth.php
│   ├── dashboard.php
│   ├── login.php
│   ├── logout.php
│   ├── solicitudes.php
│   ├── editar_solicitud.php
│   ├── eliminar_solicitud.php
│   ├── servicios.php
│   ├── crear_servicio.php
│   ├── editar_servicio.php
│   └── eliminar_servicio.php
│
├── config/
│   └── database.php
│
├── css/
│   └── style.css
│
├── database/
│   └── relocation_db.sql
│
├── docs/
│   ├── pruebas_funcionales.md
│   └── correcciones_testing.md
│
├── includes/
│   ├── header.php
│   └── footer.php
│
├── js/
│   └── script.js
│
├── index.php
├── servicios.php
├── sobre-mi.php
├── contacto.php
└── README.md