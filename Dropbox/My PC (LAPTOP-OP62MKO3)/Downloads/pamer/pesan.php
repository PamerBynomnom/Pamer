<?php include 'service/pesan-logic.php'; ?>

<!DOCTYPE html>
<html lang="id">

<head7
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan Makanan - Nom Nom</title>
     <link rel="icon" type="image/png" href="images/logo.png" />
    <link rel="stylesheet" href="css/style.css?v=<?= time(); ?>" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>
    <header>
        <div class="navbar-container">
            <div class="logo">
                <img src="images/logo.png" alt="Nom Nom" />
            </div>
            <button class="hamburger" onclick="toggleMenu()">☰</button>
            <nav id="nav-menu">
                <ul>
                    <li><a href="index">Beranda</a></li>
                    <li><a href="pesan" class="active">Menu</a></li>
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

    <div class="pesan-page-layout">
        <main class="main-content">
            <div class="container">
                <h1>Menu Pilihan Kami</h1>
            </div>

            <div class="container menu-category-title">
                <h2>Pisang Lumer</h2>
            </div>

            <div class="container product-grid">
                <?php foreach ($menus as $menu): ?>
                    <div class="product-card">
                        <div class="card-details">
                            <h3><?= htmlspecialchars($menu['nama']) ?></h3>
                            <p class="description"><?= htmlspecialchars($menu['deskripsi']) ?></p>
                            <p class="price">Rp <?= number_format($menu['harga'], 0, ',', '.') ?></p>
                        </div>
                        <div class="card-image-container">
                            <img src="<?= htmlspecialchars($menu['gambar']) ?>"
                                alt="<?= htmlspecialchars($menu['nama']) ?>">
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="pesan-wa-highlight">
                <a href="https://wa.me/6287814966531?text=Halo%20Nom%20Nom!%20Saya%20ingin%20memesan%20menu%20Pisang%20Lumer"
                    target="_blank">
                    <i class="fab fa-whatsapp"></i> Pesan Sekarang via WhatsApp
                </a>
            </div>
        </main>
    </div>

    <div class="leaves-bg"></div>

    <div class="chat-toggle" id="chatToggle">
        <i class="fas fa-comment-alt" id="chatIcon"></i>
        <span id="chatLabel">Contact Us</span>
    </div>

    <div class="popup-social" id="popupSocial">
        <a href="https://wa.me/6287814966531?text=Halo%20Nom%20Nom!%20Saya%20ingin%20pesan%20Pisang%20Naga%20Lumer"
            target="_blank" class="social-icon">
            <i class="fab fa-whatsapp"></i>
        </a>
        <a href="https://www.instagram.com/pamerinajaa" target="_blank" class="social-icon instagram">
            <i class="fab fa-instagram"></i>
        </a>
        <a href="https://www.facebook.com/nomnom.pisang" target="_blank" class="social-icon facebook">
            <i class="fab fa-facebook-f"></i>
        </a>
    </div>

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
        const chatToggle = document.getElementById('chatToggle');
        const popupSocial = document.getElementById('popupSocial');
        const chatIcon = document.getElementById('chatIcon');
        const chatLabel = document.getElementById('chatLabel');
        let isOpen = false;

        chatToggle.addEventListener('click', () => {
            isOpen = !isOpen;
            popupSocial.style.display = isOpen ? 'flex' : 'none';
            chatIcon.classList.toggle('fa-comment-alt');
            chatIcon.classList.toggle('fa-times');
            chatLabel.textContent = isOpen ? 'Tutup' : 'Contact Us';
        });

        window.addEventListener("DOMContentLoaded", function () {
            popupSocial.style.display = 'none';
        });

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