<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>dashboard - Perpustakaan Pribadi</title>
  <link rel="stylesheet" href="assets/style.css">

</head>

<body>

  <?php
  session_start();
  if (!isset($_SESSION['username'])) {
    header("location:index.php");
    exit;
  }
  include_once 'headerFooter/header.php';
  ?>
  <div class="dashboard">
    <h1>Selamat datang, <?php echo $_SESSION['username']; ?>!</h1>
  </div>
  <?php
  include_once 'headerFooter/footer.php';
  ?>

</body>

</html>