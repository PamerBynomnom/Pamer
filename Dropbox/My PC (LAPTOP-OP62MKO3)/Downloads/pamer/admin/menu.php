<?php
require_once '../service/menu-logic.php';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <title>Kelola Menu - Admin</title>
     <link rel="icon" type="image/png" href="images/logo.png" />
    <link rel="stylesheet" href="../css/menu.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>
<header class="admin-header">
  <div class="container">
    <div class="header-flex">
      <h1>Admin Panel - Nom Nom</h1>
      <button class="hamburger" id="hamburgerBtn">
        <i class="fas fa-bars"></i>
      </button>
    </div>
    <nav id="adminNav">
      <ul>
        <li><a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a></li>
        <li><a href="#" class="active"><i class="fas fa-utensils"></i> Menu</a></li>
        <li><a href="komentar.php"><i class="fas fa-comments"></i> Komentar</a></li>
        <li><a href="users.php"><i class="fas fa-users"></i> Pengguna</a></li>
        <li><a href="../service/logout.php"><i class="fas fa-sign-out-alt"></i> Keluar</a></li>
      </ul>
    </nav>
  </div>
</header>

    <main>
        <h2>Kelola Menu Produk</h2>

        <!-- NOTIFIKASI -->
        <?php if (isset($_GET['success'])): ?>
            <div class="alert success"><?= htmlspecialchars($_GET['success']) ?></div>
        <?php elseif (isset($_GET['error'])): ?>
            <div class="alert error"><?= htmlspecialchars($_GET['error']) ?></div>
        <?php endif; ?>

        <!-- Form Tambah/Edit Menu -->
        <form id="formMenu" action="../service/menu-logic.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" id="menu-id" value="">
            <input type="text" name="nama" id="menu-nama" placeholder="Nama Menu" required>
            <input type="text" name="deskripsi" id="menu-deskripsi" placeholder="Deskripsi Menu" required>
            <input type="number" name="harga" id="menu-harga" placeholder="Harga (Rp)" required>
            <input type="file" name="gambar" id="menu-gambar" accept="image/*">
            <input type="text" name="kategori" id="menu-kategori" placeholder="Kategori" value="Pisang Lumer" required>
            <button type="submit">Simpan Menu</button>
        </form>

        <!-- Tabel Menu -->
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Deskripsi</th>
                    <th>Harga</th>
                    <th>Kategori</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($menus as $menu): ?>
                    <tr>
                        <td><?= htmlspecialchars($menu['nama']) ?></td>
                        <td><?= htmlspecialchars($menu['deskripsi']) ?></td>
                        <td>Rp <?= number_format($menu['harga'], 0, ',', '.') ?></td>
                        <td><?= htmlspecialchars($menu['kategori']) ?></td>
                        <td><img src="../<?= htmlspecialchars($menu['gambar']) ?>"
                                alt="<?= htmlspecialchars($menu['nama']) ?>" width="60"></td>
                        <td class="table-actions">
                            <button onclick="editMenu(
                            '<?= $menu['id'] ?>',
                            '<?= htmlspecialchars($menu['nama'], ENT_QUOTES) ?>',
                            '<?= htmlspecialchars($menu['deskripsi'], ENT_QUOTES) ?>',
                            '<?= $menu['harga'] ?>',
                            '<?= htmlspecialchars($menu['kategori'], ENT_QUOTES) ?>'
                        )">Edit</button>
                            <a href="../service/menu-logic.php?delete=<?= $menu['id'] ?>"
                                onclick="return confirm('Yakin ingin menghapus menu ini?')">
                                <button>Hapus</button>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>

    <script>
        function editMenu(id, nama, deskripsi, harga, kategori) {
            document.getElementById("menu-id").value = id;
            document.getElementById("menu-nama").value = nama;
            document.getElementById("menu-deskripsi").value = deskripsi;
            document.getElementById("menu-harga").value = harga;
            document.getElementById("menu-kategori").value = kategori;
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    </script>

    <script>
        document.getElementById("hamburgerBtn").addEventListener("click", function () {
            document.getElementById("adminNav").classList.toggle("show");
        });
    </script>
</body>

</html>