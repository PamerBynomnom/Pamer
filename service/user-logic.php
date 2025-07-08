<?php
require_once '../service/auth.php';
require_once '../service/koneksi.php';
onlyAdmin();

// === HANDLE TAMBAH / EDIT ===
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $role = trim($_POST['role'] ?? '');
    $password = $_POST['password'] ?? '';

    // Validasi dasar
    if ($name === '' || $email === '' || $role === '') {
        header("Location: ../admin/users.php?error=Semua field (kecuali password) wajib diisi");
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../admin/users.php?error=Format email tidak valid");
        exit;
    }

    if ($id === '') {
        // Tambah user baru, cek duplikasi email
        $cek = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $cek->bind_param("s", $email);
        $cek->execute();
        $cek->store_result();
        if ($cek->num_rows > 0) {
            header("Location: ../admin/users.php?error=Email sudah digunakan");
            exit;
        }

        // Tambahkan
        if (!empty($password)) {
            $hashed = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $name, $email, $hashed, $role);
            if ($stmt->execute()) {
                header("Location: ../admin/users.php?success=User berhasil ditambahkan");
            } else {
                header("Location: ../admin/users.php?error=Gagal menambahkan user");
            }
        } else {
            header("Location: ../admin/users.php?error=Password wajib diisi");
        }
        exit;
    }

    // === UPDATE USER ===
    // Cek apakah user ada
    $cek = $conn->prepare("SELECT id FROM users WHERE id = ?");
    $cek->bind_param("i", $id);
    $cek->execute();
    $cek->store_result();
    if ($cek->num_rows === 0) {
        header("Location: ../admin/users.php?error=User tidak ditemukan");
        exit;
    }

    // Update data
    if (!empty($password)) {
        $hashed = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $conn->prepare("UPDATE users SET name=?, email=?, password=?, role=? WHERE id=?");
        $stmt->bind_param("ssssi", $name, $email, $hashed, $role, $id);
    } else {
        $stmt = $conn->prepare("UPDATE users SET name=?, email=?, role=? WHERE id=?");
        $stmt->bind_param("sssi", $name, $email, $role, $id);
    }

    if ($stmt->execute()) {
        header("Location: ../admin/users.php?success=User berhasil diperbarui");
    } else {
        header("Location: ../admin/users.php?error=Gagal memperbarui user");
    }
    exit;
}

// === HAPUS USER ===
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];

    // Cek apakah user ada
    $cek = $conn->prepare("SELECT id FROM users WHERE id = ?");
    $cek->bind_param("i", $id);
    $cek->execute();
    $cek->store_result();
    if ($cek->num_rows === 0) {
        header("Location: ../admin/users.php?error=User tidak ditemukan");
        exit;
    }

    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        header("Location: ../admin/users.php?success=User berhasil dihapus");
    } else {
        header("Location: ../admin/users.php?error=Gagal menghapus user");
    }
    exit;
}

// === AMBIL SEMUA USER ===
$result = $conn->query("SELECT * FROM users ORDER BY created_at DESC");
$users = $result->fetch_all(MYSQLI_ASSOC);
?>
