<?php

require_once "auth.php";
require_once "../config/database.php";

$id = $_GET["id"] ?? null;

if (!$id || !is_numeric($id)) {
    header("Location: solicitudes.php");
    exit;
}

try {
    $stmt = $pdo->prepare("DELETE FROM solicitudes WHERE id = :id");
    $stmt->execute([
        ":id" => $id
    ]);

    header("Location: solicitudes.php?mensaje=eliminada");
    exit;

} catch (PDOException $e) {
    header("Location: solicitudes.php?mensaje=error_eliminar");
    exit;
}