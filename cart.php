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
  <title>Persewaan</title>
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
<div class="cart">
<div class="container-fluid col-10">
  <br>
  <br>
  <br>
  <div class="card">
    <div class="card-header bg-secondary">
      <h4 class="text-white" align="center">Keranjang Persewaan Anda</h4>
    </div>
    <div class="card-body">
      <table class="table">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Harga</th>
            <th>Jumlah</th>
            <th>Total</th>
          </tr>
        </thead>
        <tbody>
          <?php $no = 1; ?>
          <?php foreach ($_SESSION["cart"] as $cart): ?>
            <tr>
              <td><?php echo $no; ?></td>
              <td><?php echo $cart["nama"]; ?></td>
              <td>Rp <?php echo $cart["harga"]; ?></td>
              <td><?php echo $cart["jumlah_sewa"]; ?></td>
              <td>Rp <?php echo $cart["jumlah_sewa"]*$cart["harga"]; ?></td>
              <td>
              <a href="proses_cart.php?hapus=true&id_lapangan=<?php echo $cart["id_lapangan"] ?>">
                <button type="button" class="btn btn-sm btn-danger">Hapus</button>
              </a>
            </td>
            </tr>
            <?php $no++; endforeach; ?>

        </tbody>
      </table>
    <div class="col-3" >
      <form action="proses_cart.php?checkout=true" method="post" >
        Tgl. Kembali
        <input type="date" name="tgl_kembali" class="form-control" required>
        <br>
        <button type="submit" class="btn btn-success"> Checkout</button>
      </form>
    </div>

      </div>
    </div>
  </div>
</div>
<div class="col-12 footer bg-success text-white">
  <h5 align="center" >&copy; Copyright by Sall2020</h5>
</div>
  </body>
</html>
