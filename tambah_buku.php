<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Buku</title>
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

  $username = $_SESSION['username'];
  $user_result = mysqli_query($conn, "SELECT id FROM user WHERE username = '$username'");
  $user = mysqli_fetch_assoc($user_result);
  $user_id = $user['id'];

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul        = trim($_POST['judul']);
    $penulis      = trim($_POST['penulis']);
    $penerbit     = trim($_POST['penerbit']);
    $tahun_terbit = trim($_POST['tahun_terbit']);
    $kategori     = trim($_POST['kategori']);
    $status_baca  = trim($_POST['status_baca']);
    $catatan      = trim($_POST['catatan']);
    $gambar       = '';

    // Upload gambar
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
      $target_dir = "uploads/";
      if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
      }
      $gambar = $target_dir . basename($_FILES['gambar']['name']);
      move_uploaded_file($_FILES['gambar']['tmp_name'], $gambar);
    }

    // Simpan ke database
    mysqli_query($conn, "INSERT INTO buku (user_id, judul, penulis, penerbit, tahun_terbit, kategori, status_baca, catatan, gambar)
                        VALUES ('$user_id', '$judul', '$penulis', '$penerbit', '$tahun_terbit', '$kategori', '$status_baca', '$catatan', '$gambar')");

    mysqli_query($conn, "INSERT INTO aktivitas (user_id, aksi, judul_buku) VALUES ('$user_id', 'tambah', '$judul')");

    header("Location: buku.php");
    exit;
  }
  ?>

  <div class="container">
    <h1>Tambah Buku yang Kamu Ingin Baca</h1>
    <form action="" method="post" enctype="multipart/form-data">
      <label for="judul">Judul</label>
      <input type="text" name="judul" class="form_login" placeholder="Judul Buku" required><br>

      <label for="penulis">Penulis</label>
      <input type="text" name="penulis" class="form_login" placeholder="Penulis Buku" required><br>

      <label for="penerbit">Penerbit</label>
      <input type="text" name="penerbit" class="form_login" placeholder="Penerbit Buku" required><br>

      <label for="tahun_terbit">Tahun Terbit</label>
      <input type="text" name="tahun_terbit" class="form_login" placeholder="Tahun Terbit Buku" required><br>

      <label for="kategori">Kategori</label>
      <input type="text" name="kategori" class="form_login" placeholder="Kategori Atau Genre Buku" required><br>

      <label for="gambar">Sampul Buku</label>
      <input type="file" name="gambar" class="form_login" accept="image/*"><br>
      <small class="note">Perhatikan: ukuran sampul ideal adalah ukuran yang sama (contoh 400 x 400)</small>

      <label for="status_baca">Status Baca</label>
      <select name="status_baca" class="form_login" required>
        <option value="sudah_dibaca">Sudah Dibaca</option>
        <option value="sedang_dibaca">Sedang Dibaca</option>
        <option value="ingin_dibaca">Ingin Dibaca</option>
      </select><br>

      <label for="catatan">Catatan Pribadi</label>
      <textarea name="catatan" class="form_login" placeholder="Masukkan Opini atau apapun disini"></textarea>

      <button type="submit" class="btnLogin">Simpan</button>
    </form>

    <br>
    <a href="buku.php">Kembali ke My Buku</a>
  </div>

  <?php mysqli_close($conn); ?>
</body>

</html>