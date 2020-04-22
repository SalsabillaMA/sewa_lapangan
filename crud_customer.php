<?php
// full php
include("config.php");
if (isset($_POST["save_customer"])) {
  // issets digunakan untuk mengecek apakah ketika mengakses file ini,

   // tampung data yg dikirimkan
   $action = $_POST["action"];
   $id_customer = $_POST["id_customer"];
   $nama_customer = $_POST["nama_customer"];
   $alamat = $_POST["alamat"];
   $kontak = $_POST["kontak"];
   $username = $_POST["username"];
   $password = $_POST["password"];

   // load file config.php
   // cek aksinya
   if ($action == "insert") {
     // sintak untuk insert
     $sql = "insert into customer values('$id_customer','$nama_customer','$alamat','$kontak','$username','$password')";

     // proses upload file
     // eksekusi perintah SQL-nya
     mysqli_query($connect, $sql);
   } elseif ($action == "update") {
       // sintak untuk update
       $sql = "update customer set nama_customer='$nama_customer', alamat='$alamat',
       kontak='$kontak', username='$username', password='$password' where id_customer='$id_customer'";

     // eksekusi perintah SQL-aksinya
     mysqli_query($connect, $sql);
   }
   // redirect ke halaman customer.php
   header("location:customer.php");
}

if (isset($_GET["hapus"])) {

  $id_customer = $_GET["id_customer"];
  $sql = "select * from customer where id_customer='$id_customer'";
  $query = mysqli_query($connect,$sql);
  $hasil = mysqli_fetch_array($query);
  $sql = "delete from customer where id_customer='$id_customer'";

  mysqli_query($connect, $sql);

  // direct ke halaman data customer
  header("location:customer.php");
}
 ?>
