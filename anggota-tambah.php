<?php
require 'config.php';
requireLogin();

$currentUser = currentUser($_SESSION['user_id']);

$error = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  extract($_POST);

  $check_email = mysqli_query($conn, "SELECT * FROM user WHERE email = '$email'");
  if (mysqli_num_rows($check_email)) {
    flash('message', 'Email sudah digunakan!', 'info');
    $error = true;
  }

  if (!$error) {
    $check_email = mysqli_query($conn, "SELECT * FROM user WHERE no_telp = '$no_telp'");
    if (mysqli_num_rows($check_email)) {
      flash('message', 'No Telp sudah digunakan!', 'info');
      $error = true;
    }
  }

  if (!$error) {
    $ktp = $_FILES['ktp']['name'];
    $extractFile = pathinfo($ktp);
    $ktp = uniqid() . '.' . $extractFile['extension'];
    $tempFile = $_FILES['ktp']['tmp_name'];

    move_uploaded_file($tempFile, 'upload/' . $ktp);

    mysqli_query($conn, "INSERT INTO user (nama, email, `password`, foto_ktp, no_telp, alamat) 
                        VALUES ('$nama', '$email', '$password', '$ktp', '$no_telp', '$alamat')") or die(mysqli_error($conn));

    flash('message', 'Berhasil ditambahkan!');
    header('Location: anggota.php');
    exit;
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php $title = "Tambah Anggota"; ?>
  <?php include 'includes/head.php' ?>
</head>

<body>
  <div class="d-flex" id="wrapper">

    <!-- Sidebar-->
    <?php $active = "anggota"; ?>
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
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="<?= old('nama') ?>" required>
                  </div>
                  <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= old('email') ?>" required>
                  </div>
                  <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" minlength="4" required>
                  </div>
                  <div class="mb-3">
                    <label for="no_telp" class="form-label">No Telp</label>
                    <input type="tel" class="form-control" id="no_telp" name="no_telp" value="<?= old('no_telp') ?>" required>
                  </div>
                  <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea class="form-control" id="alamat" name="alamat" rows="3" required><?= old('alamat') ?></textarea>
                  </div>
                  <div class="mb-3">
                    <label for="ktp" class="form-label">Foto KTP / KK</label>
                    <input class="form-control" type="file" id="ktp" name="ktp" accept="image/*" required>
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