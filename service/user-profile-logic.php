<?php
session_start();
include 'koneksi.php';

$isLoggedIn = isset($_SESSION['email']);
$userName = $isLoggedIn ? htmlspecialchars($_SESSION['name']) : '';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$errors = [];
$success = "";

// Ambil data user
$stmt = $conn->prepare("SELECT u.name, u.email, d.phone, d.address, d.city, d.state 
                        FROM users u 
                        LEFT JOIN user_details d ON u.id = d.user_id 
                        WHERE u.id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Proses update
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['profile_update'])) {
    $firstName = trim($_POST['first-name']);
    $lastName = trim($_POST['last-name']);
    $fullName = $firstName . ' ' . $lastName;
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $city = trim($_POST['city']);
    $state = trim($_POST['state']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // Validasi
    if (strlen($firstName) < 2 || strlen($lastName) < 2) {
        $errors[] = "Nama depan dan belakang minimal 2 karakter.";
    }
    if (!empty($password)) {
        if ($password !== $confirmPassword) {
            $errors[] = "Password dan konfirmasi tidak cocok.";
        } elseif (strlen($password) < 6) {
            $errors[] = "Password minimal 6 karakter.";
        }
    }

    if (empty($errors)) {
        // Update users
        if (!empty($password)) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE users SET name=?, password=? WHERE id=?");
            $stmt->bind_param("ssi", $fullName, $hashedPassword, $user_id);
        } else {
            $stmt = $conn->prepare("UPDATE users SET name=? WHERE id=?");
            $stmt->bind_param("si", $fullName, $user_id);
        }
        $stmt->execute();
        $stmt->close();

        // Update/insert user_details
        $stmt = $conn->prepare("SELECT id FROM user_details WHERE user_id=?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $exists = $result->num_rows > 0;
        $stmt->close();

        if ($exists) {
            $stmt = $conn->prepare("UPDATE user_details SET phone=?, address=?, city=?, state=? WHERE user_id=?");
            $stmt->bind_param("ssssi", $phone, $address, $city, $state, $user_id);
        } else {
            $stmt = $conn->prepare("INSERT INTO user_details (user_id, phone, address, city, state) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("issss", $user_id, $phone, $address, $city, $state);
        }
        $stmt->execute();
        $stmt->close();

        $success = "Profil berhasil diperbarui.";
        header("Location: user-profile.php");
        exit();
    }
}

// Pisahkan nama
$nameParts = explode(" ", $user['name'], 2);
$firstName = $nameParts[0];
$lastName = $nameParts[1] ?? '';

// === Kirim Pesan (Footer) ===
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function isTooShort($string, $minLength = 2) {
    return strlen(trim($string)) < $minLength;
}

function isTooLong($string, $maxLength = 255) {
    return strlen(trim($string)) > $maxLength;
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['footer_message'])) {
    $nama = htmlspecialchars(trim($_POST['name'] ?? ''));
    $email = htmlspecialchars(trim($_POST['email'] ?? ''));
    $lokasi = htmlspecialchars(trim($_POST['lokasi'] ?? ''));
    $pesan = htmlspecialchars(trim($_POST['message'] ?? ''));

    if (empty($nama) || empty($email) || empty($lokasi) || empty($pesan)) {
        $error = "Semua kolom harus diisi.";
    } elseif (!isValidEmail($email)) {
        $error = "Format email tidak valid.";
    } elseif (isTooShort($nama) || isTooShort($lokasi) || isTooShort($pesan)) {
        $error = "Input terlalu pendek.";
    } elseif (isTooLong($nama) || isTooLong($email) || isTooLong($lokasi) || isTooLong($pesan, 500)) {
        $error = "Input terlalu panjang.";
    } else {
        $stmt = $conn->prepare("INSERT INTO komentar (nama, email, lokasi, pesan) VALUES (?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("ssss", $nama, $email, $lokasi, $pesan);
            if ($stmt->execute()) {
                $success = "Pesan berhasil dikirim!";
            } else {
                $error = "Gagal mengirim pesan.";
            }
            $stmt->close();
        } else {
            $error = "Kesalahan pada SQL.";
        }
    }
}
?>
