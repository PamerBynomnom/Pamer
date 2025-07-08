<?php
require_once '../service/auth.php';
require_once '../service/koneksi.php';
onlyAdmin();

// Lokasi folder penyimpanan fisik gambar
$uploadDir = '../images/';
$publicPath = 'images/'; // Ini yang akan disimpan ke database

// Proses tambah / edit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $nama = trim($_POST['nama'] ?? '');
    $deskripsi = trim($_POST['deskripsi'] ?? '');
    $harga = $_POST['harga'] ?? '';
    $kategori = trim($_POST['kategori'] ?? '');

    // Validasi form input
    if ($nama === '' || $deskripsi === '' || $harga === '' || $kategori === '') {
        header("Location: ../admin/menu.php?error=Semua field harus diisi");
        exit;
    }

    if (!is_numeric($harga) || $harga <= 0) {
        header("Location: ../admin/menu.php?error=Harga harus berupa angka positif");
        exit;
    }

    // Validasi dan proses upload gambar
    $gambarBaru = '';
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
        $fileType = mime_content_type($_FILES['gambar']['tmp_name']);

        if (!in_array($fileType, $allowedTypes)) {
            header("Location: ../admin/menu.php?error=Format gambar tidak didukung (hanya JPG/PNG/WebP)");
            exit;
        }

        $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
        $fileName = uniqid('menu_') . '.' . $ext;
        $gambarBaru = $publicPath . $fileName; // Simpan path lengkap ke DB
        move_uploaded_file($_FILES['gambar']['tmp_name'], $uploadDir . $fileName);
    }

    // Tambah data
    if ($id === '') {
        if ($gambarBaru === '') {
            header("Location: ../admin/menu.php?error=Gambar wajib diunggah");
            exit;
        }

        $stmt = $conn->prepare("INSERT INTO menu (nama, deskripsi, harga, gambar, kategori) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiss", $nama, $deskripsi, $harga, $gambarBaru, $kategori);
        if ($stmt->execute()) {
            header("Location: ../admin/menu.php?success=Menu berhasil ditambahkan");
        } else {
            error_log("Insert error: " . $stmt->error);
            header("Location: ../admin/menu.php?error=Gagal menambahkan menu");
        }
        exit;
    }

    // Edit data: validasi ID
    $stmt = $conn->prepare("SELECT gambar FROM menu WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($gambarLama);
    if (!$stmt->fetch()) {
        $stmt->close();
        header("Location: ../admin/menu.php?error=Data tidak ditemukan");
        exit;
    }
    $stmt->close();

    // Jika tidak upload gambar baru, gunakan gambar lama
    if ($gambarBaru === '') {
        $gambarBaru = $gambarLama;
    } else {
        // Hapus file lama jika ada
        $lamaPath = '../' . $gambarLama;
        if (file_exists($lamaPath)) {
            unlink($lamaPath);
        }
    }

    // Update data
    $stmt = $conn->prepare("UPDATE menu SET nama=?, deskripsi=?, harga=?, gambar=?, kategori=? WHERE id=?");
    $stmt->bind_param("ssissi", $nama, $deskripsi, $harga, $gambarBaru, $kategori, $id);
    if ($stmt->execute()) {
        header("Location: ../admin/menu.php?success=Menu berhasil diperbarui");
    } else {
        error_log("Update error: " . $stmt->error);
        header("Location: ../admin/menu.php?error=Gagal memperbarui menu");
    }
    exit;
}

// Proses hapus
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];

    // Ambil gambar untuk dihapus
    $stmt = $conn->prepare("SELECT gambar FROM menu WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($gambar);
    if (!$stmt->fetch()) {
        $stmt->close();
        header("Location: ../admin/menu.php?error=Data tidak ditemukan");
        exit;
    }
    $stmt->close();

    // Hapus data
    $stmt = $conn->prepare("DELETE FROM menu WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        // Hapus file gambar jika ada
        $gambarPath = '../' . $gambar;
        if ($gambar && file_exists($gambarPath)) {
            unlink($gambarPath);
        }
        header("Location: ../admin/menu.php?success=Menu berhasil dihapus");
    } else {
        error_log("Delete error: " . $stmt->error);
        header("Location: ../admin/menu.php?error=Gagal menghapus menu");
    }
    exit;
}

// Ambil semua data menu
$result = $conn->query("SELECT * FROM menu ORDER BY created_at DESC");
$menus = $result->fetch_all(MYSQLI_ASSOC);
?>