<?php
require 'config.php';
requireLogin();

$currentUser = currentUser($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php $title = "Dashboard"; ?>
  <?php include 'includes/head.php' ?>
</head>

<body>
  <div class="d-flex" id="wrapper">

    <!-- Sidebar-->
    <?php $active = "dashboard"; ?>
    <?php include 'includes/sidebar.php' ?>

    <!-- Page content wrapper-->
    <div id="page-content-wrapper">

      <!-- Top navigation-->
      <?php include 'includes/navbar.php' ?>

      <!-- Page content-->
      <div class="container-fluid py-3">
        <h1 class="h2 mb-4"><?= $title ?></h1>

        <?php if ($currentUser['is_admin'] == 1) : ?>
          <div class="row">

            <div class="col-md-3">
              <div class="card">
                <div class="card-body text-center py-3">
                  <p class="card-text h5">Anggota</p>
                  <?php $result = mysqli_query($conn, "SELECT * FROM user where is_admin = 0"); ?>
                  <p class="card-text lead mb-0"><?= mysqli_num_rows($result) ?></p>
                </div>
              </div>
            </div>

            <div class="col-md-3">
              <div class="card">
                <div class="card-body text-center py-3">
                  <p class="card-text h5">Buku</p>
                  <?php $result = mysqli_query($conn, "SELECT * FROM buku"); ?>
                  <p class="card-text lead mb-0"><?= mysqli_num_rows($result) ?></p>
                </div>
              </div>
            </div>

            <div class="col-md-3">
              <div class="card">
                <div class="card-body text-center py-3">
                  <p class="card-text h5">Peminjaman</p>
                  <p class="card-text lead mb-0">0</p>
                </div>
              </div>
            </div>

            <div class="col-md-3">
              <div class="card">
                <div class="card-body text-center py-3">
                  <p class="card-text h5">Pengembalian</p>
                  <p class="card-text lead mb-0">0</p>
                </div>
              </div>
            </div>

          </div>
        <?php else : ?>
          <div class="card" style="width: 38rem;">
            <div class="card-body">
              <h5 class="card-title"><?= $currentUser['nama'] ?></h5>
              <h6 class="card-subtitle mb-2 text-muted"><?= $currentUser['email'] ?></h6>
              <p class="card-text"><?= $currentUser['no_telp'] ?></p>
              <p class="card-text"><?= $currentUser['alamat'] ?></p>
              <hr>
              <a href="edit-profile.php" class="card-link">Edit Profile</a>
            </div>
          </div>
        <?php endif ?>

      </div>

    </div>
  </div>

  <?php include 'includes/script.php' ?>
</body>

</html>