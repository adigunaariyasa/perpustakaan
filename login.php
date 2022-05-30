<?php
require 'config.php';

if (isset($_SESSION['user_id'])) {
  header('Location: index.php');
  exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $result = mysqli_query($conn, "SELECT * FROM `user` WHERE email = '$email' AND `password` = '$password'");
  if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    $_SESSION['user_id'] = $row['id'];
    alert('index.php', 'Login Berhasil');
  }

  $failedLogin = true;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php $title = "Login"; ?>
  <?php include 'includes/head.php' ?>
</head>

<body class="bg-light">

  <div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 100vh;">
      <div class="col-md-5">
        <h3 class="text-center mb-4"><?= SITE_NAME ?></h3>
        <div class="card shadow-sm">
          <div class="card-header h5">Login Form</div>
          <div class="card-body">

            <?php if (isset($failedLogin)) : ?>
              <div class="alert alert-danger" role="alert">
                Email atau Password salah
              </div>
            <?php endif ?>

            <form action="" method="post">
              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control" id="email" name="email" required>
              </div>
              <div class="mb-4">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
              </div>
              <div class="d-grid gap-2">
                <button class="btn btn-primary" type="submit">Login</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php include 'includes/script.php' ?>
</body>

</html>