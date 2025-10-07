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

$id_buku = intval($_GET['id']);

// data dari buku
$result = mysqli_query($conn, "SELECT * FROM buku WHERE id = $id_buku AND user_id = $user_id");
if (mysqli_num_rows($result) == 0) {
  echo "<p>Buku tidak ditemukan</p>";
  exit;
}

$buku = mysqli_fetch_assoc($result);

// menghapus gambar jika ada
if (!empty($buku['gambar']) && file_exists($buku['gambar'])) {
  unlink($buku['gambar']);
}

// Hapus file PDF jika ada
if (!empty($buku['file_pdf']) && file_exists($buku['file_pdf'])) {
  unlink($buku['file_pdf']);
}

// hapus data dari database
mysqli_query($conn, "DELETE FROM buku WHERE id = $id_buku AND user_id = $user_id");

mysqli_query($conn, "INSERT INTO aktivitas (user_id, aksi, judul_buku) VALUES ('$user_id', 'hapus', '$buku[judul]')");

mysqli_close($conn);
header("Location: buku.php");
exit;
