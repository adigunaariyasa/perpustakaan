<?php
require 'config.php';
requireLogin();

$currentUser = currentUser($_SESSION['user_id']);

$error = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $id = $_SESSION['user_id'];
  $nama = $_POST['nama'];
  $password = $_POST['password'];
  $password2 = $_POST['password2'];
  $no_telp = $_POST['no_telp'];
  $alamat = $_POST['alamat'];

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

    $query = "UPDATE `user` SET 
            nama = '$nama', 
            foto_ktp = '$ktp',
            no_telp = '$no_telp', 
            alamat = '$alamat'";
    if ($password) {

      if ($password !== $password2) {
        alert('edit-profile.php', 'Password tidak sama dengan Konfirm Password');
      }

      $query .= ", password = '$password'";
    }
    $query .= " WHERE id = $id";



    move_uploaded_file($tempFile, 'upload/' . $ktp);

    $result = mysqli_query($conn, $query);
    if ($result) {
      alert('edit-profile.php', 'Profile berhasil diupdate');
    }
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php $title = "Edit Profile"; ?>
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
        <div class="row">

          <div class="col-md-6">
            <div class="card shadow-sm">
              <div class="card-header">Form Edit Profile</div>
              <div class="card-body py-3">

                <form action="" method="post" enctype="multipart/form-data">
                  <input type="hidden" name="foto_lama" value="<?= $row['foto_ktp'] ?>">
                  <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" class="form-control" id="email" value="<?= $currentUser['email'] ?>" disabled>
                  </div>
                  <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="<?= $currentUser['nama'] ?>">
                  </div>
                  <div class="mb-3">
                    <label for="no_telp" class="form-label">No Telp</label>
                    <input type="text" class="form-control" id="no_telp" name="no_telp" value="<?= $currentUser['no_telp'] ?>">
                  </div>
                  <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea class="form-control" id="alamat" name="alamat" rows="3"><?= $currentUser['alamat'] ?></textarea>
                  </div>
                  <div class="mb-3">
                    <label for="ktp" class="form-label">Foto KTP / KK</label>
                    <input class="form-control" type="file" id="ktp" name="ktp" accept="image/*">
                  </div>
                  <div class="row g-3">
                    <div class="col">
                      <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                      </div>
                    </div>
                    <div class="col">
                      <div class="mb-3">
                        <label for="password2" class="form-label">Konfirm Password</label>
                        <input type="password" class="form-control" id="password2" name="password2">
                      </div>
                    </div>
                  </div>
                  <div class="text-end">
                    <button type="submit" class="btn btn-primary">Update</button>
                  </div>
                </form>

              </div>
            </div>
          </div>

          <div class="col-md-3">

            <div class="card shadow-sm">
              <div class="card-header">Foto KTP / KK</div>
              <div class="card-body py-3">
                <?php if (!empty($currentUser['foto_ktp'])) : ?>
                  <img src="upload/<?= $currentUser['foto_ktp'] ?>" alt="Foto KTP / KK" class="img-fluid w-100">
                <?php endif ?>
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