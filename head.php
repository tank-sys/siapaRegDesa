<?php
include("./func.php");
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
            <a class="nav-link active" aria-current="page" href="./index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./cari.php">Cari Data</a>
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
<div class="container pt-3">
  <section class="pt-5 text-center" >
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-6 g-4">
          <div class="col">
            <!-- small box -->
            <div class="card text-center" >
              <div class="card-header <?php echo warna();?>">
Jumlah Penduduk
              </div>
              <div class="card-body text-center" >
                <h3> <?php echo mysqli_num_rows(data('0','0','0'));?>   </h3>
                
              <a href="?p=data" class="small-box"> Detail </a>
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
              <a href="index.php?p=perangkat" class="small-box">Detail</a>
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
        <div class="mx-auto" style="width: ;">Data Diupdate Hari 
        <?php
//        print_r($row);
        $r = explode(" ", $ident['last_kons']);
        $h = date('w', strtotime($r[0]));
        echo $hari[$h]. ", ";

        echo bulan($r[0]). " Pukul ".$r[1];?>
        </div>  
  
  </section>
        