<?php
require 'config.php';
requireLogin();

$currentUser = currentUser($_SESSION['user_id']);

$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM user WHERE id = $id AND is_admin = 0");
$row = mysqli_fetch_assoc($result);

$error = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  extract($_POST);

  $check_email = mysqli_query($conn, "SELECT * FROM user WHERE email = '$email' AND id != $id");
  if (mysqli_num_rows($check_email)) {
    flash('message', 'Email sudah digunakan!', 'info');
    $error = true;
  }

  $check_notelp = mysqli_query($conn, "SELECT * FROM user WHERE no_telp = '$no_telp' AND id != $id");
  if (mysqli_num_rows($check_notelp)) {
    flash('message', 'No Telp sudah digunakan!', 'info');
    $error = true;
  }

  if (!$error) {
    $ktp = $_FILES['ktp']['name'];
    $extractFile = pathinfo($ktp);
    $tempFile = $_FILES['ktp']['tmp_name'];

    if (is_uploaded_file($tempFile)) {
      $ktp = uniqid() . '.' . $extractFile['extension'];
      $file = "upload/" . $_POST['foto_lama'];
      if (file_exists($file))
        unlink($file);
    } else {
      $ktp = $_POST['foto_lama'];
    }

    move_uploaded_file($tempFile, 'upload/' . $ktp);

    mysqli_query($conn, "UPDATE user SET 
                        nama = '$nama', 
                        email = '$email', 
                        `password` = '$password', 
                        foto_ktp = '$ktp', 
                        no_telp = '$no_telp', 
                        alamat = '$alamat' 
                        WHERE
                        id = $id") or die(mysqli_error($conn));

    flash('message', 'Berhasil diubah!');
    header('Location: anggota.php');
    exit;
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php $title = "Edit Anggota"; ?>
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
                  <input type="hidden" name="foto_lama" value="<?= $row['foto_ktp'] ?>">
                  <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="<?= $row['nama'] ?>" required>
                  </div>
                  <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= $row['email'] ?>" required>
                  </div>
                  <div class="mb-3">
                    <label for="no_telp" class="form-label">No Telp</label>
                    <input type="tel" class="form-control" id="no_telp" name="no_telp" value="<?= $row['no_telp'] ?>" required>
                  </div>
                  <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea class="form-control" id="alamat" name="alamat" rows="3" required><?= $row['alamat'] ?></textarea>
                  </div>
                  <div class="mb-3">
                    <label for="ktp" class="form-label">Foto KTP / KK</label>
                    <input class="form-control" type="file" id="ktp" name="ktp" accept="image/*">
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