<?php 

include "connection.php";
include "functions.php";
// $siswa=$db->query("select * from siswa");
// $data_siswa=$siswa->fetchAll();

if(isset($_POST['search']))
{
    $filter=$_POST['search'];
    $search=$db->prepare("select * from data_siswa where nama_siswa=? or sekolah=? or motivasi=?");
    $search->bindValue(1,$filter,PDO::PARAM_STR);
    $search->bindValue(2,$filter,PDO::PARAM_STR);
    $search->bindValue(3,$filter,PDO::PARAM_STR);
    $search->execute();     

    $tampil_data=$search->fetchAll();
    $row=$search->rowCount();
  
}else{
    $data=$db->query("select * from tabel_siswa");
    $tampil_data=$data->fetchAll();
  
}

$temp_arr=[];
foreach ($data_siswa as $value) {
    $temp_arr[]=$value['sekolah'];
}
$temp_new=array_unique($temp_arr);

$showFilter=[];
if (isset($_POST['filter'])) {
  $filter=$_POST['filter'];
  if ($filter=="") {
    $showFilter=$data_siswa;
  }else {
    foreach ($data_siswa as $key) {
      if ($key[2]==$filter) {
        $showFilter[]=[$key['id_siswa'],$key['nama_siswa'],$key['sekolah'],$key['motivasi']];
      }
    }
  }
}else {
  $showFilter=$data_siswa;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col">
              <!-- Tabel Siswa -->
                <table class="table table-striped">
                    <thead>
                      <tr>
                        <th scope="col" class="h3">Tabel Siswa</th>
                      </tr>
                    </thead>
                    <thead>
                    <form action="index.php" method="post">
      <select name="filter" id="" class="w-75">
        <option value="">All</option>
      <?php foreach ($temp_new as $key) : ?>
        <option value="<?php echo $key; ?>"><?php echo $key; ?></option>
      <?php endforeach; ?>
      </select>
      <input type="submit" value="filter">
      </form>
                      <tr>
                        <th scope="col">Id Siswa</th>
                        <th scope="col">Nama Siswa</th>
                        <th scope="col">Sekolah</th>
                        <th scope="col">Motivasi</th>
                        <th scope="col">Opsi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($data_siswa as $key): ?>
                      <tr>
                        <td><?php echo $key["id_siswa"]; ?></td>
                        <td><?php echo $key["nama_siswa"]; ?></td>
                        <td><?php echo $key["sekolah"]; ?></td>
                        <td><?php echo $key["motivasi"]; ?></td>
                        <td><a class="btn btn-danger" data-toggle="modal" data-target="#showModal">hapus</a>|<a class="btn btn-primary" href="edit.php?id_siswa=<?php echo $key["id_siswa"]; ?>">edit</a></td>
                      </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
            </div>
        </div>
    </div>
    <div class="container mt-3">
      <div class="row">
        <div class="col d-flex">
          <form class="col-6 d-flex flex-column mx-auto" action="functions.php" method="POST">
            <p class="h3">Masukkan Data Siswa</p>
                  <div class="form-group">
                      <label for="exampleInputEmail1">Nama Siswa</label>
                      <input type="text" name="nama_siswa" class="form-control">
                  </div>
                  <div class="form-group">
                      <label for="exampleInputEmail1">Sekolah</label>
                      <input type="text" name="sekolah" class="form-control">
                  </div>
                  <div class="form-group">
                      <label for="exampleInputEmail1">Motivasi</label>
                      <input type="text" name="motivasi" class="form-control">
                  </div>

                  <button type="submit" class="col-3 btn btn-primary">simpan</button>
              </form>
            <div class="col-6">
            <h3>Cari Banyak Data Siswa</h3>
            <form class="from-inline mt-3" action="index.php" method="POST">
                <input type="text" class="from-control" name="search" placeholder="cari">
                <input class="btn-primary" type="submit" value="cari">
            </form>
            <?php if (isset($row)): ?>
                      <div class="alert alert-primary alert-dismissible fade-show" role="alert">
                        <p class="lead"><?php echo $row; ?> Data Ditemukan</p>
                        <button type="button" class="close" data-dismiss="alert" aria-label="close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                    <?php endif; ?>
        </div>
        </div>
      </div>
    </div>
                  <!-- Modal -->
<div class="modal"  id="showModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Hapus Tabel</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Apakah Anda Yakin Ingin Menghapus Data Tabel Ini ?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <a type="button" class="btn btn-primary" href="delete.php?id_siswa=<?php echo $key['id_siswa']; ?>">Hapus</a>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>    
</body>
</html>