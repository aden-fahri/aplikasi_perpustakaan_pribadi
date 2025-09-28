<?php
session_start();
include_once("includes/koneksi.php");

// Validasi input
if (!isset($_POST['username'], $_POST['password'])) {
  header("Location: index.php?pesan=gagal");
  exit;
}

$username = trim($_POST['username']);
$password = trim($_POST['password']);

if ($username === '' || $password === '') {
  header("Location: index.php?pesan=gagal");
  exit;
}

// Cek apakah user ada dan password cocok
$result = mysqli_query($conn, "SELECT password FROM user WHERE username='$username'");
if (mysqli_num_rows($result) > 0) {
  $user = mysqli_fetch_assoc($result);
  if ($password === $user['password']) {
    $_SESSION['username'] = $username;
    header("Location: dashboard.php");
  } else {
    header("Location: index.php?pesan=gagal");
  }
} else {
  header("Location: index.php?pesan=gagal");
}
exit;
