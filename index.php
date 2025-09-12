<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Perpustakaan Pribadi</title>
  <link rel="stylesheet" href="styles/style.css">

</head>

<body>
  <?php
  if (isset($_GET['pesan'])) {
    if ($_GET['pesan'] == 'gagal') {
      echo "<div class='alert'>Username atau Password salah!</div>";
    } elseif ($_GET['pesan'] == 'success') {
      echo "<div class='success'>Akun berhasil dibuat! Silakan login.</div>";
    } elseif ($_GET['pesan'] == 'password_mismatch') {
      echo "<div class='alert'>Password dan konfirmasi password tidak cocok!</div>";
    }
  }
  ?>
  <div class="halaman_login">
    <p class="teks_login">Yuk login</p>
    <form action="cek_login.php" method="post">
      <label for="username">Username</label>
      <input type="text" name="username" placeholder="Masukkan Username" class="form_login" required>
      <label for="password">Password</label>
      <input type="password" name="password" placeholder="Masukkan Password" class="form_login" required>
      <label for="confirm_password">Konfirmasi Password</label>
      <input type="password" name="confirm_password" placeholder="Konfirmasi Password" class="form_login" required>
      <input type="submit" class="btnLogin" value="LOGIN">
    </form>
  </div>
</body>

</html>