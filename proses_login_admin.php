<?php
session_start();
// session_start() digunakan sbg tanda kalau kita akan menggunakan session pada halaman curl_ini
// session_start() harus diletakkan pada baris pertama.
include("config.php");

// tampung data username dan passwordnya
$username = $_POST["username"];
$password = $_POST["password"];

if (isset($_POST["login_admin"])) {
$sql = "select * from admin where username = '$username' and password = '$password'";
// eksekusi $query
$query = mysqli_query($connect, $sql);
$jumlah = mysqli_num_rows($query);
// mysqli_num_rows digunakan utk menghitung jumlah data hasil dari $query

if ($jumlah > 0) {
  // jika jumlahnya lebih dari nol, artinya terdapat data admin yang sesuai dg username dan password
  // ini blok kode jika Berhasil
  // kita ubah hasil query ke array
  $admin = mysqli_fetch_array($query);

  // membuat session
  $_SESSION["id_admin"] = $admin["id_admin"];
  $_SESSION["nama"] = $admin["nama"];

  header("location:lapangan.php");
}else {
  // jika jumlahnya nol, artinya tidak ada data admin yang sesuai dg username dan password yang diinputkan
  // ini blok kode jika loginnya gagal / salah
  header("location:login_admin.php");
}
}

if (isset($_GET["logout"])) {
  // proses logout
  // menghapus data session yg telah dibuat
  session_destroy();
  header("location:login_admin.php");
}
 ?>
