<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Koleksi Buku Saya (Gambar)</title>
  <link rel="stylesheet" href="assets/style.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
</head>

<body>

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
  $result = mysqli_query($conn, "SELECT * FROM buku WHERE user_id = $user_id"); ?>

  <div class="container" id="snapshotArea">
    <h1>Koleksi Buku <?php echo $_SESSION['username']; ?>!</h1>
    <div class=" book-grid">
      <?php
      if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
          $gambar = (!empty($row['gambar']) && file_exists($row['gambar'])) ? $row['gambar'] : 'assets/IMAGE NOT FOUND.png';
          echo "<div class='book-card'>";
          echo "<div class='book-wrapper'>";
          echo "<img src='$gambar' alt='Sampul Buku' class='book-cover'>";
          echo "</div>";
          echo "<h3>" . $row['judul'] . "</h3>";
          echo "</div>";
        }
      } else {
        echo "<p class='text-center'>Kamu belum memiliki koleksi buku.</p>";
      }
      mysqli_close($conn);
      ?>
    </div>
  </div>
  <div>
    <button id="downloadBtn" class="btnLogin">Download Koleksi</button>
  </div>
  <script>
    document.getElementById("downloadBtn").addEventListener("click", function() {
      const btn = document.getElementById("downloadBtn");
      btn.style.visibility = "hidden";

      html2canvas(document.querySelector("#snapshotArea"), {
        useCORS: true,
        scale: 2,
        backgroundColor: getComputedStyle(document.documentElement)
          .getPropertyValue("--background-fallback")
          .trim()
      }).then(canvas => {
        let link = document.createElement("a");
        link.download = "koleksi_buku.png";
        link.href = canvas.toDataURL("image/png");
        link.click();
        btn.style.visibility = "visible";
      });
    });
  </script>
  <?php
  include_once 'headerFooter/footer.php';
  ?>
</body>

</html>