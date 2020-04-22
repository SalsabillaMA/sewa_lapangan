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
     <title>Data Admin</title>
     <link rel="stylesheet" href="assets/css/bootstrap.min.css">
     <link rel="stylesheet" href="css-admin.css">
     <script src="assets/js/jquery.min.js"></script>
     <script src="assets/js/popper.min.js"></script>
     <script src="assets/js/bootstrap.min.js"></script>
     <script type="text/javascript">
       Add = () => {
         document.getElementById('action').value = "insert";
         document.getElementById('id_admin').value = "";
         document.getElementById('nama').value = "";
         document.getElementById('kontak').value = "";
         document.getElementById('username').value = "";
         document.getElementById('password').value = "";
       }

       Edit = (item) => {
         document.getElementById('action').value = "update";
         document.getElementById('id_admin').value = item.id_admin;
         document.getElementById('nama').value = item.nama;
         document.getElementById('kontak').value = item.kontak;
         document.getElementById('username').value = item.username;
         document.getElementById('password').value = item.password;
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
     // membuat perintah sql utk menampilkan data
     if (isset($_POST["cari"])) {
       // query jikka pencarian
       $cari = $_POST["cari"];
       $sql = " select * from admin where id_admin like '%$cari%' or nama like '%$cari%'
       or kontak like '%$cari%' or username like '%$cari%' or password like '%$cari%'";
     }else {
       // query jika tidak mencari
       $sql = " select * from admin";
     }
     // eksekusi perintah sql nya
     $query = mysqli_query($connect, $sql);
   ?>
   <div class="admin">
<div class="container col-10" id="#a">
  <br>
  <br>
  <br>
  <!-- start card -->
  <div class="card">
    <div class="card-header bg-secondary text-white">
      <h4 align="center" >Admin Penyewaan Lapangan</h4>
    </div>
    <div class="card-body">
      <form action="admin.php" method="post">
        <input type="text" name="cari" class="form-control" placeholder="Pencarian...">
      </form>
      <table class="table" border="2">
        <thead>
            <tr>
              <th>ID ADMIN</th>
              <th>Nama</th>
              <th>Kontak</th>
              <th>Username</th>
              <th>Password</th>
              <th>Option</th>
            </tr>
          </thead>

          <tbody>
            <?php foreach ($query as $admin): ?>
             <tr>
              <td><?php echo $admin["id_admin"];
              //nama "siswa" harus sama yg di database
              ?></td>
              <td><?php echo $admin["nama"]; ?></td>
              <td><?php echo $admin["kontak"]; ?></td>
              <td><?php echo $admin["username"]; ?></td>
              <td><?php echo $admin["password"]; ?></td>
              <td>
                <button data-toggle="modal" data-target="#modal_admin" type="button"
                class="btn btn-sm btn-info" onclick='Edit(<?php echo json_encode($admin);?>)'>
                Edit </button>
                <a href="crud_admin.php?hapus=true&id_admin=<?php echo $admin ["id_admin"];?>"
                  onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                  <button type="button" class="btn btn-sm btn-danger"> Hapus </button> </a>
              </td>
            <?php endforeach; ?>
          </tr>
        </tbody>
      </table>
      <button data-toggle="modal" data-target="#modal_admin"
      type="button" class="btn btn-sm btn-success" onclick="Add()">
      Tambah Data
    </button>
    </div>
  </div>
  <!-- end card -->

  <!-- form modal -->
  <div class="modal fade" id="modal_admin">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="crud_admin.php" method="post" enctype="multipart/form-data">
        <div class="modal-header bg-danger text-white">
          <h4>Form Admin</h4>
        </div>
        <div class="modal-body">
          <input type="hidden" name="action" id="action">
          ID Admin
          <input type="number" name="id_admin" id="id_admin"
          class="form-control" required />
          Nama
          <input type="text" name="nama" id="nama"
          class="form-control" required />
          Kontak
          <input type="text" name="kontak" id="kontak"
          class="form-control" required />
          Username
          <input type="text" name="username" id="username"
          class="form-control" required />
          Password
          <input type="password" name="password" id="password"
          class="form-control" required />
        <!-- upload file yng akan di upload -->
      </div>
      <div class="modal-footer">
        <button type="submit" name="save_admin" class="btn btn-primary">
          Simpan</button>
      </div>
      </form>
    </div>
  </div>
  </div>
  <!-- end form modal -->
</div>
</div>
<div class="col-12 footer bg-dark text-white">
  <h5 align="center" >&copy; Copyright by Sall2020</h5>
</div>
   </body>
 </html>
