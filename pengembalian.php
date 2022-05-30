<?php
require 'config.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php $title = "Pengembalian"; ?>
  <?php include 'includes/head.php' ?>
</head>

<body>
  <div class="d-flex" id="wrapper">

    <!-- Sidebar-->
    <?php $active = "pengembalian"; ?>
    <?php include 'includes/sidebar.php' ?>

    <!-- Page content wrapper-->
    <div id="page-content-wrapper">

      <!-- Top navigation-->
      <?php include 'includes/navbar.php' ?>

      <!-- Page content-->
      <div class="container-fluid py-3">
        <h1 class="h2 mb-4">Pengembalian</h1>
      </div>

    </div>
  </div>

  <?php include 'includes/script.php' ?>
</body>

</html>