<?php
session_start();
if (!isset($_SESSION['username'])) {
  header("location:index.php");
  exit();
}

require_once 'includes/koneksi.php';
include_once 'headerFooter/header.php';

$username = $_SESSION['username'];
$user_result = mysqli_query($conn, "SELECT id FROM user WHERE username = '$username'");
$user = mysqli_fetch_assoc($user_result);
$user_id = $user['id'];

$result = mysqli_query($conn, "SELECT * FROM aktivitas WHERE user_id = $user_id ORDER BY waktu DESC");
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Riwayat Aktivitas</title>
  <link rel="stylesheet" href="assets/style.css">
</head>

<body>
  <div class="container">
    <h1>Riwayat Aktivitas <?php echo $_SESSION['username']; ?>!</h1>
    <ul class="aktivitas-list">
      <?php
      while ($row = mysqli_fetch_assoc($result)) {
        echo "<li>
          Kamu melakukan <strong>{$row['aksi']}</strong> pada buku <em>{$row['judul_buku']}</em> — " . date("d M Y H:i", strtotime($row['waktu'])) . "
          <a href='hapus_history.php?id={$row['id']}' onclick='return confirm(\"Apakah kamu yakin menghapus history ini?\")'>Hapus</a>
        </li>";
      }
      ?>
    </ul>
  </div>
  <?php
  include_once 'headerFooter/footer.php';
  ?>

</body>

</html>