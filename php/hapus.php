<?php
$conn = mysqli_connect("localhost", "root", "", "db_keuangan");
if(!$conn){
  die("Koneksi gagal: " . mysqli_connect_error());
}

if(!isset($_GET['id'])){
  header("Location: data.php");
  exit;
}

$id = (int)$_GET['id'];
if($id <= 0){
  header("Location: data.php");
  exit;
}

$cek = mysqli_query($conn, "SELECT id FROM transaksi WHERE id=$id");
if(!$cek || mysqli_num_rows($cek) == 0){
  header("Location: data.php");
  exit;
}

// hapus
$hapus = mysqli_query($conn, "DELETE FROM transaksi WHERE id=$id");

if($hapus){
  header("Location: data.php?msg=hapus_sukses");
  exit;
} else {
  header("Location: data.php?msg=hapus_gagal");
  exit;
}
