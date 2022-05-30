<?php
require 'config.php';
requireLogin();

$currentUser = currentUser($_SESSION['user_id']);

$nama = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $nama = $_POST['nama'];

  $check_nama_kategori_buku = mysqli_query($conn, "SELECT * FROM kategori_buku WHERE nama = '$nama'");
  if (mysqli_num_rows($check_nama_kategori_buku)) {
    flash('message', 'Nama kategori sudah digunakan!', 'info');
    header('Location: kategori-buku-tambah.php');
    exit;
  }

  mysqli_query($conn, "INSERT INTO kategori_buku (nama) VALUES ('$nama')") or die(mysqli_error($conn));
  flash('message', 'Berhasil ditambahkan!');
  header('Location: kategori-buku.php');
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php $title = "Tambah Kategori Buku"; ?>
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

        <div class="row">
          <div class="col-md-6">

            <?php flash('message'); ?>

            <div class="card">
              <div class="card-header">
                Form
              </div>
              <div class="card-body">
                <form action="" method="post">
                  <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Kategori Buku" value="<?= $nama ?>" required>
                  </div>
                  <div class="text-end">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>
  </div>

  <?php include 'includes/script.php' ?>
</body>

</html>