<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Buku</title>
  <link rel="stylesheet" href="assets/style.css">
</head>

<body>

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

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul        = trim($_POST['judul']);
    $penulis      = trim($_POST['penulis']);
    $penerbit     = trim($_POST['penerbit']);
    $tahun_terbit = trim($_POST['tahun_terbit']);
    $kategori     = trim($_POST['kategori']);
    $status_baca  = trim($_POST['status_baca']);
    $catatan      = trim($_POST['catatan']);
    $gambar       = $buku['gambar'];

    // Upload gambar
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
      $target_dir = "uploads/";
      if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
      }
      $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
      $nama_file = uniqid('buku_', true) . '.' . $ext;
      $gambar_baru = $target_dir . $nama_file;
      move_uploaded_file($_FILES['gambar']['tmp_name'], $gambar_baru);
      $gambar = $gambar_baru; // simpan path baru ke variabel utama
    }

    // update database
    mysqli_query($conn, "UPDATE buku SET 
    judul = '$judul',
    penulis = '$penulis',
    penerbit = '$penerbit',
    tahun_terbit = '$tahun_terbit',
    kategori = '$kategori',
    status_baca = '$status_baca',
    catatan = '$catatan',
    gambar = '$gambar'
    WHERE id = $id_buku AND user_id = $user_id");

    mysqli_query($conn, "INSERT INTO aktivitas (user_id, aksi, judul_buku) VALUES ('$user_id', 'edit', '$judul')");

    header("Location: buku.php");
    exit;
  }
  ?>

  <div class="container">
    <h1>Tambah Buku yang Kamu Ingin Baca</h1>
    <form action="" method="post" enctype="multipart/form-data">
      <label for="judul">Judul</label>
      <input type="text" name="judul" class="form_login" value="<?= $buku['judul'] ?>" required><br>

      <label for="penulis">Penulis</label>
      <input type="text" name="penulis" class="form_login" value="<?= $buku['penulis'] ?>" required><br>

      <label for="penerbit">Penerbit</label>
      <input type="text" name="penerbit" class="form_login" value="<?= $buku['penerbit'] ?>" required><br>

      <label for="tahun_terbit">Tahun Terbit</label>
      <input type="text" name="tahun_terbit" class="form_login" value="<?= $buku['tahun_terbit'] ?>" required><br>

      <label for="kategori">Kategori</label>
      <input type="text" name="kategori" class="form_login" value="<?= $buku['kategori'] ?>" required><br>

      <label for="gambar">Sampul Buku</label>
      <input type="file" name="gambar" class="form_login" accept="image/*"><br>

      <label for="status_baca">Status Baca</label>
      <select name="status_baca" class="form_login" required>
        <option value="sudah_dibaca" <?= $buku['status_baca'] == 'sudah_dibaca' ? 'selected' : '' ?>>Sudah Dibaca</option>
        <option value="sedang_dibaca" <?= $buku['status_baca'] == 'sedang_dibaca' ? 'selected' : '' ?>>Sedang Dibaca</option>
        <option value="ingin_dibaca" <?= $buku['status_baca'] == 'ingin_dibaca' ? 'selected' : '' ?>>Ingin Dibaca</option>
      </select><br>


      <label for="catatan">Catatan Pribadi</label>
      <textarea name="catatan" class="form_login" <?= $buku['catatan'] ?>></textarea>

      <button type="submit" class="btnLogin">Simpan</button>
    </form>

    <br>
    <a href="buku.php">Kembali ke My Buku</a>
  </div>

  <?php mysqli_close($conn); ?>
</body>

</html>