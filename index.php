<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Perpustakaan Pribadi</title>
  <link rel="stylesheet" href="assets/style.css">

</head>

<body>
  <?php
  if (isset($_GET['pesan'])) {
    if ($_GET['pesan'] == 'gagal') {
      echo "<div class='alert error'>Username atau Password salah!</div>";
    } elseif ($_GET['pesan'] == 'success') {
      echo "<div class='alert success'>Registrasi berhasil! Silakan login.</div>";
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
      <input type="submit" class="btnLogin" value="LOGIN">
    </form>
    <p>Apa? Belum punya Akun? <a href="register.php">Yuk daftar di sini</a></p>
  </div>
</body>

</html>