<?php
require 'config.php';
requireLogin();
$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM user WHERE id = $id AND is_admin = 0");
$row = mysqli_fetch_assoc($result);
$file = "upload/" . $row['foto_ktp'];
if (file_exists($file)) unlink($file);
mysqli_query($conn, "DELETE FROM user WHERE id = $id AND is_admin = 0") or die(mysqli_error($conn));
flash('message', 'Berhasil dihapus!');
header('Location: anggota.php');
exit;
