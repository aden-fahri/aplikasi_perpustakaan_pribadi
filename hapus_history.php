<?php
session_start();
if (!isset($_SESSION['username'])) {
  header("location:index.php");
  exit();
}

require_once 'includes/koneksi.php';

$username = $_SESSION['username'];
$user_result = mysqli_query($conn, "SELECT id FROM user WHERE username = '$username'");
$user = mysqli_fetch_assoc($user_result);
$user_id = $user['id'];

// mengabil id dari url / GET
if (!isset($_GET['id'])) {
  echo "<p>ID buku tidak ditemukan</p>";
  exit;
}

$id_aktivitas = intval($_GET['id']);

// data dari buku
$result = mysqli_query($conn, "SELECT * FROM aktivitas WHERE id = $id_aktivitas AND user_id = $user_id");
if (mysqli_num_rows($result) == 0) {
  echo "<p>History tidak ditemukan</p>";
  exit;
}

// hapus data dari database
mysqli_query($conn, "DELETE FROM aktivitas WHERE id = $id_aktivitas AND user_id = $user_id");

mysqli_close($conn);
header("Location: history.php");
exit;
