<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Masuk atau Daftar - Nom Nom</title>
     <link rel="icon" type="image/png" href="images/logo.png" />
    <link rel="stylesheet" href="css/style.css?v=<?= time(); ?>" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
        rel="stylesheet" />
</head>

<body class="login-page-body">

    <div class="login-container">

        <div class="login-box">
            <div class="logo-login">
                <a href="index.php"><img src="images/logo.png" alt="Nom Nom Logo" /></a>
            </div>

            <!-- Pesan Sukses / Error -->
            <?php if (isset($_GET['error'])): ?>
                <p style="color: red; text-align: center;"><?= htmlspecialchars($_GET['error']) ?></p>
            <?php elseif (isset($_GET['success'])): ?>
                <p style="color: green; text-align: center;"><?= htmlspecialchars($_GET['success']) ?></p>
            <?php endif; ?>

            <!-- Form Login -->
            <div class="form-wrapper" id="login-form">
                <h2>Selamat Datang Kembali</h2>
                <p>Silakan masuk untuk melanjutkan pesanan Anda.</p>
                <form id="form-login" action="service/login-logic.php" method="POST">
                    <input type="hidden" name="login" value="1" />
                    <div class="form-group">
                        <label for="login-email">Email</label>
                        <input type="email" id="login-email" name="login_email" required />
                    </div>
                    <div class="form-group">
                        <label for="login-password">Password</label>
                        <input type="password" id="login-password" name="login_password" required />
                    </div>
                    <button type="submit" class="order-button full-width">Masuk</button>
                </form>
                <p class="toggle-form">Belum punya akun? <a href="#" id="show-register">Daftar di sini</a></p>
            </div>

            <!-- Form Register -->
            <div class="form-wrapper hidden" id="register-form">
                <h2>Buat Akun Baru</h2>
                <p>Cukup dengan email untuk memulai.</p>
                <form id="form-registrasi-action" action="service/login-logic.php" method="POST">
                    <input type="hidden" name="register" value="1" />
                    <div class="form-group">
                        <label for="register-name">Nama Lengkap</label>
                        <input type="text" id="register-name" name="register_name" required />
                    </div>
                    <div class="form-group">
                        <label for="register-email">Email</label>
                        <input type="email" id="register-email" name="register_email" required />
                    </div>
                    <div class="form-group">
                        <label for="register-password">Buat Password</label>
                        <input type="password" id="register-password" name="register_password" required />
                    </div>
                    <div class="form-group">
                        <label for="confirm-password">Konfirmasi Ulang Password</label>
                        <input type="password" id="confirm-password" name="confirm_password" required />
                    </div>
                    <button type="submit" class="order-button full-width">Daftar</button>
                </form>
                <p class="toggle-form">Sudah punya akun? <a href="#" id="show-login">Masuk di sini</a></p>
            </div>
        </div>

    </div>

    <script>
        // Toggle antara form login dan register
        const showRegister = document.getElementById('show-register');
        const showLogin = document.getElementById('show-login');
        const loginForm = document.getElementById('login-form');
        const registerForm = document.getElementById('register-form');

        showRegister.addEventListener('click', (e) => {
            e.preventDefault();
            loginForm.classList.add('hidden');
            registerForm.classList.remove('hidden');
        });

        showLogin.addEventListener('click', (e) => {
            e.preventDefault();
            registerForm.classList.add('hidden');
            loginForm.classList.remove('hidden');
        });

        // Validasi konfirmasi password saat registrasi
        const formRegistrasi = document.getElementById('form-registrasi-action');
        const passwordInput = document.getElementById('register-password');
        const confirmPasswordInput = document.getElementById('confirm-password');

        formRegistrasi.addEventListener('submit', function (event) {
            if (passwordInput.value !== confirmPasswordInput.value) {
                alert('Password dan Konfirmasi Password tidak cocok!');
                event.preventDefault();
            }
        });
    </script>

</body>

</html>