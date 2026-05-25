<?php

require_once "auth.php";
require_once "../config/database.php";

$id = $_GET["id"] ?? null;

if (!$id || !is_numeric($id)) {
    header("Location: servicios.php");
    exit;
}

try {
    $stmt = $pdo->prepare("DELETE FROM servicios WHERE id = :id");
    $stmt->execute([
        ":id" => $id
    ]);

    header("Location: servicios.php?mensaje=eliminado");
    exit;

} catch (PDOException $e) {
    header("Location: servicios.php?mensaje=error_eliminar");
    exit;
}