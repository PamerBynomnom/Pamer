<?php
require_once '../service/komentar-logic.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Komentar - Admin</title>
     <link rel="icon" type="image/png" href="images/logo.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/komentar-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<!-- HEADER -->
<header class="admin-header">
  <div class="container">
    <h1>Admin Panel - Nom Nom</h1>
    <button class="hamburger" id="hamburgerBtn">
      <i class="fas fa-bars"></i>
    </button>
    <nav id="adminNav">
      <ul>
        <li><a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a></li>
        <li><a href="menu.php"><i class="fas fa-utensils"></i> Menu</a></li>
        <li><a href="#" class="active"><i class="fas fa-comments"></i> Komentar</a></li>
        <li><a href="users.php"><i class="fas fa-users"></i> Pengguna</a></li>
        <li><a href="../service/logout.php"><i class="fas fa-sign-out-alt"></i> Keluar</a></li>
      </ul>
    </nav>
  </div>
</header>

<!-- MAIN CONTENT -->
<main class="komentar-main">
    <section class="welcome-box">
        <h2>💬 Kelola Komentar & Testimoni</h2>
        <p>Lihat, tampilkan, atau sembunyikan testimoni pelanggan.</p>
    </section>

    <!-- NOTIFIKASI -->
    <?php if (isset($_GET['success'])): ?>
        <div class="alert success"><?= htmlspecialchars($_GET['success']) ?></div>
    <?php elseif (isset($_GET['error'])): ?>
        <div class="alert error"><?= htmlspecialchars($_GET['error']) ?></div>
    <?php endif; ?>

    <section class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Lokasi</th>
                    <th>Pesan</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($komentar as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['nama']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= htmlspecialchars($row['lokasi']) ?></td>
                        <td><?= htmlspecialchars($row['pesan']) ?></td>
                        <td><?= htmlspecialchars($row['tanggal_kirim']) ?></td>
                        <td>
                            <?php if (in_array($row['id'], $testimoniIDs)): ?>
                                <span class="status show">Ditampilkan</span>
                            <?php else: ?>
                                <span class="status hide">Disembunyikan</span>
                            <?php endif; ?>
                        </td>
                        <td class="table-actions">
                            <?php if (in_array($row['id'], $testimoniIDs)): ?>
                                <a href="?hapus_testimoni=<?= $row['id'] ?>" onclick="return confirm('Sembunyikan testimoni ini?')">
                                    <button>Sembunyikan</button>
                                </a>
                            <?php else: ?>
                                <a href="?tampilkan=<?= $row['id'] ?>" onclick="return confirm('Tampilkan testimoni ini?')">
                                    <button>Tampilkan</button>
                                </a>
                            <?php endif; ?>
                            <a href="?hapus_komentar=<?= $row['id'] ?>" onclick="return confirm('Hapus komentar ini?')">
                                <button>Hapus</button>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</main>

<script>
  const hamburgerBtn = document.getElementById("hamburgerBtn");
  const nav = document.getElementById("adminNav");

  hamburgerBtn.addEventListener("click", () => {
    nav.classList.toggle("show");
  });
</script>

<style>
    .alert.success {
        background-color: #d4edda;
        color: #155724;
        padding: 10px;
        margin: 10px 0;
        border-left: 5px solid #28a745;
        border-radius: 4px;
    }
    .alert.error {
        background-color: #f8d7da;
        color: #721c24;
        padding: 10px;
        margin: 10px 0;
        border-left: 5px solid #dc3545;
        border-radius: 4px;
    }
</style>

</body>
</html>
