<?php
require_once 'koneksi.php';
session_start();

// Fungsi untuk redirect dengan pesan error/sukses
function redirectWithMessage($type, $message) {
    header("Location: ../login.php?$type=" . urlencode($message));
    exit;
}

// Fungsi validasi password minimal
function isPasswordValid($password) {
    return strlen($password) >= 6;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // === LOGIN ===
    if (isset($_POST['login'])) {
        $email = filter_var(trim($_POST['login_email']), FILTER_VALIDATE_EMAIL);
        $password = trim($_POST['login_password']);

        if (!$email || empty($password)) {
            redirectWithMessage('error', "Email atau password tidak valid!");
        }

        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];

            $redirect = ($user['role'] === 'admin') ? '../admin/dashboard.php' : '../index.php';
            header("Location: $redirect");
            exit;
        } else {
            redirectWithMessage('error', "Login gagal! Email atau password salah.");
        }
    }

    // === REGISTER ===
    if (isset($_POST['register'])) {
        $name = substr(htmlspecialchars(trim($_POST['register_name'])), 0, 100);
        $email = filter_var(trim($_POST['register_email']), FILTER_VALIDATE_EMAIL);
        $password = $_POST['register_password'];
        $confirmPassword = $_POST['confirm_password'];

        if (!$email || empty($name) || empty($password) || empty($confirmPassword)) {
            redirectWithMessage('error', "Semua field wajib diisi dengan benar.");
        }

        if (!preg_match("/^[a-zA-Z\s']+$/", $name)) {
            redirectWithMessage('error', "Nama hanya boleh berisi huruf, spasi, dan tanda petik.");
        }

        if ($password !== $confirmPassword) {
            redirectWithMessage('error', "Password dan konfirmasi tidak cocok!");
        }

        if (!isPasswordValid($password)) {
            redirectWithMessage('error', "Password minimal 6 karakter.");
        }

        // Cek email unik
        $checkSql = "SELECT id FROM users WHERE email = ?";
        $checkStmt = $conn->prepare($checkSql);
        $checkStmt->bind_param("s", $email);
        $checkStmt->execute();
        $checkStmt->store_result();

        if ($checkStmt->num_rows > 0) {
            $checkStmt->close();
            redirectWithMessage('error', "Email sudah terdaftar. Silakan gunakan email lain.");
        }
        $checkStmt->close();

        // Simpan user baru
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $sql = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'user')";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $name, $email, $hashedPassword);

        if ($stmt->execute()) {
            $stmt->close();
            $conn->close();
            redirectWithMessage('success', "Registrasi berhasil! Silakan login.");
        } else {
            $stmt->close();
            $conn->close();
            redirectWithMessage('error', "Registrasi gagal. Terjadi kesalahan server.");
        }
    }
}

$conn->close();
