<?php
session_start();
if (!isset($_SESSION["id_customer"])) {
  header("location:login_customer.php");
}
// memanggil file config.php agar tidak perlu membuat koneksi baru
include("config.php");
 ?>
 <!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width-device-width, initial-scale=1">
  <title>Persewaan Lapangan</title>
  <!-- Load bootstrap css -->
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="css-sewa.css">
  <!-- load jquery and bootstrap js -->
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/popper.min.js"></script>
  <script src="assets/js/bootstrap.js"></script>
  <script type="text/javascript">
    Detail = (item) => {
      document.getElementById('id_lapangan').value = item.id_lapangan;
      document.getElementById('nama').innerHTML = item.nama;
      document.getElementById('harga').innerHTML = "Harga : Rp." + item.harga;
      document.getElementById('ukuran').innerHTML = "Luas : " + item.ukuran;
      document.getElementById('lokasi').innerHTML = "Lokasi : " + item.lokasi;
      document.getElementById('stok').innerHTML = "Stok : " +item.stok;
      document.getElementById("jumlah_sewa").value = "1";
      document.getElementById("jumlah_sewa").max = item.stok;

      document.getElementById("image").src = "image/" + item.image;
    }
  </script>

</head>
<body>
  <nav class="navbar-expand-md bg-success navbar-dark fixed-top">
  <a href="#">
    <img src="ball.png" width="45" align="left" alt="">
  </a>

<!-- pemanggilan icon menu saat menubar disembunyikan -->
<button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#menu">
  <span class="navbar navbar-toggler-icon"></span>
</button>

<!-- daftar menu pada navbar -->
<div class="collapse navbar-collapse" id="menu">
  <ul class="navbar-nav">
    <li class="nav-item"><a href="#a" class="nav-link h5 mt-1 text-white">Beranda</a></li>
    <li class="nav-item">
      <a href="cart.php" class="nav-link h5 mt-1 text-white">
        <img src="cartt.png" width="30" align="left" alt="">
        (<?php echo count($_SESSION["cart"]); ?>)
      </a>
    </li>
    <li class="nav-item"><a href="peminjaman.php" class="nav-link h5 mt-1 text-white">
      <img src="historyy.png" width="30" align="left" alt="">
      Transaksi</a></li>
    <li class="nav-item dropdown">
  <a href="#" class="nav-link dropdown-toggle h5 mt-1 text-white" data-toggle="dropdown">Contact</a>
  <div class="dropdown-menu">
    <a target="_blank" href="https://www.facebook.com/pages/category/Local-Business/Lapangan-133904853446686/" class="dropdown-item"><img src="fb.png" width="45" align="left" alt=""></a>
    <a target="_blank"href="https://www.instagram.com/silmafutsal/p/BdxvaK6F4pF/" class="dropdown-item"><img src="ig.png" width="45" align="left" alt=""></a>
    <a target="_blank"href="https://twitter.com/albafutsal" class="dropdown-item"><img src="tw.png" width="45" align="left" alt=""></a>
    <a target="_blank"href="https://www.youtube.com/watch?v=RlfOrMkgBg4" class="dropdown-item"><img src="yt.png" width="45" align="left" alt=""></a>
  </div>
  </li>
 </ul>
   <ul class="navbar-nav ml-auto">
  <li class="nav-item">
      <a href="proses_login_customer.php?logout=true" class="nav-link h5 mt-2 text-white" ><?php echo $_SESSION["nama_customer"]; ?>
        <img src="logoutt.png" width="30" align="left" alt=""></a></li>
  </ul>
</div>
</nav>
<div class="container-fluid">
  <div class="row">
    <div class="headers col-12" id="#a">
      <h1>Persewaan Lapangan</h1>
      <h5>Web Persewaan Lapangan Online Terpercaya</h5>
      <div class="row justify-content-center">

        <form class="col-sm-6" action="sewalapangan.php" method="post">
          <input type="text" name="cari" class="form-control" style="opacity:0.7" placeholder="Pencarian...">
        </form>

      </div>
    </div>
  </div>
  <div class="tittle" align="center">
    <h2 style="color:#8aa270;">Field Rental Menu</h2>
  </div>
  <div class="row my-3">
    <?php
    // membuat perintah sql utk menampilkan data
    if (isset($_POST["cari"])) {
      // query jikka pencarian
      $cari = $_POST["cari"];
      $sql = " select * from lapangan where id_lapangan like '%$cari%' or nama like '%$cari%'
      or harga like '%$cari%' or ukuran like '%$cari%' or lokasi like '%$cari%' or stok like '%$cari%'";
    }else {
      // query jika tidak mencari
      $sql = " select * from lapangan";
    }
    // eksekusi perintah sql nya
    $query = mysqli_query($connect, $sql);
  ?>

     <?php foreach ($query as $lapangan): ?>
       <!-- start card 1 -->
      <div class="card col-md-3 mb-3 bg-light" align="center">
        <img src="image/<?php echo $lapangan["image"]; ?>" class="card-img-top" height="200px">
        <div class="card-header bg-success" bg-info text-white>
          <!-- ini tempat judulnya -->
          <h4 class="text-white"><?php echo $lapangan["nama"]; ?></h4>
        </div>
        <div class="card-body" align="center">
          <h5 class="text-success"><?php echo "Rp ".$lapangan["harga"]; ?></h5>
          <br>
          <h6 class="text-secondary"><?php echo "Ukuran: ".$lapangan["ukuran"]; ?></h6>
        </div>
        <div class="card-footer">
          <button type="button" class="btn btn-sm btn-secondary"
          onclick='Detail(<?php echo json_encode($lapangan); ?>)'
          data-toggle="modal" data-target="#modal_detail">Detail</button>
        </div>
      </div>
    <!-- end card 1 -->
     <?php endforeach; ?>
     <!-- modal1 -->
    <div class="modal fade" id="modal_detail">
      <div class="modal-dialog">
        <div class="modal-content">
           <div class="modal-header bg-dark">
             <h4 class="text-white">Detail Lapangan</h4>
           </div>
           <div class="modal-body">
             <div class="row">
               <div class="col-6" >
                 <!-- buat gb -->
                 <img id="image" style="width:100%; height: auto;">
               </div>
               <div class="col-6">
                 <!-- deskripsi -->
                 <h4 id="nama"></h4>
                 <h4 id="harga"></h4>
                 <h4 id="ukuran"></h4>
                 <h4 id="lokasi"></h4>
                 <h4 id="stok"></h4>

                 <form action="proses_cart.php" method="post">
                   <input type="hidden" name="id_lapangan" id="id_lapangan">
                   Jumlah Sewa
                   <input type="number" name="jumlah_sewa" id="jumlah_sewa"
                   class="form-control" min="1">
                   <br>
                   <button type="submit" name="add_to_cart" class="btn btn-success">
                   Tambah Ke Keranjang</button>
                 </form>
               </div>
             </div>
           </div>
        </div>
      </div>
    </div>
    <!-- end modal 1 -->
  </div>
</div>
<div class="col-12 footer bg-success text-white">
  <h5 align="center" >&copy; Copyright by Sall2020</h5>
</div>
  </body>
</html>
