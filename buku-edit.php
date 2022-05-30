<?php
require 'config.php';
requireLogin();

$currentUser = currentUser($_SESSION['user_id']);

$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM buku WHERE id = $id");
$row = mysqli_fetch_assoc($result);

$result_buku = mysqli_query($conn, "SELECT * FROM kategori_buku");

$error = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  extract($_POST);

  $check_judul = mysqli_query($conn, "SELECT * FROM buku WHERE judul = '$judul' AND id != $id");
  if (mysqli_num_rows($check_judul)) {
    flash('message', 'Judul sudah digunakan!', 'info');
    $error = true;
  }

  if (!$error) {
    $sampul = $_FILES['sampul']['name'];
    $extractFile = pathinfo($sampul);
    $tempFile = $_FILES['sampul']['tmp_name'];

    if (is_uploaded_file($tempFile)) {
      $sampul = uniqid() . '.' . $extractFile['extension'];
      $file = "upload/" . $_POST['foto_lama'];
      if (file_exists($file))
        unlink($file);
    } else {
      $sampul = $_POST['sampul_lama'];
    }

    move_uploaded_file($tempFile, 'upload/' . $sampul);

    mysqli_query($conn, "UPDATE buku SET 
                        judul = '$judul', 
                        penulis = '$penulis', 
                        `penerbit` = '$penerbit', 
                        tahun_terbit = '$tahun_terbit', 
                        stok = '$stok', 
                        sampul = '$sampul',
                        kategori_buku_id = '$kategori_buku_id'
                        WHERE
                        id = '$id'") or die(mysqli_error($conn));

    flash('message', 'Berhasil diubah!');
    header('Location: buku.php');
    exit;
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php $title = "Edit Buku"; ?>
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
                  <input type="hidden" name="sampul_lama" value="<?= $row['sampul'] ?>">
                  <div class="mb-3">
                    <label for="judul" class="form-label">Judul</label>
                    <input type="text" class="form-control" id="judul" name="judul" value="<?= $row['judul'] ?>" required>
                  </div>
                  <div class="mb-3">
                    <label for="penulis" class="form-label">Penulis</label>
                    <input type="text" class="form-control" id="penulis" name="penulis" value="<?= $row['penulis'] ?>" required>
                  </div>
                  <div class="mb-3">
                    <label for="penerbit" class="form-label">Penerbit</label>
                    <input type="text" class="form-control" id="penerbit" name="penerbit" value="<?= $row['penerbit'] ?>" required>
                  </div>
                  <div class="mb-3">
                    <label for="tahun_terbit" class="form-label">Tahun Terbit</label>
                    <input type="number" class="form-control" id="tahun_terbit" name="tahun_terbit" value="<?= $row['tahun_terbit'] ?>" required>
                  </div>
                  <div class="mb-3">
                    <label for="stok" class="form-label">Stok</label>
                    <input type="number" class="form-control" id="stok" name="stok" value="<?= $row['stok'] ?>" required>
                  </div>
                  <div class="mb-3">
                    <label for="sampul" class="form-label">Sampul</label>
                    <input class="form-control" type="file" id="sampul" name="sampul" accept="image/*">
                  </div>
                  <div class="mb-3">
                    <label for="kategori_buku_id" class="form-label">Kategori Buku</label>
                    <select class="form-select" name="kategori_buku_id" id="kategori_buku_id" required>
                      <option value="" selected></option>
                      <?php while ($row2 = mysqli_fetch_assoc($result_buku)) : ?>
                        <option <?= ($row['kategori_buku_id'] == $row2['id']) ? 'selected' : '' ?> value="<?= $row2['id'] ?>"><?= $row2['nama'] ?></option>
                      <?php endwhile ?>
                    </select>
                  </div>
                  <div class="text-end">
                    <button type="submit" class="btn btn-primary">Update</button>
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