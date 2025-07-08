<?php
require_once '../service/user-logic.php'; 
onlyAdmin();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Kelola Pengguna Admin - Nom Nom</title>
   <link rel="icon" type="image/png" href="images/logo.png" />
  <link rel="stylesheet" href="../css/user.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<header class="admin-header">
  <div class="container">
    <h1>Admin Panel - Nom Nom</h1>
    <button class="hamburger" id="hamburgerBtn"><i class="fas fa-bars"></i></button>
    <nav id="adminNav">
      <ul>
        <li><a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a></li>
        <li><a href="menu.php"><i class="fas fa-utensils"></i> Menu</a></li>
        <li><a href="komentar.php"><i class="fas fa-comments"></i> Komentar</a></li>
        <li><a href="users.php" class="active"><i class="fas fa-users"></i> Pengguna</a></li>
        <li><a href="../service/logout.php"><i class="fas fa-sign-out-alt"></i> Keluar</a></li>
      </ul>
    </nav>
  </div>
</header>

<main>
  <h2>Kelola Pengguna</h2>

  <!-- Notifikasi -->
  <?php if (isset($_GET['error'])): ?>
    <div class="alert error"><?= htmlspecialchars($_GET['error']) ?></div>
  <?php elseif (isset($_GET['success'])): ?>
    <div class="alert success"><?= htmlspecialchars($_GET['success']) ?></div>
  <?php endif; ?>

  <!-- Form Tambah/Edit -->
  <form id="formUser" method="post" action="users.php">
    <input type="hidden" name="id" value="">
    <input type="text" name="name" placeholder="Nama Lengkap" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password (kosongkan jika tidak diganti)">
    <select name="role" required>
      <option value="user">User</option>
      <option value="admin">Admin</option>
    </select>
    <button type="submit">Tambah / Simpan</button>
  </form>

  <!-- Tabel User -->
  <div class="table-wrapper">
    <table>
      <thead>
        <tr>
          <th>Nama</th>
          <th>Email</th>
          <th>Role</th>
          <th>Dibuat</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($users as $user): ?>
        <tr>
          <td><?= htmlspecialchars($user['name']) ?></td>
          <td><?= htmlspecialchars($user['email']) ?></td>
          <td><?= htmlspecialchars($user['role']) ?></td>
          <td><?= htmlspecialchars($user['created_at']) ?></td>
          <td class="table-actions">
            <button onclick="editUser('<?= $user['id'] ?>','<?= htmlspecialchars($user['name']) ?>','<?= htmlspecialchars($user['email']) ?>','<?= $user['role'] ?>')">Edit</button>
            <a href="?delete=<?= $user['id'] ?>" onclick="return confirm('Yakin ingin menghapus user ini?')">
              <button class="danger">Hapus</button>
            </a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</main>

<script>
  function editUser(id, name, email, role) {
    const form = document.querySelector('#formUser');
    form.id.value = id;
    form.name.value = name;
    form.email.value = email;
    form.role.value = role;
    form.password.value = '';
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }

  document.getElementById("hamburgerBtn").addEventListener("click", function() {
    document.getElementById("adminNav").classList.toggle("show");
  });
</script>

</body>
</html>
