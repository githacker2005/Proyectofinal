<?php
if (!isset($pageTitle)) {
    $pageTitle = "Bilbao Relocation";
}

$currentPage = basename($_SERVER["PHP_SELF"]);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header class="site-header">
    <div class="site-header-container">
        <a href="index.php" class="site-brand">
            <img src="img/logo3.png" alt="Bilbao Relocation" class="site-brand-logo">
        </a>

        <nav class="site-nav">
            <ul>
                <li>
                    <a href="index.php" class="<?= $currentPage === 'index.php' ? 'active' : '' ?>">
                        Inicio
                    </a>
                </li>

                <li>
                    <a href="servicios.php" class="<?= $currentPage === 'servicios.php' ? 'active' : '' ?>">
                        Servicios
                    </a>
                </li>

                <li>
                    <a href="sobre-mi.php" class="<?= $currentPage === 'sobre-mi.php' ? 'active' : '' ?>">
                        Sobre mí
                    </a>
                </li>

                <li>
                    <a href="contacto.php" class="<?= $currentPage === 'contacto.php' ? 'active' : '' ?>">
                        Contacto
                    </a>
                </li>
            </ul>
        </nav>

        <a href="contacto.php" class="site-header-cta">
            Solicitar información
        </a>
    </div>
</header>

<main class="<?= $mainClass ?? '' ?>">