<?php
require 'config.php';
requireLogin();

$currentUser = currentUser($_SESSION['user_id']);

$result_buku = mysqli_query($conn, "SELECT * FROM kategori_buku");

$error = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  extract($_POST);

  $check_judul = mysqli_query($conn, "SELECT * FROM buku WHERE judul = '$judul'");
  if (mysqli_num_rows($check_judul)) {
    flash('message', 'Judul sudah digunakan!', 'info');
    $error = true;
  }

  if (!$error) {
    $sampul = $_FILES['sampul']['name'];
    $extractFile = pathinfo($sampul);
    $sampul = uniqid() . '.' . $extractFile['extension'];
    $tempFile = $_FILES['sampul']['tmp_name'];

    move_uploaded_file($tempFile, 'upload/' . $sampul);

    mysqli_query($conn, "INSERT INTO buku (judul, penulis, `penerbit`, tahun_terbit, stok, sampul, kategori_buku_id) 
                         VALUES ('$judul', '$penulis', '$penerbit', '$tahun_terbit', '$stok', '$sampul', '$kategori_buku_id')") or die(mysqli_error($conn));

    flash('message', 'Berhasil ditambahkan!');
    header('Location: buku.php');
    exit;
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php $title = "Tambah Buku"; ?>
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

        <div class="row">
          <div class="col-md-6">

            <?php flash('message'); ?>

            <div class="card">
              <div class="card-header">
                Form
              </div>
              <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data">
                  <div class="mb-3">
                    <label for="judul" class="form-label">Judul</label>
                    <input type="text" class="form-control" id="judul" name="judul" value="<?= old('judul') ?>" required>
                  </div>
                  <div class="mb-3">
                    <label for="penulis" class="form-label">Penulis</label>
                    <input type="text" class="form-control" id="penulis" name="penulis" value="<?= old('penulis') ?>" required>
                  </div>
                  <div class="mb-3">
                    <label for="penerbit" class="form-label">Penerbit</label>
                    <input type="text" class="form-control" id="penerbit" name="penerbit" value="<?= old('penerbit') ?>" required>
                  </div>
                  <div class="mb-3">
                    <label for="tahun_terbit" class="form-label">Tahun Terbit</label>
                    <input type="number" class="form-control" id="tahun_terbit" name="tahun_terbit" value="<?= old('tahun_terbit') ?>" required>
                  </div>
                  <div class="mb-3">
                    <label for="stok" class="form-label">Stok</label>
                    <input type="number" class="form-control" id="stok" name="stok" value="<?= old('stok') ?>" required>
                  </div>
                  <div class="mb-3">
                    <label for="sampul" class="form-label">Sampul</label>
                    <input class="form-control" type="file" id="sampul" name="sampul" accept="image/*" required>
                  </div>
                  <div class="mb-3">
                    <label for="kategori_buku_id" class="form-label">Kategori Buku</label>
                    <select class="form-select" name="kategori_buku_id" id="kategori_buku_id" required>
                      <option value="" selected></option>
                      <?php while ($row = mysqli_fetch_assoc($result_buku)) : ?>
                        <option <?= (old('stok') == $row['id']) ? 'selected' : '' ?> value="<?= $row['id'] ?>"><?= $row['nama'] ?></option>
                      <?php endwhile ?>
                    </select>
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