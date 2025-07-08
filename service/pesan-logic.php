<?php
session_start();
include 'koneksi.php';

// Cek login
$isLoggedIn = isset($_SESSION['email']);
$userName = $isLoggedIn ? htmlspecialchars($_SESSION['name']) : '';

// Ambil data menu dari database
$menus = [];
$query = "SELECT * FROM menu ORDER BY created_at DESC";

if ($stmt = $conn->prepare($query)) {
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $menus[] = $row;
    }

    $stmt->close();
}
// Fungsi validasi sederhana
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function isTooShort($string, $minLength = 2) {
    return strlen(trim($string)) < $minLength;
}

function isTooLong($string, $maxLength = 255) {
    return strlen(trim($string)) > $maxLength;
}

// Proses form jika dikirim
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nama = htmlspecialchars(trim($_POST['name'] ?? ''));
    $email = htmlspecialchars(trim($_POST['email'] ?? ''));
    $lokasi = htmlspecialchars(trim($_POST['lokasi'] ?? ''));
    $pesan = htmlspecialchars(trim($_POST['message'] ?? ''));

    // Validasi form
    if (empty($nama) || empty($email) || empty($lokasi) || empty($pesan)) {
        $error = "Semua kolom harus diisi.";
    } elseif (!isValidEmail($email)) {
        $error = "Format email tidak valid.";
    } elseif (isTooShort($nama) || isTooShort($lokasi) || isTooShort($pesan)) {
        $error = "Nama, lokasi, dan pesan harus memiliki minimal 2 karakter.";
    } elseif (isTooLong($nama) || isTooLong($email) || isTooLong($lokasi) || isTooLong($pesan, 500)) {
        $error = "Input terlalu panjang. Maksimal 255 karakter untuk nama, email, lokasi, dan 500 karakter untuk pesan.";
    } else {
        // Lolos validasi, simpan ke database
        $stmt = $conn->prepare("INSERT INTO komentar (nama, email, lokasi, pesan) VALUES (?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("ssss", $nama, $email, $lokasi, $pesan);
            if ($stmt->execute()) {
                $success = "Pesan berhasil dikirim!";
            } else {
                $error = "Gagal mengirim pesan. Silakan coba lagi.";
            }
            $stmt->close();
        } else {
            $error = "Gagal mempersiapkan pernyataan SQL.";
        }
    }
}

$conn->close();
?>
