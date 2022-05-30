<?php
require 'config.php';
requireLogin();

$currentUser = currentUser($_SESSION['user_id']);

$result = mysqli_query($conn, "SELECT * FROM buku");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php $title = "Buku"; ?>
  <?php include 'includes/head.php' ?>
</head>

<body>
  <div class="d-flex" id="wrapper">

    <!-- Sidebar-->
    <?php $active = "buku"; ?>
    <?php include 'includes/sidebar.php' ?>

    <!-- Page content wrapper-->
    <div id="page-content-wrapper">

      <!-- Top navigation-->
      <?php include 'includes/navbar.php' ?>

      <!-- Page content-->
      <div class="container-fluid py-3">
        <h1 class="h2 mb-4"><?= $title ?></h1>

        <a href="buku-tambah.php" class="btn btn-primary mb-3">Tambah</a>

        <div class="row">
          <div class="col-md-12">

            <?php flash('message'); ?>

            <table class="table table-bordered">
              <thead>
                <tr>
                  <th scope="col">No</th>
                  <th scope="col">Sampul</th>
                  <th scope="col">Judul</th>
                  <th scope="col">Penulis</th>
                  <th scope="col">Penerbit</th>
                  <th scope="col">Stok</th>
                  <th scope="col">Tahun Terbit</th>
                  <th scope="col">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php $i = 1; ?>
                <?php if (!mysqli_num_rows($result)) : ?>
                  <tr>
                    <td colspan="7" class="text-center">Data Kosong</td>
                  </tr>
                <?php endif ?>
                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                  <tr>
                    <th class="align-middle text-nowrap" scope="row"><?= $i++ ?></th>
                    <td class="align-middle text-nowrap"><img src="upload/<?= $row['sampul'] ?>" alt="sampul" width="30"></td>
                    <td class="align-middle text-nowrap"><?= $row['judul'] ?></td>
                    <td class="align-middle text-nowrap"><?= $row['penulis'] ?></td>
                    <td class="align-middle text-nowrap"><?= $row['penerbit'] ?></td>
                    <td class="align-middle text-nowrap"><?= $row['stok'] ?></td>
                    <td class="align-middle text-nowrap"><?= $row['tahun_terbit'] ?></td>
                    <td class="align-middle text-nowrap">
                      <a href="buku-edit.php?id=<?= $row['id'] ?>" class="btn btn-primary btn-sm py-0">Edit</a>
                      <a href="buku-hapus.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm py-0" onclick="return confirm('delete?')">Hapus</a>
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