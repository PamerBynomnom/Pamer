<?php
include 'service/tentangkami-logic.php';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami - Pisang Naga Lumer</title>
    <link rel="icon" type="image/png" href="images/logo.png" />
    <link rel="stylesheet" href="css/style.css?v=<?= time(); ?>" />


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<div class="chat-toggle" id="chatToggle">
    <i class="fas fa-comment-alt" id="chatIcon"></i>
    <span id="chatLabel">Contact Us</span>
  </div>

  <!-- Popup Ikon Sosial Media -->
  <div class="popup-social" id="popupSocial">
    <a
      href="https://wa.me/6287814966531?text=Halo%20Nom%20Nom!%20Saya%20ingin%20pesan%20Pisang%20Naga%20Lumer"
      target="_blank"
      class="social-icon"
    >
      <i class="fab fa-whatsapp"></i>
    </a>
    <a
      href="https://www.instagram.com/pamerinajaa?igsh=MWxzcTY5OHN6amJzZQ=="
      target="_blank"
      class="social-icon instagram"
    >
      <i class="fab fa-instagram"></i>
    </a>
    <a
      href="https://www.facebook.com/nomnom.pisang"
      target="_blank"
      class="social-icon facebook"
    >
      <i class="fab fa-facebook-f"></i>
    </a>
  </div>
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
                    <li><a href="pesan">Menu</a></li>
                    <li><a href="tentangkami" class="active">Tentang Kami</a></li>
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

    <main class="about-us-container">

        <section class="our-story">
            <div class="story-content">
                <div class="story-image">
                    <img src="images/logo.png" alt="Pemilik Nom Nom">
                </div>
                <div class="story-text">
                    <h2 class="section-title">Cerita di Balik Nom Nom</h2>
                    <p>Berawal dari resep warisan keluarga dan kecintaan kami pada jajanan lokal berkualitas, Nom Nom
                        lahir di jantung kota Makassar. Kami percaya bahwa makanan sederhana seperti pisang goreng bisa
                        menjadi istimewa jika dibuat dengan hati.</p>
                    <p>Setiap pisang kami pilih dengan teliti dan diolah dengan bahan-bahan terbaik untuk memastikan
                        setiap gigitan memberikan pengalaman "lumer" yang tak terlupakan. Terima kasih telah menjadi
                        bagian dari perjalanan kami!</p>
                </div>
            </div>
        </section>

        <section class="photo-gallery">
            <h2 class="section-title">Galeri Nom Nom</h2>
            <div class="gallery-grid">
                <img src="images/pesan1.png" alt="Foto Produk 1">
                <img src="images/pesan2.png" alt="Foto Produk 2">
                <img src="images/pesan3.png" alt="Foto Produk 3">
                <img src="images/pesan4.png" alt="Foto Produk 4">
            </div>
        </section>

        <section class="opening-hours">
            <h2 class="section-title">Jam Buka Kami</h2>
            <div class="hours-card">
                <i class="fas fa-clock"></i>
                <ul>
                    <li><span>Senin - Jumat</span> <span>10:00 - 22:00 WITA</span></li>
                    <li><span>Sabtu</span> <span>10:00 - 23:00 WITA</span></li>
                    <li><span>Minggu</span> <span>Tutup</span></li>
                </ul>
            </div>
        </section>

        <section class="meet-the-team">
            <h2 class="section-title">Temui Tim Kami</h2>
            <div class="team-grid">
                <div class="team-member">
                    <img src="images/helmy.jpg" alt="Foto Pemilik">
                    <h3>Helmy Ahmed</h3>
                    <h4>Ketua Tim</h4>
                </div>
                <div class="team-member">
                    <img src="images/citra.jpg" alt="Foto Citra Putri Amalia">
                    <h3>Citra Putri Amalia</h3>
                    <h4>Kepala Dapur & Quality Control</h4>
                </div>
                <div class="team-member">
                    <img src="images/aul.jpg" alt="Foto Aulia">
                    <h3>Andi Isratul Aulia AM</h3>
                    <h4>Manajer Pelayanan & Media Sosial</h4>
                </div>
                <div class="team-member">
                    <img src="images/afif.jpg" alt="Foto Muhammad Afif">
                    <h3>Muhammad Afif Aufar Abshar</h3>
                    <h4>Manajer Operasional</h4>
                </div>
                <div class="team-member">
                    <img src="images/farid.jpg" alt="Foto Muhammad Farid">
                    <h3>Muhammad Farid Irsyadillah</h3>
                    <h4>Pengembangan Bisnis & Teknologi</h4>
                </div>
            </div>
        </section>
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
      const chatToggle = document.getElementById("chatToggle");
      const popupSocial = document.getElementById("popupSocial");
      const chatIcon = document.getElementById("chatIcon");
      const chatLabel = document.getElementById("chatLabel");

      let isOpen = false;

      chatToggle.addEventListener("click", () => {
        isOpen = !isOpen;

        if (isOpen) {
          popupSocial.style.display = "flex"; // Vertical susun
          chatIcon.classList.remove("fa-comment-alt");
          chatIcon.classList.add("fa-times");
          chatLabel.textContent = "Tutup";
        } else {
          popupSocial.style.display = "none";
          chatIcon.classList.remove("fa-times");
          chatIcon.classList.add("fa-comment-alt");
          chatLabel.textContent = "Contact Us";
        }
      });

      // ✅ Pastikan popup disembunyi saat pertama load
      window.addEventListener("DOMContentLoaded", function () {
        popupSocial.style.display = "none";
      });
    </script>
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