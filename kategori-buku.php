<?php
require 'config.php';
requireLogin();

$currentUser = currentUser($_SESSION['user_id']);

$result = mysqli_query($conn, "SELECT * FROM kategori_buku");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php $title = "Kategori Buku"; ?>
  <?php include 'includes/head.php' ?>
</head>

<body>
  <div class="d-flex" id="wrapper">

    <!-- Sidebar-->
    <?php $active = "kategori-buku"; ?>
    <?php include 'includes/sidebar.php' ?>

    <!-- Page content wrapper-->
    <div id="page-content-wrapper">

      <!-- Top navigation-->
      <?php include 'includes/navbar.php' ?>

      <!-- Page content-->
      <div class="container-fluid py-3">
        <h1 class="h2 mb-4"><?= $title ?></h1>

        <a href="kategori-buku-tambah.php" class="btn btn-primary mb-3">Tambah</a>

        <div class="row">
          <div class="col-md-6">

            <?php flash('message'); ?>

            <table class="table table-bordered">
              <thead>
                <tr>
                  <th scope="col">No</th>
                  <th scope="col">Nama</th>
                  <th scope="col">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php $i = 1; ?>
                <?php if (!mysqli_num_rows($result)) : ?>
                  <tr>
                    <td colspan="3" class="text-center">Data Kosong</td>
                  </tr>
                <?php endif ?>
                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                  <tr>
                    <th class="align-middle text-nowrap" scope="row"><?= $i++ ?></th>
                    <td class="align-middle text-nowrap"><?= $row['nama'] ?></td>
                    <td class="align-middle text-nowrap">
                      <a href="kategori-buku-hapus.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm py-0" onclick="return confirm('delete?')">Hapus</a>
                    </td>
                  </tr>
                <?php endwhile ?>
              </tbody>
            </table>
          </div>
        </div>

      </div>

    </div>
  </div>

  <?php include 'includes/script.php' ?>
</body>

</html>