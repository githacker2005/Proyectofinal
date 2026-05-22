<?php
if (!isset($pageTitle)) {
    $pageTitle = "Relocation Services";
}

$currentPage = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header>
    <div>
        <h2>Relocation Services</h2>
        <p>Servicios personalizados para facilitar procesos de traslado.</p>
    </div>

    <nav>
        <ul>
            <li>
                <a href="index.php">Inicio</a>
            </li>
            <li>
                <a href="servicios.php">Servicios</a>
            </li>
            <li>
                <a href="sobre-mi.php">Sobre mí</a>
            </li>
            <li>
                <a href="contacto.php">Contacto</a>
            </li>
        </ul>
    </nav>
</header>

<main>