<?php

session_start();

if (!isset($_SESSION["admin_id"])) {
    header("Location: login.php");
    exit;
}

if (!isset($_SESSION["admin_email"]) || empty($_SESSION["admin_email"])) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit;
}