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
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Data Lapangan</title>
     <link rel="stylesheet" href="assets/css/bootstrap.min.css">
     <link rel="stylesheet" href="css-admin.css">
     <script src="assets/js/jquery.min.js"></script>
     <script src="assets/js/popper.min.js"></script>
     <script src="assets/js/bootstrap.min.js"></script>
     <script type="text/javascript">
       Add = () => {
         document.getElementById('action').value = "insert";
         document.getElementById('id_lapangan').value = "";
         document.getElementById('nama').value = "";
         document.getElementById('harga').value = "";
         document.getElementById('ukuran').value = "";
         document.getElementById('lokasi').value = "";
         document.getElementById('stok').value = "";
       }

       Edit = (item) => {
         document.getElementById('action').value = "update";
         document.getElementById('id_lapangan').value = item.id_lapangan;
         document.getElementById('nama').value = item.nama;
         document.getElementById('harga').value = item.harga;
         document.getElementById('ukuran').value = item.ukuran;
         document.getElementById('lokasi').value = item.lokasi;
         document.getElementById('stok').value = item.stok;

       }
     </script>
   </head>
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
   <body>

     <?php
     // membuat perintah sql utk menampilkan data siswa
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
<div class="lapangan">
<div class="container col-10" id="#a">
  <br><br>
  <!-- start card -->
  <div class="card">
    <div class="card-header bg-secondary text-white">
      <h4 align="center" >Data Lapangan</h4>
    </div>
    <div class="card-body">
      <form action="lapangan.php" method="post">
        <input type="text" name="cari" class="form-control" placeholder="Pencarian...">
      </form>
      <table class="table" border="2">
        <thead>
            <tr>
              <th>ID Lapangan</th>
              <th>Nama</th>
              <th>Harga</th>
              <th>Ukuran</th>
              <th>Lokasi</th>
              <th>Stok</th>
              <th>Image</th>
              <th>Option</th>
            </tr>
          </thead>

          <tbody>
            <?php foreach ($query as $lapangan): ?>
             <tr>
              <td><?php echo $lapangan["id_lapangan"]; ?></td>
              <td><?php echo $lapangan["nama"]; ?></td>
              <td><?php echo $lapangan["harga"]; ?></td>
              <td><?php echo $lapangan["ukuran"]; ?></td>
              <td><?php echo $lapangan["lokasi"]; ?></td>
              <td><?php echo $lapangan["stok"]; ?></td>
              <td>
                <img src="<?php echo 'image/'.$lapangan['image']; ?>" alt="Foto Lapangan"
                width="200" />
              </td>
              <td>
                <button data-toggle="modal" data-target="#modal_lapangan" type="button"
                class="btn btn-sm btn-info" onclick='Edit(<?php echo json_encode($lapangan);?>)'>
                Edit </button>
                <br>
                <a href="crud_lapangan.php?hapus=true&id_lapangan=<?php echo $lapangan ["id_lapangan"];?>"
                  onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                  <button type="button" class="btn btn-sm btn-danger"> Hapus </button> </a>
              </td>
            <?php endforeach; ?>
          </tr>
        </tbody>
      </table>
      <button data-toggle="modal" data-target="#modal_lapangan"
      type="button" class="btn btn-sm btn-success" onclick="Add()">
      Tambah Data
    </button>
    </div>
  </div>
</div>
  <!-- end card -->

  <!-- form modal -->
  <div class="modal fade" id="modal_lapangan">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="crud_lapangan.php" method="post" enctype="multipart/form-data">
        <div class="modal-header bg-danger text-white">
          <h4>Form Lapangan</h4>
        </div>
        <div class="modal-body">
          <input type="hidden" name="action" id="action">
          ID Lapangan
          <input type="number" name="id_lapangan" id="id_lapangan"
          class="form-control" required />
          Nama
          <input type="text" name="nama" id="nama"
          class="form-control" required />
          Harga
          <input type="text" name="harga" id="harga"
          class="form-control" required />
          Ukuran
          <input type="text" name="ukuran" id="ukuran"
          class="form-control" required />
          Lokasi
          <input type="text" name="lokasi" id="lokasi"
          class="form-control" required />
          Stok
          <input type="text" name="stok" id="stok"
          class="form-control" required />
          Image
        <input type="file" name="image" id="image" class="form-control">
        <!-- upload file yng akan di upload -->
      </div>
      <div class="modal-footer">
        <button type="submit" name="save_lapangan" class="btn btn-primary">
          Simpan</button>
      </div>
      </form>
    </div>

  </div>
  </div>
  <!-- end form modal -->
</div>
<div class="col-12 footer bg-dark text-white">
  <h5 align="center" >&copy; Copyright by Sall2020</h5>
</div>
   </body>
   </html>
