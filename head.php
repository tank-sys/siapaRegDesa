<?php
include("./klas.php");
?>
<!doctype html>
<html lang="en" class="h-100">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?php echo uckata($ident['nama_kel'])." ".uckata($ident['nama_kec'])." ".uckata($ident['nama_kab']);?>">
    <meta name="author" content="Tank Tink Tunk Tenk">
    <title>Penduduk Desa <?php echo uckata($ident['nama_kel']);?></title>
<?php
include("./cdn/cssjs.php");
echo $cssawal;
?>
<meta name="theme-color" content="#7952b3">

  </head>
<body class="d-flex flex-column h-100">
<header>
  <!-- Fixed navbar -->
  <nav class="navbar navbar-expand-md fixed-top bg-dark">
    <div class="container-fluid">
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav me-auto mb-2 mb-md-0">
          <li class="nav-item">
            <a class="active" aria-current="page" href="./"><img src="https://upload.wikimedia.org/wikipedia/commons/b/b7/LOGO_KABUPATEN_GROBOGAN.png" width="30px"></a>
          </li>
        </ul>
<form action="./index.php" method="post"  class="d-flex">
              <select class="" name="Kolom" required="" style="width:80px;">
                <option value="nama">Nama</option>
                <option value="nik">NIK</option>
                <option value="nokk">No KK</option>
                <option value="ibu">Nama Ibu</option>
              </select>
          <input class="form-control me-2" type="text" name="q" >
          <button class="btn btn-outline-success" type="submit" name="submit">Search</button>
</form>
      </div>
    </div>
  </nav>
</header>

<main class="flex-shrink-0">
<div class="container py-3">
  <section class="pt-5 pb-3 text-center" >
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-6 g-4">
          <div class="col">
            <!-- small box -->
            <div class="card text-center" >
              <div class="card-header <?php echo warna();?>">
Jumlah Penduduk
              </div>
              <div class="card-body text-center" >
                <h3> <?php echo mysqli_num_rows($conn->query("SELECT * FROM biodata_wni WHERE flag_status='0'"));?>   </h3>
<small>
<?php echo mysqli_num_rows($conn->query("SELECT * FROM biodata_wni WHERE flag_status='0' AND jenis_klmin='1'"));?> ( Lk ) 
<?php echo mysqli_num_rows($conn->query("SELECT * FROM biodata_wni WHERE flag_status='0' AND jenis_klmin='2'"));?> ( Pr )
</small>
<a href="?p=data" class="float-right"> Detail </a>

              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col">
            <!-- small box -->
            <div class="card text-center">
              <div class="card-header <?php echo warna();?>">
Jumlah KK
              </div>
              <div class="card-body text-center">
                <h3><?php echo $jumlahKK;?></h3>
<small>
<?php echo mysqli_num_rows($conn->query("SELECT * FROM data_keluarga JOIN biodata_wni ON biodata_wni.no_kk = data_keluarga.no_kk WHERE biodata_wni.stat_hbkel='1' AND biodata_wni.flag_status='0' AND jenis_klmin='1'"));?> ( Lk ) 
<?php echo mysqli_num_rows($conn->query("SELECT * FROM data_keluarga JOIN biodata_wni ON biodata_wni.no_kk = data_keluarga.no_kk WHERE biodata_wni.stat_hbkel='1' AND biodata_wni.flag_status='0' AND jenis_klmin='2'"));?> ( Pr )
</small><br>
<a href="?p=kk" class="">Detail</a>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col">
            <!-- small box -->
            <div class="card text-center">
              <div class="card-header <?php echo warna();?>">
Perangkat Desa
              </div>
              <div class="card-body text-center">
                <h3><?php echo $jumperangkat;?></h3>
              <a href="./?p=data&k=85" class="small-box">Detail</a>
              </div>
            </div>
          </div>          <!-- ./col -->
          <div class="col">
            <!-- small box -->
            <div class="card text-center">
              <div class="card-header <?php echo warna();?>">
DUSUN / RT / RW
              </div>
              <div class="card-body text-center">
                <h3>3 / 14 / 5</h3>
                
              <a href="index.php?p=dusun" class="small-box">Detail</a>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col">
            <!-- small box -->
            <div class="card text-center">
              <div class="card-body text-center mt-2 p-0">
<p>
                <a href="?p=angka" class=""> Desa <?php echo uckata($ident['nama_kel']);?> <br>dalam <br> Statistik Angka </a>
<br>
                <a href="?p=balita" class=""> Balita</a> | <a href="?p=lansia" class=""> Lansia </a> 
                </p>
              </div>
              <div class="card-footer  <?php echo warna();?>">
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col">
            <!-- small box -->
            <div class="card text-center">
              <div class="card-header  <?php echo warna();?>">
<a href="./index.php?p=pdf">Grafik</a>              </div>
              <div class="card-body text-center">
<p>
              <a href="index.php?p=chart" class="small-box"><?php echo uckata($ident['nama_kel']);?> Dalam Grafik</a>
<br>
<br>
</p>

              </div>
            </div>
          </div>          <!-- ./col -->
        
  </div>
  </section>
        