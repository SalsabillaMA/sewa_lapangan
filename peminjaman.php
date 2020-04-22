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
  <title>Riwayat Customer</title>
  <!-- Load bootstrap css -->
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="css-admin.css">
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
    <li class="nav-item"><a href="sewalapangan.php" class="nav-link h5 mt-1 text-white">Beranda</a></li>
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

<div class="transaksi">
  <div class="container">
    <br>
    <br>
    <br>
    <div class="card mt-3">
      <div class="card header bg-secondary">
        <h4 class="text-white">Riwayat Transaksi</h4>
      </div>
      <div class="card-body">
        <?php
        $sql = "select * from peminjaman t inner join customer c on t.id_customer = c.id_customer
        where t.id_customer = '".$_SESSION["id_customer"]."' order by t.tgl_pinjam desc";
        // pake customer biar namanya muncul ada titiknya krn buat menyambungkan string
        // dan string lain
        $query = mysqli_query($connect, $sql);
         ?>


         <ul class="list-group">
           <?php foreach ($query as $peminjaman): ?>
             <li class="list-group-item mb-4">
             <h6>ID Transaksi: <?php echo $peminjaman["id_pinjam"]; ?></h6>
             <h6>Nama Pembeli: <?php echo $peminjaman["nama_customer"]; ?></h6>
             <h6>Tgl.Transaksi: <?php echo $peminjaman["tgl_pinjam"]; ?></h6>
             <h6>List Barang :</h6>

             <?php
             $sql2 = "select * from detail_pinjam d inner join lapangan b
             on d.id_lapangan = b.id_lapangan
             where d.id_pinjam='".$peminjaman["id_pinjam"]."'";
             $query2 = mysqli_query($connect, $sql2);
             ?>

             <table class="table table-borderless">
               <thead>
                 <tr>
                   <th>Nama</th>
                   <th>Jumlah</th>
                   <th>Harga</th>
                   <th>Lama Sewa</th>
                   <th>Total</th>
                 </tr>
               </thead>
               <tbody>
                 <?php $total = 0; foreach ($query2 as $detail): ?>
                   <tr>
                     <td><?php echo $detail["nama"]; ?></td>
                     <td><?php echo $detail["jumlah"]; ?></td>
                     <td>Rp <?php echo number_format($detail["harga"]); ?></td>
                     <td><?php echo $detail["lama_sewa"] ?></td>
                     <td>
                       Rp <?php echo number_format($detail["harga"]*$detail["jumlah"]*$detail["lama_sewa"]); ?>
                     </td>
                   </tr>
                 <?php
                 $total += ($detail["harga"]*$detail["jumlah"]*$detail["lama_sewa"]);
               endforeach; ?>
               <!-- paham ya sampai sini? apahm pak coba nak -->
               </tbody>
             </table>
             <h6 class="text-danger">Total: Rp <?php echo number_format($total); ?></h6>
             </li>
           <?php endforeach; ?>
         </ul>
      </div>
    </div>
  </div>

</div>
<div class="col-12 footer bg-success text-white">
  <h5 align="center" >&copy; Copyright by Sall2020</h5>
</div>
  </body>
</html>
