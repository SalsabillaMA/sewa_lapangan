<?php
// full php
include("config.php");
if (isset($_POST["save_admin"])) {
  // issets digunakan untuk mengecek apakah ketika mengakses file ini,

   // tampung data yg dikirimkan
   $action = $_POST["action"];
   $id_admin = $_POST["id_admin"];
   $nama = $_POST["nama"];
   $kontak = $_POST["kontak"];
   $username = $_POST["username"];
   $password = $_POST["password"];

   // load file config.php


   // cek aksinya
   if ($action == "insert") {
     // sintak untuk insert
     $sql = "insert into admin values('$id_admin','$nama','$kontak','$username','$password')";

     // proses upload file
     // eksekusi perintah SQL-nya
     mysqli_query($connect, $sql);
   } elseif ($action == "update") {
       // sintak untuk update
       $sql = "update admin set nama='$nama',
       kontak='$kontak', username='$username', password='$password' where id_admin='$id_admin'";

     // eksekusi perintah SQL-aksinya
     mysqli_query($connect, $sql);
   }
   // redirect ke halaman siswa.php
   header("location:admin.php");
}

if (isset($_GET["hapus"])) {

  $id_admin = $_GET["id_admin"];
  $sql = "select * from admin where id_admin='$id_admin'";
  $query = mysqli_query($connect,$sql);
  $hasil = mysqli_fetch_array($query);
  $sql = "delete from admin where id_admin='$id_admin'";

  mysqli_query($connect, $sql);

  // direct ke halaman data admin
  header("location:admin.php");
}
 ?>
