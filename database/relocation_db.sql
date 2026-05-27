DROP DATABASE IF EXISTS relocation_db;

CREATE DATABASE relocation_db
CHARACTER SET utf8mb4
COLLATE utf8mb4_general_ci;

USE relocation_db;

-- =========================
-- TABLA DE USUARIOS ADMIN
-- =========================

CREATE TABLE usuarios_admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    rol VARCHAR(50) DEFAULT 'administrador',
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Usuario administrador
-- Email: admin@relocation.com
-- Contraseña: password

INSERT INTO usuarios_admin (nombre, email, password, rol)
VALUES (
    'Administrador',
    'admin@relocation.com',
    '$2y$12$oA7lXkBDma3qBWkxUkPO4O0zAeC/Kqq34StNUBsPb2GKIT1EdFm1G',
    'administrador'
);

-- =========================
-- TABLA DE SERVICIOS
-- =========================

CREATE TABLE servicios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(150) NOT NULL,
    descripcion TEXT NOT NULL,
    precio_estimado DECIMAL(10,2) DEFAULT NULL,
    duracion VARCHAR(100) DEFAULT NULL,
    activo TINYINT(1) DEFAULT 1,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO servicios (titulo, descripcion, precio_estimado, duracion, activo)
VALUES
(
    'Búsqueda de vivienda',
    'Ayuda en la localización de viviendas según presupuesto, zona y necesidades del cliente.',
    NULL,
    'Según necesidades',
    1
),
(
    'Gestión de trámites',
    'Orientación en trámites administrativos básicos relacionados con la llegada a una nueva ciudad o país.',
    NULL,
    'Según necesidades',
    1
),
(
    'Orientación en la ciudad',
    'Información sobre barrios, transporte, colegios, servicios sanitarios y recursos útiles del entorno.',
    NULL,
    'Según necesidades',
    1
),
(
    'Apoyo a familias',
    'Acompañamiento específico para familias que necesitan organizar vivienda, colegios, servicios y adaptación al nuevo destino.',
    NULL,
    'Según necesidades',
    1
),
(
    'Relocation laboral',
    'Servicio orientado a profesionales que se trasladan por motivos laborales y necesitan instalarse de forma rápida y organizada.',
    NULL,
    'Según necesidades',
    1
),
(
    'Acompañamiento personalizado',
    'Seguimiento cercano durante el proceso de traslado para facilitar la adaptación del cliente.',
    NULL,
    'Según necesidades',
    1
);

-- =========================
-- TABLA DE SOLICITUDES
-- =========================

CREATE TABLE solicitudes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(120) NOT NULL,
    email VARCHAR(150) NOT NULL,
    telefono VARCHAR(30) NOT NULL,
    pais_origen VARCHAR(100) DEFAULT NULL,
    ciudad_destino VARCHAR(100) NOT NULL,
    fecha_llegada DATE DEFAULT NULL,
    tipo_servicio VARCHAR(100) NOT NULL,
    mensaje TEXT NOT NULL,
    estado ENUM('Pendiente', 'Contactado', 'En proceso', 'Finalizado', 'Cancelado') DEFAULT 'Pendiente',
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);