<?php
session_start(); // Mulai session jika belum

// Hapus semua data session
$_SESSION = [];
session_unset();
session_destroy();

// Hapus cookie session jika ada
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Redirect ke halaman login atau beranda
header("Location: ../index"); // atau ../login jika ingin ke login
exit;
?>
