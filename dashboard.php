<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>dashboard - Perpustakaan Pribadi</title>
  <link rel="stylesheet" href="styles/style.css">

</head>

<body>

  <?php
  session_start();
  if (!isset($_SESSION['username'])) {
    header("location:index.php");
    exit();
  }
  ?>
  <div class="dashboard">
    <h1>Selamat datang, <?php echo $_SESSION['username']; ?>!</h1>
    <nav>
      <ul>
        <li><a href="buku.php">Koleksi Buku Saya</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </nav>
  </div>
  <?php
  ?>
</body>

</html>