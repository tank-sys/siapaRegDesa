<?php
$servername = "localhost:6969";
$username = "ta";
$password = "tank";
$dbname = "smard";
$conn = new MySQLi($servername, $username, $password, $dbname);
if ($conn->connect_error) {die("Connection failed: Error nda..." . $conn->connect_error);} 

$join = "SELECT * FROM data_keluarga JOIN biodata_wni ON biodata_wni.no_kk = data_keluarga.no_kk WHERE biodata_wni.stat_hbkel='1' AND biodata_wni.flag_status='0' ORDER BY data_keluarga.no_rw ASC";
$bacapddk = $conn->query("select * FROM biodata_wni JOIN data_keluarga ON data_keluarga.no_kk = biodata_wni.no_kk WHERE flag_status='0';");
$ident = $conn->query("select nama_kel,nama_kec,nama_kab,last_kons FROM instansi;");
$perangkat = $conn->query("select * FROM biodata_wni JOIN pkrjn_master ON biodata_wni.jenis_pkrjn = pkrjn_master.no JOIN data_keluarga ON data_keluarga.no_kk = biodata_wni.no_kk WHERE biodata_wni.jenis_pkrjn = '85' ORDER BY biodata_wni.tgl_lhr ASC;");
$jumperangkat = mysqli_num_rows($perangkat);

$bacakk  = $conn->query($join);
$jumlahKK = mysqli_num_rows($bacakk);
$jumlahpddk = mysqli_num_rows($bacapddk);
$ident = mysqli_fetch_array($ident);

$hari = array (0 =>  'Ahad', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'); //gunakan date('w', strtotime($tanggal);
$status = array (1 =>  'Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati');
$jeniskelamin = array (1 =>  'Laki-Laki', 'Perempuan');
$jeniskel = array (1 =>  'L', 'P');

function uckata($kata) {return ucwords(strtolower($kata));}
function bulan($tanggal){
 $bulan = array (1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
 $split = explode('-', $tanggal);
 return $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
}
function pekerjaan($no) {global $conn;
$jenispekerjaan = mysqli_fetch_row($conn->query("select * FROM pkrjn_master WHERE no='$no'"));
if ($jenispekerjaan[0] == "2"){$jenispekerjaan[1] = 'Ibu Rumah T';}
if ($jenispekerjaan[0] == "1"){$jenispekerjaan[1] = 'Belum Bekerja';}
//$jenispekerjaan[1] = preg_replace('///', ' ', htmlentities($jenispekerjaan[1]));
return $jenispekerjaan[1];
}

function pendidikan($no) {global $conn;
$pendidikan = mysqli_fetch_row($conn->query("select * FROM pddkn_master WHERE no='$no'"));
//if ($jenispekerjaan[0] == "2"){$jenispekerjaan[1] = 'Ibu Rumah T';}
//if ($jenispekerjaan[0] == "1"){$jenispekerjaan[1] = 'Belum Bekerja';}

return $pendidikan[1];
}

function hitung_umur($tanggal_lahir){
$birthDate = new DateTime($tanggal_lahir);
$today = new DateTime("today");
if ($birthDate > $today) { 
  exit("0 tahun 0 bulan 0 hari");
}
$y = $today->diff($birthDate)->y;
$m = $today->diff($birthDate)->m;
$d = $today->diff($birthDate)->d;
return $y." tahun ".$m." bulan ".$d." hari";
}

function warna(){
$warna = array ('text-white bg-primary', 'text-white bg-secondary', 'text-white bg-success', 'text-white bg-danger', 'text-white bg-dark', 'text-dark bg-info','text-dark bg-light','text-white bg-dark'); 
for($i=0;$i<6;$i++){
$warno = array_rand($warna);
$warne = $warna[$warno];
}
return $warne;
}
function randomColor(){
$rcolor = '#';
for($i=0;$i<6;$i++){
$rNumber = rand(0,15);
switch ($rNumber) {case 10:$rNumber='A';break;
case 11:$rNumber='B'; break;
case 12:$rNumber='C'; break;
case 13:$rNumber='D'; break;
case 14:$rNumber='E'; break;
case 15:$rNumber='F'; break; } 
$rcolor .= $rNumber;
	}
return $rcolor;
	}

?>

<!doctype html>
<html lang="en" class="h-100">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?php echo uckata($ident['nama_kel'])." ".uckata($ident['nama_kec'])." ".uckata($ident['nama_kab']);?>">
    <meta name="author" content="Tank Tink Tunk Tenk">
    <title>Data Penduduk Desa <?php echo uckata($ident['nama_kel']);?></title>
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
                <h3> <?php echo $jumlahpddk;?>   </h3>
                
              <a href="?p=penduduk" class="small-box"> Detail </a>
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
        