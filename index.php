<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "siswa";

$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { //cek koneksi>
    die("tidak bisa koneksi ke database");
}
$nim    = "";
$nama   = "";
$password = "";
$kelas  = "";
$pelajaran  = "";
$sukses     = "";
$error = "";
$id = "";
//$q1 = "";
//$koneksi = "";
//$query = "";
//$r1 = "";

if(isset($_GET['op'])){
  $op = $_GET['op'];
}else{
    $op = "";
}
if($op == 'delete'){
     $id = $_GET['id'];
     $sql1 = "delete from mahasiswa where id='$id'";
     $q1 = mysqli_query($koneksi,$sql1);
     if($q1){
        $sukses = "Berhasil hapus data";
     }else{
         $error = "Gagal melakukan delete data";
     }
}
if($op == 'edit'){
  $id           = isset($_GET['id']) ? $_GET['id'] : '';
  $sql1         = "select * from mahasiswa where id = 'id'";
  $q1           = mysqli_query($koneksi,$sql1);
  $r1           = mysqli_fetch_array($q1);
  $nim          = isset($r1['nim']) ? $r1['nim'] : '';
  $nama         = isset($r1['nama']) ? $r1['nama'] : '';
  $password     = isset($r1['psssword']) ? $r1['password'] : '';
  $kelas        = isset($r1['kelas']) ? $r1['kelas'] : '';
  $pelajaran    = isset($r1['pelajaran']) ? $r1['pelajaran  '] : '';
  
}
if (isset($_POST['simpan'])) { //untuk create
    $nim         = $_POST['nim'];
    $nama        = $_POST['nama'];
    $password    = $_POST['password'];
    $kelas       = $_POST['kelas'];
    $pelajaran   = $_POST['pelajaran'];


    if($nim == ''){
      $error = "Data tidak ditemukan";
    }

    if($nim && $nama && $password && $kelas && $pelajaran) {
        if($op == 'edit'){ //unruk update
            $sql1 = "update mahasiswa set nim = $nim,nama='$nama',password='$password',kelas='$kelas',pelajaran='$pelajaran' where id='$id'";
            $q1 = mysqli_query($koneksi,$sql1);
            if($q1){
                $sukses = "Data berhasil di update";
        }else{
            $error = "Data gagal di update";
        }
        }else{ //insert data
            $sql1 = "insert into mahasiswa(nim,nama,password,kelas,pelajaran) values ('$nim','$nama','$password','$kelas','$pelajaran')";
            $q1 = mysqli_query($koneksi,$sql1);
            if ($q1) {
            $sukses = "Berhasil Memasukan Data Baru";
     }else{
            $error = "Gagal Memasukan Data";
     }
    }
    }else{
        $error = "Silahkan Masukan Semua Data";
    }
}
 ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kelas Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        .mx-auto {
            width: 800px
        }

        .card {
            margin-top: 10px
        }
    </style>
</head>
<body>
    <div class="mx-auto">
        <!-- Masukan Data -->
        <div class="card">
            <h5 class="card-header">Create / Edit Data</h5>
            <div class="card-body">
                <?php
                if ($error) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php
                 header("refresh:5;url=index.php"); //5 = detik
                }
                ?>
                <?php
                if ($sukses) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                 <?php
                    header("refresh:5;url=index.php");
                }
                ?>

                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="nim" class="form-label">NIM</label>
                        <div class="com-sm-10">
                            <input type="text" class="form-control" id="nim" name="nim" value="<?php echo $nim ?>">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <div class="com-sm-10">
                            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama ?>">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="com-sm-10">
                            <input type="password" class="form-control" id="password" name="password" value="<?php echo $password ?>">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="kelas" class="form-label">Kelas</label>
                        <div class="com-sm-10">
                            <select class="form-control" name="kelas" id="kelas">
                                <option value="">- Pilih Kelas -</option>
                                <option value="X" <?php if ($kelas == "X") echo "selected" ?>>X</option>
                                <option value="XI" <?php if ($kelas == "XI") echo "selected" ?>>XI</option>
                                <option value="XII" <?php if ($kelas == "XII") echo "selected" ?>>XII</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="pelajaran" class="form-label">Pelajaran</label>
                        <div class="com-sm-10">
                            <select class="form-control" name="pelajaran" id="pelajaran">
                                <option value="">- Pilih Pelajaran -</option>
                                <option value="akuntansi" <?php if ($pelajaran == "akuntansi") echo "selected" ?>>Akuntansi</option>
                                <option value="multimedia" <?php if ($pelajaran == "multimedia") echo "selected" ?>>Multimedia</option>
                                <option value="rekayasa perangkat lunak" <?php if ($pelajaran == "rekayasa perangkat lunak") echo "selected" ?>>Rekayasa Perangkat Lunak</option>
                                <option value="teknologi komputer dan jaringan" <?php if ($pelajaran == "teknologi komputer dan jaringan") echo "selected" ?>>Teknologi Komputer Dan Jaringan</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
        <!-- Untuk Mengeluarkan Data -->
        <div class="card">
            <h5 class="card-header" text-while bg-secondary>Data Siswa</h5>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nim</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Password</th>
                            <th scope="col">Kelas</th>
                            <th scope="col">Pelajaran</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    <tbody>
                        <?php
                        $sql2 = "select * from mahasiswa order by id desc";
                        $q2 = mysqli_query($koneksi,$sql2);
                        $urut = 1;
                        while ($r2 = mysqli_fetch_array($q2)) {
                            $id = $r2['id'];
                            $nim = $r2['nim'];
                            $nama = $r2['nama'];
                            $password = $r2['password'];
                            $kelas = $r2['kelas'];
                            $pelajaran = $r2['pelajaran'];

                        ?>
                            <tr>
                                <th scope="row"><?php echo $urut++ ?></th>
                                <td scope="row"><?php echo $nim ?></td>
                                <td scope="row"><?php echo $nama ?></td>
                                <td scope="row"><?php echo $password ?></td>
                                <td scope="row"><?php echo $kelas ?></td>
                                <td scope="row"><?php echo $pelajaran ?></td>
                                <td scope="row">
                                    <a href="index.php?op=edit&id=<?php echo $id?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                    <a href="index.php?op=delete&id=<?php echo $id?>" onclick="return confirm('Yakin mau delete data?')"><button type="button" class="btn btn-danger">Delete</button></a>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                    </thead>
                </table>
            </div>
</body>
</html>