<?php
// load file config.php
include("config.php");
// full php
if (isset($_POST["save_lapangan"])) {
  // issets digunakan untuk mengecek apakah ketika mengakses file ini,


   // tampung data yg dikirimkan
   $action = $_POST["action"];
   $id_lapangan = $_POST["id_lapangan"];
   $nama = $_POST["nama"];
   $harga = $_POST["harga"];
   $ukuran = $_POST["ukuran"];
   $lokasi = $_POST["lokasi"];
   $stok = $_POST["stok"];
   // menampung file image
   if (!empty($_FILES["image"]["name"])) {
     // mendapatkan deskripsi info gambar
     $path = pathinfo($_FILES["image"]["name"]);
     // mengambil ekstensi gambar
     $extension = $path["extension"];

     // rangkai file name-aksinya
     $filename = $id_lapangan."-".rand(1,1000).".".$extension;
     // general nama file
     // exp: 111-989.JPG
     // rand() random nilai dari 1 - 1000
   }



   // cek aksinya
   if ($action == "insert") {
     // sintak untuk insert
     $sql = "insert into lapangan values('$id_lapangan','$nama','$harga','$ukuran','$lokasi','$stok','$filename')";

     // proses upload file
     move_uploaded_file($_FILES["image"]["tmp_name"],"image/$filename");
     //  image itu nama folder yg dibuat
     // eksekusi perintah SQL-nya
     mysqli_query($connect, $sql);
   } elseif ($action == "update") {
     if (!empty($_FILES["image"]["name"])) {
       // mendapatkan deskripsi info gambar
       $path = pathinfo($_FILES["image"]["name"]);
       // mengambil ekstensi gambar
       $extension = $path["extension"];

       // rangkai file name-aksinya
       $filename = $id_lapangan."-".rand(1,1000).".".$extension;
       // general nama file
       // exp: 111-989.JPG
       // rand() random nilai dari 1 - 1000

       //  ambil data yang akan diedit
       $sql = "select * from lapangan where id_lapangan='$id_lapangan'";
       $query = mysqli_query($connect,$sql);
       $hasil = mysqli_fetch_array($query);

       if (file_exists("image/".$hasil["image"])) {
         unlink("image/".$hasil["image"]);
         // menghapus gambar yang terdahulu
       }

       // upload gambar
       move_uploaded_file($_FILES["image"]["tmp_name"],"image/$filename");

       // sintak untuk update
       $sql = "update lapangan set nama='$nama',
       harga='$harga',ukuran='$ukuran',lokasi='$lokasi',stok='$stok',image='$filename' where id_lapangan='$id_lapangan'";
     } else {
       // sintak untuk update
       $sql = "update lapangan set nama='$nama',
       harga='$harga',ukuran='$ukuran',lokasi='$lokasi',stok='$stok' where id_lapangan='$id_lapangan'";
     }

     // eksekusi perintah SQL-aksinya
     mysqli_query($connect, $sql);
   }
   // redirect ke halaman lapangan.php
   header("location:lapangan.php");
}

if (isset($_GET["hapus"])) {
  include("config.php");
  $id_lapangan = $_GET["id_lapangan"];
  $sql = "select * from lapangan where id_lapangan='$id_lapangan'";
  $query = mysqli_query($connect,$sql);
  $hasil = mysqli_fetch_array($query);
  if (file_exists("image/".$hasil["image"])) {
    unlink("image/".$hasil["image"]);
  }
  $sql = "delete from lapangan where id_lapangan='$id_lapangan'";

  mysqli_query($connect, $sql);

  // direct ke halaman data lapangan
  header("location:lapangan.php");
}
 ?>
