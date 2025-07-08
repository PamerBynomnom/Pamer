<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Fungsi untuk memastikan user sudah login (user atau admin)
function onlyLoggedIn() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: /login.php");
        exit;
    }
}

// Fungsi untuk memastikan hanya admin yang boleh masuk
function onlyAdmin() {
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
        header("Location: /login.php");
        exit;
    }
}
