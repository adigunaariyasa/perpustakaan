<?php
require 'config.php';
requireLogin();
$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM kategori_buku WHERE id = $id") or die(mysqli_error($conn));
flash('message', 'Berhasil dihapus!');
header('Location: kategori-buku.php');
exit;
