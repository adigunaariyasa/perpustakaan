<?php
require 'config.php';
requireLogin();
$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM buku WHERE id = $id");
$row = mysqli_fetch_assoc($result);
$file = "upload/" . $row['sampul'];
if (file_exists($file)) unlink($file);
mysqli_query($conn, "DELETE FROM buku WHERE id = $id") or die(mysqli_error($conn));
flash('message', 'Berhasil dihapus!');
header('Location: buku.php');
exit;
