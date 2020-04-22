<?php
session_start();
if (!isset($_SESSION["id_admin"])) {
  header("location:login_admin.php");
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
  <nav class="navbar-expand-md bg-dark navbar-light fixed-top">
  <a href="#">
    <img src="a.png" width="50" align="left" alt="">
  </a>

<!-- pemanggilan icon menu saat menubar disembunyikan -->
<button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#menu">
  <span class="navbar navbar-toggler-icon"></span>
</button>

<!-- daftar menu pada navbar -->
<div class="collapse navbar-collapse" id="menu">
  <ul class="navbar-nav">
    <li class="nav-item"><a href="lapangan.php" class="nav-link h5 mt-1 text-white">Lapangan</a></li>
    <li class="nav-item"><a href="admin.php" class="nav-link h5 mt-1 text-white">Admin</a></li>
    <li class="nav-item"><a href="customer.php" class="nav-link h5 mt-1 text-white ">Customer</a></li>
    <li class="nav-item"><a href="riwayat.php" class="nav-link h5 mt-1 text-white ">Riwayat</a></li>
 </ul>
 <ul class="navbar-nav ml-auto">
 <li class="nav-item">
   <a href="proses_login_admin.php?logout=true" class="nav-link h5 mt-2 text-white" ><?php echo $_SESSION["nama"]; ?> <img src="logoutt.png" width="30" align="left" alt=""> </a>
 </li>
 </ul>
</div>
</nav>
<div class="riwayat">
  <br>
  <br>
  <br>
  <div class="container">
    <div class="card mt-3">
      <div class="card header bg-secondary">
        <h4 class="text-white">Riwayat Transaksi</h4>
      </div>
      <div class="card-body">
        <?php
        $sql = "select * from peminjaman t inner join customer c on t.id_customer = c.id_customer
         order by t.tgl_pinjam desc";
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
             <h6>
               Status:
               <?php if ($peminjaman["status"] == "0"): ?>
                 <a href="proses_cart.php?comeback=true&id_pinjam=<?php echo $peminjaman["id_pinjam"];?>">
                   <button type="button" class="btn btn-sm btn-info">Kembali</button>
                 </a>
               <?php else: ?>
                 Telah Kembali
               <?php endif; ?>
             </h6>
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
<div class="col-12 footer bg-dark text-white">
  <h5 align="center" >&copy; Copyright by Sall2020</h5>
</div>
  </body>
</html>
