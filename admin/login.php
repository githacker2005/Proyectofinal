<?php

session_start();

require_once "../config/database.php";

$error = "";

if (isset($_SESSION["admin_id"])) {
    header("Location: dashboard.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"] ?? "");
    $password = trim($_POST["password"] ?? "");

    if (empty($email) || empty($password)) {
        $error = "Debes introducir el email y la contraseña.";
    } else {
        try {
            $sql = "SELECT * FROM usuarios_admin WHERE email = :email LIMIT 1";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ":email" => $email
            ]);

            $usuario = $stmt->fetch();

            if ($usuario && password_verify($password, $usuario["password"])) {
                session_regenerate_id(true);

                $_SESSION["admin_id"] = $usuario["id"];
                $_SESSION["admin_nombre"] = $usuario["nombre"];
                $_SESSION["admin_email"] = $usuario["email"];

                header("Location: dashboard.php");
                exit;
            } else {
                $error = "Email o contraseña incorrectos.";
            }

        } catch (PDOException $e) {
            $error = "Error al comprobar las credenciales.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login administrador - Relocation Services</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="admin-login-body">

    <main class="login-container">
        <section class="login-card">
            <div class="login-header">
                <span class="hero-label">Panel privado</span>
                <h1>Acceso administrador</h1>
                <p>Introduce tus credenciales para acceder a la gestión interna del proyecto.</p>
            </div>

            <?php if (!empty($error)): ?>
                <div class="form-message error-message-general">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form action="login.php" method="POST" class="login-form">
                <div class="form-group">
                    <label for="email">Correo electrónico</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        placeholder="admin@relocation.com"
                    >
                </div>

                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        placeholder="Introduce la contraseña"
                    >
                </div>

                <button type="submit">Entrar al panel</button>
            </form>

            <div class="login-help">
                <p>Usuario provisional para pruebas:</p>
                <p><strong>Email:</strong> admin@relocation.com</p>
                <p><strong>Contraseña:</strong> password</p>
            </div>

            <a href="../index.php" class="back-link">Volver a la web</a>
        </section>
    </main>

</body>
</html>