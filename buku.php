<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Koleksi Buku Saya</title>
  <link rel="stylesheet" href="assets/style.css">
</head>

<body>

  <?php
  session_start();
  if (!isset($_SESSION['username'])) {
    header("location:index.php");
    exit;
  }

  require_once 'includes/koneksi.php';
  include_once 'headerFooter/header.php';

  $username = $_SESSION['username'];
  $user_result = mysqli_query($conn, "SELECT id FROM user WHERE username = '$username'");
  $user = mysqli_fetch_assoc($user_result);
  $user_id = $user['id'];
  ?>

  <div class="container">
    <h1>Koleksi Buku <?php echo $_SESSION['username']; ?>!</h1>
    <a href="tambah_buku.php" class="btnLogin">Tambah Buku</a>

    <form action="buku.php" method="get" class="search">
      <input type="text" name="search" placeholder="Cari Judul Buku kamu" class="form_login">
      <input type="submit" value="Cari" class="btnLogin">
    </form>

    <div class="book-grid">
      <?php
      $search = isset($_GET['search']) ? trim($_GET['search']) : '';
      $query = "SELECT * FROM buku WHERE user_id = $user_id";

      if (!empty($search)) {
        $search = mysqli_real_escape_string($conn, $search);
        $query .= " AND judul LIKE '%$search%'";
      }

      $result = mysqli_query($conn, $query);
      if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
          echo "<div class='book-card'>";
          $gambar = (!empty($row['gambar']) && file_exists($row['gambar'])) ? $row['gambar'] : 'assets/IMAGE NOT FOUND.png';
          echo "<img src='$gambar' alt='Sampul Buku' class='book-cover'>";
          echo "<h3>" . htmlspecialchars($row['judul']) . "</h3>";
          echo "<p>Penulis: " . htmlspecialchars($row['penulis']) . "</p>";
          echo "<p>Penerbit: " . htmlspecialchars($row['penerbit']) . "</p>";
          echo "<p>Tahun Terbit: " . htmlspecialchars($row['tahun_terbit']) . "</p>";
          echo "<p>Status: " . str_replace('_', ' ', $row['status_baca']) . "</p>";
          echo "<p>Catatan: " . htmlspecialchars($row['catatan']) . "</p>";
          echo "<p>
                <a href='edit_buku.php?id={$row['id']}'>Edit</a> |
                <a href='hapus_buku.php?id={$row['id']}' onclick='return confirm(\"Apakah kamu yakin untuk menghapusnya?\")'>Hapus</a>
              </p>";
          echo "</div>";
        }
      } else {
        echo "<p class='text-center'>Kamu belum mempunyai koleksi buku di sini. Yuk tambah bacaanmu!</p>";
      }

      mysqli_close($conn);
      ?>

    </div>
  </div>
  <?php
  include_once 'headerFooter/footer.php';
  ?>

</body>

</html>