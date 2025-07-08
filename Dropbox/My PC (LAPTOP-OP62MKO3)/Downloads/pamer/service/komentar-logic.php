<?php
require_once 'auth.php';
require_once 'koneksi.php';
onlyAdmin();

// Ambil semua komentar
$komentarQuery = $conn->query("SELECT * FROM komentar ORDER BY tanggal_kirim DESC");
$komentar = $komentarQuery->fetch_all(MYSQLI_ASSOC);

// Ambil ID komentar yang sudah dijadikan testimoni
$testimoniQuery = $conn->query("SELECT komentar_id FROM testimoni");
$testimoniIDs = array_column($testimoniQuery->fetch_all(MYSQLI_ASSOC), 'komentar_id');

// Tambahkan sebagai testimoni
if (isset($_GET['tampilkan'])) {
    $id = (int) $_GET['tampilkan'];

    // Cek komentar ada
    $stmt = $conn->prepare("SELECT COUNT(*) FROM komentar WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($komentarAda);
    $stmt->fetch();
    $stmt->close();

    if ($komentarAda === 0) {
        header("Location: komentar.php?error=Komentar tidak ditemukan");
        exit;
    }

    // Cek apakah sudah jadi testimoni
    $stmt = $conn->prepare("SELECT COUNT(*) FROM testimoni WHERE komentar_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($sudahTestimoni);
    $stmt->fetch();
    $stmt->close();

    if ($sudahTestimoni > 0) {
        header("Location: komentar.php?error=Komentar sudah jadi testimoni");
        exit;
    }

    // Tambahkan sebagai testimoni
    $stmt = $conn->prepare("INSERT INTO testimoni (komentar_id) VALUES (?)");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        header("Location: komentar.php?success=Berhasil menambahkan testimoni");
    } else {
        error_log("Gagal insert testimoni: " . $stmt->error);
        header("Location: komentar.php?error=Gagal menambahkan testimoni");
    }
    exit;
}

// Hapus testimoni
if (isset($_GET['hapus_testimoni'])) {
    $id = (int) $_GET['hapus_testimoni'];

    // Cek apakah testimoni ada
    $stmt = $conn->prepare("SELECT COUNT(*) FROM testimoni WHERE komentar_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($adaTestimoni);
    $stmt->fetch();
    $stmt->close();

    if ($adaTestimoni === 0) {
        header("Location: komentar.php?error=Testimoni tidak ditemukan");
        exit;
    }

    $stmt = $conn->prepare("DELETE FROM testimoni WHERE komentar_id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        header("Location: komentar.php?success=Berhasil menghapus testimoni");
    } else {
        error_log("Gagal hapus testimoni: " . $stmt->error);
        header("Location: komentar.php?error=Gagal menghapus testimoni");
    }
    exit;
}

// Hapus komentar
if (isset($_GET['hapus_komentar'])) {
    $id = (int) $_GET['hapus_komentar'];

    // Cek apakah komentar ada
    $stmt = $conn->prepare("SELECT COUNT(*) FROM komentar WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($komentarAda);
    $stmt->fetch();
    $stmt->close();

    if ($komentarAda === 0) {
        header("Location: komentar.php?error=Komentar tidak ditemukan");
        exit;
    }

    // Hapus testimoni terkait (jika ada)
    $stmt = $conn->prepare("DELETE FROM testimoni WHERE komentar_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute(); // Tidak masalah jika tidak ada (no error)

    // Hapus komentar
    $stmt = $conn->prepare("DELETE FROM komentar WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        header("Location: komentar.php?success=Berhasil menghapus komentar");
    } else {
        error_log("Gagal hapus komentar: " . $stmt->error);
        header("Location: komentar.php?error=Gagal menghapus komentar");
    }
    exit;
}
?>
