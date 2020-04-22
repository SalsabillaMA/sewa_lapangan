<?php
session_start();
include("config.php");
// menambah barang ke cart
if (isset($_POST["add_to_cart"])) {
  $id_lapangan = $_POST["id_lapangan"];
  $jumlah_sewa = $_POST["jumlah_sewa"];

  $sql = "select * from lapangan where id_lapangan='$id_lapangan'";
  $query = mysqli_query($connect, $sql); // eksekusi sintak sqlnya
  $lapangan = mysqli_fetch_array($query); // menampung data dari database ke array

  $item = [
    "id_lapangan" => $lapangan["id_lapangan"],
    "nama" => $lapangan["nama"],
    "image" => $lapangan["image"],
    "harga" => $lapangan["harga"],
    "jumlah_sewa" => $jumlah_sewa
  ];

  // memasukkan item kr keranjang Cart
  array_push($_SESSION["cart"], $item);

  header("location:sewalapangan.php");
}
// menghapus item pada Cart
if (isset($_GET["hapus"])) {
  // tampung data id_lapangan yg dihapus
  $id_lapangan = $_GET["id_lapangan"];

  // cari index cart sesuai dg id_lapangan yg dihapus
  $index = array_search(
    $id_lapangan, array_column(
      $_SESSION["cart"],["id_lapangan"] )
  );
  // hapus item pada Cart
  array_splice($_SESSION["cart"], $index, 1);
  header("location:cart.php");
}

// checkout
if (isset($_GET["checkout"])) {

  $id_pinjam = "ID".rand(1,10000); // rand itu buat ngerandom 1 - 10000
  $tgl_pinjam = date("Y-m-d"); // current time
  $tgl_kembali = $_POST["tgl_kembali"];
  //hitung lama sewanya
  $diff = strtotime($tgl_kembali) - strtotime($tgl_pinjam);
  $lama_sewa = round($diff / (60 * 60 * 24)); //round utk pembulatan hari
  $id_customer = $_SESSION["id_customer"];

  // buat $query
  $sql = "insert into peminjaman values ('$id_pinjam','$id_customer','$tgl_pinjam','$tgl_kembali','0')";
  mysqli_query($connect, $sql); // eksekusi query

  foreach ($_SESSION["cart"] as $cart) {
    $id_lapangan = $cart["id_lapangan"];
    $jumlah = $cart["jumlah_sewa"];
    $harga = $cart["harga"];

    // buat query insert ke tabel detail
    $sql = "insert into detail_pinjam values (
      '$id_pinjam','$id_lapangan','$harga','$lama_sewa','$jumlah'
      )";
      mysqli_query($connect, $sql);

      $sql2 = "update lapangan set stok = stok - $jumlah where id_lapangan='$id_lapangan'";
      mysqli_query($connect, $sql2);
  }
  // kosongkan cart nya
  $_SESSION["cart"] = array();
  header("location:peminjaman.php");
}

if (isset($_GET["comeback"])) {
  // tampung data id pinjamnya
  $id_pinjam = $_GET["id_pinjam"];
  // sql untuk mengupdate statusnya dengan id pinjam
   $sql = "update peminjaman set status = 1 where id_pinjam='$id_pinjam'";
   //eksekusi
   mysqli_query($connect,$sql);

   // sekarang update stok
   // bikin query sql untuk mengambil data detail pinjam berdasarkan id pinjam
   $sql = "select * from detail_pinjam where id_pinjam='$id_pinjam'";
   $query = mysqli_query($connect,$sql);
   foreach ($query as $detail) {
     // buat sql untuk update stok di lapangan berdasarkan id_lapangan dari detail
     $id_lapangan = $detail["id_lapangan"];
     $jumlah = $detail["jumlah"];
     $sql2 = "update lapangan set stok = stok + $jumlah where id_lapangan='$id_lapangan'";
     mysqli_query($connect,$sql2);
   }
   header("location:riwayat.php");
}
 ?>
