<?php include 'service/user-profile-logic.php'; ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit Profil - Nom Nom</title>
     <link rel="icon" type="image/png" href="images/logo.png" />
    <link rel="stylesheet" href="css/style.css?v=<?= time(); ?>" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>
    <header>
        <div class="navbar-container">
            <div class="logo">
                <a href="index.php"><img src="images/logo.png" alt="Nom Nom" /></a>
            </div>
            <button class="hamburger" onclick="toggleMenu()">☰</button>
            <nav id="nav-menu">
                <ul>
                    <li><a href="index">Beranda</a></li>
                    <li><a href="pesan">Menu</a></li>
                    <li><a href="tentangkami">Tentang Kami</a></li>
                    <?php if ($isLoggedIn): ?>
                        <li class="profile-dropdown">
                            <a href="#" class="dropdown-toggle">
                                <img src="images/avatar-default.png" alt="Avatar" class="avatar-header">
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="user-profile.php"><i class="fas fa-user-circle"></i> Profil Saya</a></li>

                                <?php if ($_SESSION['role'] === 'admin'): ?>
                                    <li><a href="admin/dashboard.php"><i class="fas fa-tools"></i> Maintenance</a></li>
                                <?php endif; ?>

                                <li><a href="service/logout.php"><i class="fas fa-sign-out-alt"></i> Keluar</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li><a href="login">Masuk</a></li>
                    <?php endif; ?>

                </ul>
            </nav>
        </div>
    </header>

    <main>
        <div class="edit-profile-container">
            <h1>Edit Profil</h1>

            <?php if (!empty($errors)): ?>
                <div class="form-errors">
                    <ul>
                        <?php foreach ($errors as $e): ?>
                            <li><?= htmlspecialchars($e) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form class="profile-form-new" method="POST">
                <input type="hidden" name="profile_update" value="1" />
                <div class="form-grid">
                    <div class="form-group">
                        <label for="first-name">Nama Depan</label>
                        <input type="text" id="first-name" name="first-name"
                            value="<?= htmlspecialchars($firstName ?? '') ?>" required />
                    </div>
                    <div class="form-group">
                        <label for="last-name">Nama Belakang</label>
                        <input type="text" id="last-name" name="last-name"
                            value="<?= htmlspecialchars($lastName ?? '') ?>" required />
                    </div>
                    <div class="form-group grid-col-span-2">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email"
                            value="<?= htmlspecialchars($user['email'] ?? '') ?>" disabled />
                    </div>
                    <div class="form-group grid-col-span-2">
                        <label for="phone">Nomor Kontak</label>
                        <input type="tel" id="phone" name="phone"
                            value="<?= htmlspecialchars($user['phone'] ?? '') ?>" />
                    </div>
                    <div class="form-group grid-col-span-2">
                        <label for="address">Alamat</label>
                        <input type="text" id="address" name="address"
                            value="<?= htmlspecialchars($user['address'] ?? '') ?>" />
                    </div>
                    <div class="form-group">
                        <label for="city">Kota</label>
                        <input type="text" id="city" name="city" value="<?= htmlspecialchars($user['city'] ?? '') ?>" />
                    </div>
                    <div class="form-group">
                        <label for="state">Provinsi</label>
                        <input type="text" id="state" name="state"
                            value="<?= htmlspecialchars($user['state'] ?? '') ?>" />
                    </div>
                    <div class="form-group grid-col-span-2">
                        <label for="password">Password Baru</label>
                        <div class="password-wrapper">
                            <input type="password" id="password" name="password"
                                placeholder="Kosongkan jika tidak ingin ubah password" />
                            <i class="fas fa-eye"></i>
                        </div>
                    </div>
                    <div class="form-group grid-col-span-2">
                        <label for="confirm_password">Konfirmasi Password Baru</label>
                        <div class="password-wrapper">
                            <input type="password" id="confirm_password" name="confirm_password"
                                placeholder="Ulangi password baru" />
                            <i class="fas fa-eye"></i>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="order-button">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </main>

<footer style="background-color: #1f1f1f; color: #fff;" class="pt-5 pb-4">
    <div class="container">
        <div class="row g-5">
            <!-- Kontak -->
            <div class="col-md-4">
                <h5 class="mb-3">Hubungi Kami</h5>
                <p>Kami siap melayani Anda untuk pemesanan maupun pertanyaan lainnya.</p>
                <ul class="list-unstyled">
                    <li class="mb-2"><i class="fas fa-map-marker-alt me-2"></i>Romangpolong, Kec. Somba Opu, Kabupaten Gowa, Sulawesi Selatan 92113</li>
                    <li class="mb-2"><i class="fas fa-phone me-2"></i>+62 878-1496-6531</li>
                    <li><i class="fas fa-envelope me-2"></i>pamerbynomnom@gmail.com</li>
                </ul>
            </div>

            <!-- Form Kontak -->
            <div class="col-md-4">
                <h5 class="mb-3">Kirim Pesan</h5>
                <?php if (!isset($_SESSION['user_id'])): ?>
                    <div class="alert alert-warning">
                        Silakan <a href="login.php" class="alert-link">login</a> untuk mengirim pesan.
                    </div>
                <?php else: ?>
                    <form method="POST" action="">
                        <div class="mb-2">
                            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($_SESSION['name']) ?>" readonly>
                        </div>
                        <div class="mb-2">
                            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($_SESSION['email']) ?>" readonly>
                        </div>
                        <div class="mb-2">
                            <input type="text" name="lokasi" class="form-control" placeholder="Lokasi Anda" required>
                        </div>
                        <div class="mb-2">
                            <textarea name="message" rows="4" class="form-control" placeholder="Pesan Anda..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-warning">Kirim</button>

                        <?php if (!empty($success)): ?>
                            <div class="alert alert-success mt-2"><?= htmlspecialchars($success) ?></div>
                        <?php elseif (!empty($error)): ?>
                            <div class="alert alert-danger mt-2"><?= htmlspecialchars($error) ?></div>
                        <?php endif; ?>
                    </form>
                <?php endif; ?>
            </div>

            <!-- Map -->
            <div class="col-md-4">
                <h5 class="mb-3 text-center text-md-start">Lokasi Kami</h5>
                <div class="ratio ratio-4x3">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15893.395535471778!2d119.4910317132719!3d-5.207747816666118!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dbee3a5ea1e9597%3A0xc10c1bdeb15834af!2sPondok%20Nur%20Alifah!5e0!3m2!1sid!2sid!4v1751812878161!5m2!1sid!2sid"
                        width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>

        <!-- Copyright -->
        <div class="text-center pt-4 mt-4 border-top border-secondary">
            <p class="mb-0 text-secondary">&copy; 2025 Nom Nom. All Rights Reserved.</p>
        </div>
    </div>
</footer>


    <script>
        function toggleMenu() {
            document.getElementById("nav-menu").classList.toggle("show");
        }
    </script>
        <script>
  document.addEventListener("DOMContentLoaded", function () {
    const avatarToggle = document.querySelector('.dropdown-toggle');
    const dropdownMenu = document.querySelector('.dropdown-menu');

    if (avatarToggle && dropdownMenu) {
      avatarToggle.addEventListener('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        dropdownMenu.classList.toggle('show');
      });

      document.addEventListener('click', function () {
        dropdownMenu.classList.remove('show');
      });
    }
  });
</script>

</body>

</html>