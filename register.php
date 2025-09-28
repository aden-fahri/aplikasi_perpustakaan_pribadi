<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - Perpustakaan Pribadi</title>
  <link rel="stylesheet" href="assets/style.css">

</head>

<body>
  <?php
  if (isset($_GET['pesan'])) {
    if ($_GET['pesan'] == 'username_taken') {
      echo "<div class='alert error'>Username sudah digunakan!</div>";
    } elseif ($_GET['pesan'] == 'success') {
      echo "<div class='alert success'>Akun berhasil dibuat! Silakan <a href='index.php'>Login</a>.</div>";
    } elseif ($_GET['pesan'] == 'password_mismatch') {
      echo "<div class='alert error'>Password dan konfirmasi password tidak cocok!</div>";
    } elseif ($_GET['pesan'] == 'error') {
      echo "<div class='alert error'>Terjadi kesalahan saat register!</div>";
    } elseif ($_GET['pesan'] == 'gagal') {
      echo "<div class='alert error'>Username atau Password tidak boleh kosong!</div>";
    }
  }
  ?>
  <div class="halaman_register">
    <p class="teks_register">Yuk Daftar</p>
    <form action="cek_register.php" method="post">
      <label for="username">Username</label>
      <input type="text" name="username" placeholder="Masukkan Username" class="form_login" required>
      <label for="password">Password</label>
      <input type="password" name="password" placeholder="Masukkan Password" class="form_login" required>
      <label for="confirm_password">Konfirmasi Password</label>
      <input type="password" name="confirm_password" placeholder="Konfirmasi Password" class="form_login" required>
      <input type="submit" class="btnRegister" value="REGISTER">
    </form>
    <p>Sudah punya Akun? <a href="index.php">Login saja di sini</a></p>
  </div>
</body>

</html>