<?php
session_start();

include_once("config/koneksi.php");

// Buat database dan tabel jika belum ada
mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS login");
mysqli_select_db($conn, 'login');
mysqli_query($conn, "
  CREATE TABLE IF NOT EXISTS user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
  )
");

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

// Cek apakah user sudah ada
$result = mysqli_query($conn, "SELECT password FROM user WHERE username='$username'");
if (mysqli_num_rows($result) > 0) {
  $user = mysqli_fetch_assoc($result);
  if ($password === $user['password']) {
    $_SESSION['username'] = $username;
    header("Location: dashboard.php");
    exit;
  } else {
    header("Location: index.php?pesan=gagal");
    exit;
  }
} else {
  // Registrasi user baru
  $insert = mysqli_query($conn, "INSERT INTO user (username, password) VALUES ('$username', '$password')");
  if ($insert) {
    $_SESSION['username'] = $username;
    header("Location: index.php?pesan=success");
    exit;
  } else {
    header("Location: index.php?pesan=gagal");
    exit;
  }
}
