<?php
require_once '../service/auth.php';
onlyAdmin();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="images/logo.png" />
    <title>Dashboard Admin - Nom Nom</title>
    <link rel="stylesheet" href="../css/dashboard_style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>

    <header class="admin-header">
        <div class="container">
            <h1>Admin Panel - Nom Nom</h1>
            <button class="hamburger" id="hamburgerBtn">
                <i class="fas fa-bars"></i>
            </button>
            <nav id="adminNav">
                <ul>
                    <li><a href="#" class="active"><i class="fas fa-home"></i> Dashboard</a></li>
                    <li><a href="menu.php"><i class="fas fa-utensils"></i> Menu</a></li>
                    <li><a href="komentar.php"><i class="fas fa-comments"></i> Komentar</a></li>
                    <li><a href="users.php"><i class="fas fa-users"></i> Pengguna</a></li>
                    <li><a href="../service/logout.php"><i class="fas fa-sign-out-alt"></i> Keluar</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="dashboard-main">
        <div class="container">
            <h2>Selamat Datang, Admin!</h2>

            <div class="dashboard-cards">
             <a href="../index" class="card">
                    <i class="fas fa-home"></i>
                    <div>
                        <h3>Halaman Utama</h3>
                        <p>Kembali ke halaman utama</p>
                    </div>
                </a>

            <a href="menu.php" class="card">
                    <i class="fas fa-utensils"></i>
                    <div>
                        <h3>Kelola Menu</h3>
                        <p>Tambah, ubah, atau hapus produk</p>
                    </div>
                </a>

                <a href="komentar.php" class="card">
                    <i class="fas fa-comments"></i>
                    <div>
                        <h3>Kelola Komentar</h3>
                        <p>Kelola testimoni dan ulasan</p>
                    </div>
                </a>

                <a href="users.php" class="card">
                    <i class="fas fa-users"></i>
                    <div>
                        <h3>Kelola Pengguna</h3>
                        <p>Data user dan admin</p>
                    </div>
                </a>
            </div>
        </div>
    </main>

    <script>
        const hamburgerBtn = document.getElementById("hamburgerBtn");
        const nav = document.getElementById("adminNav");

        hamburgerBtn.addEventListener("click", () => {
            nav.classList.toggle("show");
        });
    </script>

</body>

</html>