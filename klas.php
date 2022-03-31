<?php
defined('web') or die ("Gak intuk akses langsung");

///koneksi
$servername = "localhost:6969";
$username = "ta";
$password = "tank";
$dbname = "smard";
$conn = new MySQLi($servername, $username, $password, $dbname);
if ($conn->connect_error) {die("Connection failed: Error nda..." . $conn->connect_error);} 

$join = "SELECT * FROM data_keluarga JOIN biodata_wni ON biodata_wni.no_kk = data_keluarga.no_kk WHERE biodata_wni.stat_hbkel='1' AND biodata_wni.flag_status='0' ORDER BY data_keluarga.no_rw ASC";
$bacakk  = $conn->query($join);
$jumlahKK = $conn->query($join)->num_rows;
$ident = $conn->query("SELECT nama_kel,nama_kec,nama_kab,last_kons FROM instansi;")->fetch_array();
$jumperangkat = $conn->query("SELECT * FROM biodata_wni JOIN pkrjn_master ON biodata_wni.jenis_pkrjn = pkrjn_master.no JOIN data_keluarga ON data_keluarga.no_kk = biodata_wni.no_kk WHERE biodata_wni.jenis_pkrjn = '85' ORDER BY biodata_wni.tgl_lhr ASC;")->num_rows;

/// array umum
$no = 1;
$hari = array (0 =>  'Ahad', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'); //gunakan date('w', strtotime($tanggal);
$jeniskelamin = array (1 =>  'Laki-Laki', 'Perempuan');
$jeniskel = array (1 =>  'L', 'P');
$dusunku = array (1 =>  'Mrayun', 'Termas', 'Getas');
$dusun = array('Dusun Mrayun' => array('1', '2'), 'Dusun Termas' => array('3'), 'Dusun Getas' => array('4', '5'));
$warna = array ('text-white bg-primary', 'text-white bg-secondary', 'text-white bg-success', 'text-white bg-danger', 'text-white bg-dark', 'text-dark bg-info','text-dark bg-light','text-white bg-dark'); 
$akerja = array('1' => "-",
'2' => "MENGURUS Rumah",
'3' => "PELAJAR / Mahasiswa",
'4' => "PENSIUNAN",
'5' => "A S N",
'6' => "T N I",
'7' => "Kepolisian R I",
'9' => "PETANI / PEKEBUN",
'11' => "NELAYAN / PERIKANAN",
'15' => "KARYAWAN SWASTA",
'16' => "KARYAWAN BUMN",
'17' => "KARYAWAN BUMD",
'18' => "KARYAWAN HONORER",
'19' => "BURUH HARIAN",
'20' => "BURUH TANI",
'21' => "BURUH NELAYAN",
'22' => "BURUH PETERNAKAN",
'23' => "P R T",
'29' => "TUKANG LAS",
'39' => "PERANCANG BUSANA",
'41' => "IMAM MESJID",
'45' => "USTADZ / MUBALIGH",
'46' => "JURU MASAK",
'48' => "ANGGOTA Dewan",
'49' => "ANGGOTA D P D",
'50' => "ANGGOTA B P K",
'85' => "PERANGKAT DESA",
'86' => "KEPALA DESA"
);

/// function umum
function uckata($kata) {return ucwords(strtolower($kata));}
function bulan($tanggal){
$bulan = array (1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
$split = explode('-', $tanggal);
return $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
}
function pekerjaan($no) {global $conn, $akerja;
$kerja = $conn->query("select * FROM pkrjn_master WHERE no='$no'")->fetch_row();
//if (isset($jenispekerjaan[0]) && ($jenispekerjaan[0] == $akerja[0])){}
if (isset($kerja[1])){
foreach ($akerja as $key => $val){if ($kerja[0] == $key) {$kerja[1] = $val;}}
return uckata($kerja[1]);
}else{return ("Gak Jelas");}
}
function agama($no) {global $conn;
$agama = $conn->query("SELECT * FROM agama_master WHERE no='$no'")->fetch_row();
if (isset($agama[1])){
return uckata($agama[1]);
}else{return ("Lain-lain");}}

function status($no) {global $conn;
$status = $conn->query("SELECT * FROM kwn_master WHERE no='$no'")->fetch_row();
if (isset($status[1])){
return uckata($status[1]);
}else{return ("Gak Jelas");}}

function sekolah($no) {global $conn;
$pendidikan = $conn->query("SELECT * FROM pddkn_master WHERE no='$no'")->fetch_row();
if (isset($pendidikan[1])){
return $pendidikan[1];
}else{return ("Lain-lain");}
}

function cacat($no) {global $conn;
$cacat = $conn->query("SELECT * FROM cct_master WHERE no='$no'")->fetch_row();
if (isset($cacat[1])){
return uckata($cacat[1]);
}else{return ("Lain-lain");}
}
function died($message){global $jsawal, $ident, $hari; 
echo $message;
include('footer.php');
die($message);
}
function usia($tanggal_lahir){
$birthDate = new DateTime($tanggal_lahir);
$today = new DateTime("today");
if ($birthDate > $today) { exit("0 tahun 0 bulan 0 hari");}
$y = $today->diff($birthDate)->y;
$m = $today->diff($birthDate)->m;
$d = $today->diff($birthDate)->d;
return $y." tahun ".$m." bulan ".$d." hari";
}
function warna(){
global $warna;
for($i=0;$i<6;$i++){ $warno = array_rand($warna); $warne = $warna[$warno]; }
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
} return $rcolor; }

function data($rw,$rt,$jenis) {
global $conn;
//$k pekerjaan //$a agama //$s pendidikan akhir //$r status perRABIan
if ($jenis !== '0'){$jeniss = "AND biodata_wni.jenis_klmin='$jenis'";}else {$jeniss = "";}
if ($rt !== '0'){$rts = "AND data_keluarga.no_rt='$rt'";}else {$rts = "";}
if ($rw !== '0'){$rws = "AND data_keluarga.no_rw='$rw'";}else {$rws = "";}

if (!empty($_GET['k'])){
$kerja = "AND biodata_wni.jenis_pkrjn='$_GET[k]'";
$kerjas = ", biodata_wni.jenis_pkrjn ASC";
}if (empty($_GET['k'])){$kerja = ""; $kerjas = ""; }

if (!empty($_GET['a'])){
$aga = "AND biodata_wni.agama='$_GET[a]'";
$agam = ", biodata_wni.agama ASC";
}if (empty($_GET['a'])){$aga = ""; $agam = ""; }

if (!empty($_GET['s'])){
$skol = "AND biodata_wni.pddk_akh='$_GET[s]'";
}if (empty($_GET['s'])){$skol = ""; }

if (!empty($_GET['r'])){
$rabi = "AND biodata_wni.stat_kwn='$_GET[r]'";
}if (empty($_GET['r'])){$rabi = "";}

if (!empty($_GET['c'])){
$cacat = "AND biodata_wni.pnydng_cct='$_GET[c]'";
}if (empty($_GET['c'])){$cacat = "";}

if ( (!empty($_GET['u'])) && (is_numeric($_GET['u'])) ){
$umur = "AND (YEAR(CURDATE())-YEAR(biodata_wni.tgl_lhr)) < $_GET[u]";
} if (empty($_GET['u'])) {$umur = "";}

$rwrt = $conn->query("SELECT *
FROM biodata_wni
JOIN data_keluarga ON data_keluarga.no_kk = biodata_wni.no_kk
WHERE biodata_wni.flag_status='0' $rws $rts $jeniss $kerja $aga $skol $rabi $umur $cacat
ORDER BY data_keluarga.no_rw ASC, data_keluarga.no_rt ASC
;");
return $rwrt;
}

// function khusus
function kepalakk() { ///kepala keluarga
global $bacakk, $no;
echo '
<table class="table table-sm table-hover">
  <thead>
    <tr>
      <th scope="col" width="40" class="text-center">#</th>
      <th scope="col" width="150" class="text-center">No KK</th>
      <th scope="col" align="center">Nama Lengkap</th>
      <th scope="col" width="5" class="text-center">RT</th>
      <th scope="col" width="5" class="text-center">RW</th>
    </tr>
  </thead>
';
while($row = $bacakk->fetch_assoc()) {
$nama = strtolower($row["nama_lgkp"]);
echo 
"<tr><td>".
$no++. ".</td><td><a class='text-dark' href='./?no=".base64_encode($row['no_kk'])."'>" . $row["no_kk"]. "</a></td><td>" . ucwords($nama)."</td><td>00" . $row["no_rt"]. "</td><td>00" . $row["no_rw"].
"</td></tr>";
}
echo "</table>";
} //Kepala KK


function dusun() {
global $no, $conn, $warna;

echo "<div class='card mx-auto text-center mb-3 pb-3 pt-3 bg-success text-white border border-dark' style='width:35%'><h5>Daftar Dusun, RT dan RW Desa Termas</h5></div>";

//// Per Dusun
echo '<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 pl-3 pb-5 my-0">';
echo '<div class="col">';
echo '<div class="card text-center" >';
echo '<div class="card-header font-weight-bold bg-dark" style="color: #fff"><h3>DUSUN MRAYUN</h3></div>';
echo '<div class="card-body text-center" >';
$mrayunlaki = mysqli_num_rows(data("1","0","1"))+mysqli_num_rows(data("2","0","1"));
$mrayunwadon = mysqli_num_rows(data("1","0","2"))+mysqli_num_rows(data("2","0","2"));
echo '
Laki - Laki : <b>'.$mrayunlaki.'</b><br>
Perempuan : <b>'.$mrayunwadon.'</b><br>
Jumlah Penduduk<br><h3><a href="?p=data&rw=1&rw2=2" class="text-dark">'.$mrayunwadon+$mrayunlaki.'</a></h3>
';
echo '</div>';
echo '</div>';
echo '</div>';

echo '<div class="col">';
echo '<div class="card text-center" >
<div class="card-header font-weight-bold bg-dark" style="color: #fff"><h3>DUSUN TERMAS</h3></div>
<div class="card-body text-center" >';
$termaslaki = mysqli_num_rows(data("3","0","1"));
$termaswadon = mysqli_num_rows(data("3","0","2"));
echo '
Laki - Laki : <b>'.$termaslaki.'</b><br>
Perempuan : <b>'.$termaswadon.'</b><br>
Jumlah Penduduk<br><h3><a href="./?p=data&rw=3" class="text-dark">'.$termaslaki+$termaswadon.'</a></h3>
';
echo '</div>';
echo '</div>';
echo '</div>';

echo '<div class="col">';
echo '<div class="card text-center" >
<div class="card-header font-weight-bold bg-dark" style="color: #fff"><h3>DUSUN GETAS</h3></div>
<div class="card-body text-center" >';
$getaslaki = mysqli_num_rows(data("4","0","1"))+mysqli_num_rows(data("5","0","1"));
$getaswadon = mysqli_num_rows(data("4","0","2"))+mysqli_num_rows(data("5","0","2"));
echo '
Laki - Laki : <b>'.$getaslaki.'</b><br>
Perempuan : <b>'.$getaswadon.'</b><br>
Jumlah Penduduk<h3><a href="./?p=data&rw=4&rw2=5" class="text-dark">'.$getaslaki+$getaswadon.'</a></h3>
';
echo '</div>';
echo '</div>';
echo '</div>';

echo '</div>';
//// Per Dusun END
$bacarw = $conn->query("select no_rw as rw FROM data_keluarga WHERE no_rw IS NOT NULL GROUP BY rw;");
// Per RW dan RT
while($row = mysqli_fetch_array($bacarw)) {
$rwes = $row['rw'];
$bacart = $conn->query("select no_rt as rt, no_rw as rw FROM data_keluarga WHERE no_rw='$rwes' AND no_rt IS NOT NULL GROUP BY rt
;");
echo '<div class="row row-cols-1 row-cols-sm-2 row-cols-md-6 pl-3 pb-5 my-0">';
echo '<div class="col">
<div class="card text-center" >
              <div class="card-header font-weight-bold '.$warna[array_rand($warna)].'">
<h4>RW 00'.$rwes.'</h4>
              </div>
              <div class="card-body text-center" >
<p>
Laki-Laki <a href="./?p=data&rw='.$rwes.'&jns=1" class="text-danger">'.mysqli_num_rows(data($rwes,"0","1")).'</a>
<br>Prempuan <a href="./?p=data&rw='.$rwes.'&jns=2" class="text-danger">'.mysqli_num_rows(data($rwes,"0","2")).'
</a><br><h3><a href="./?p=data&rw='.$rwes.'" class="text-dark">'.mysqli_num_rows(data($rwes,"0","0")).'</a></h3>
</p>';
echo '              </div>
</div>
</div>
';
// Per RT
while($r = $bacart->fetch_assoc()) :
$rt = $r['rt'];
$rw = $rwes;
$laki = mysqli_num_rows(data($rw,$rt,"1"));
$wadon = mysqli_num_rows(data($rw,$rt,"2"));

if($rt=="4" & $rw == "2"){
$dusun = "Dusun Limberejo ?";
}else{$dusun = "";}
echo '
<div class="col">
            <div class="card text-center" >
              <div class="card-header font-weight-bold" style="background-color:'.randomColor().';color:'.randomColor().'">
RT 00'.$rt.' / RW 00'.$rw.' '.$dusun.'
              </div>
              <div class="card-body text-center" >
<p>
Laki-Laki <a href="./?p=data&rw='.$rw.'&rt='.$rt.'&jns=1" class="text-dark">'.$laki.'</a><br>Prempuan <a href="./?p=data&rw='.$rw.'&rt='.$rt.'&jns=2" class="text-dark">'.$wadon.'</a>
</p>
<h3><a href="./?p=data&rw='.$rw.'&rt='.$rt.'" class="text-dark">'.$laki+$wadon.'</a></h3>
              </div>
</div>
</div>';
endwhile;
// per RT END
echo "</div>";
}
}

function ba4ta() { ///Bawah usia empat tahun
global $no, $conn;
$tahun = Date('Y');
$e = "6";
$empat = $tahun - $e;
$ba4tahun = $conn->query("select * FROM biodata_wni
JOIN data_keluarga ON data_keluarga.no_kk = biodata_wni.no_kk
WHERE flag_status='0' AND YEAR(tgl_lhr) > $empat ORDER BY no_rw, no_rt asc
;");

$jumlahbalita = $ba4tahun->num_rows;

echo '<div class="text-center">Jumlah Usia <?php echo $e -1;?> Tahun Ke Bawah = <?php echo $jumlahbalita;?>
</div>
<table class="table table-sm table-hover">
  <thead>
    <tr>
      <th scope="col" width="5" class="text-center">#</th>
      <th scope="col" width=""  class="text-center">Nama</th>
      <th scope="col" width="5" class="text-center">L/K</th>
      <th scope="col" width="90" class="text-center">Lahir</th>
      <th scope="col" width="190" class="text-center">Usia</th>
      <th scope="col" width="175" class="text-center">Nama Ayah</th>
      <th scope="col" width="200" class="text-center">Nama Ibu</th>
      <th scope="col" width="" class="text-center">Alamat</th>
    </tr>
  </thead>';

while($ro = $ba4tahun->fetch_assoc()) {

$laki = $ro["jenis_klmin"];
if ($laki == "2") {
$laki = "Perempuan";
}else{
$laki = "Laki-Laki";
}

$alamat = $ro["alamat"];
$pattern[0] = '/DUSUN/i';
$pattern[1] = '/Dsn./i';
$alamat = preg_replace($pattern, " ", $alamat);
$alamat = ucwords(strtolower($alamat));
echo 
"<tr><td>".
$no++. "</td><td>" . ucwords(strtolower($ro["nama_lgkp"])). "</td><td>" . $laki."</td><td>" . $ro["tgl_lhr"]. 
"</td><td>" . usia($ro["tgl_lhr"]).
"</td><td>" . ucwords(strtolower($ro["nama_lgkp_ayah"])).
"</td><td>" . ucwords(strtolower($ro["nama_lgkp_ibu"])).
"</td><td>" . $alamat." RT 00".$ro["no_rt"] ." RW 00".$ro["no_rw"].
"</td></tr>";
} //while
echo "</table>";
}///Bawah usia empat tahun

function lansia() { ///Bawah usia empat tahun
global $no, $conn;
$tahun = Date('Y');
$e = "65";
$lan = $tahun - $e;
$lansia = $conn->query("select * FROM biodata_wni JOIN data_keluarga ON data_keluarga.no_kk = biodata_wni.no_kk WHERE flag_status='0' AND YEAR(tgl_lhr) < $lan ORDER BY no_rw, no_rt, tgl_lhr asc ;");

$jumlahlansia = mysqli_num_rows($lansia);

echo '
<div class="text-center">Jumlah Usia <?php echo $e;?> Tahun Ke Atas = <?php echo $jumlahlansia;?>
</div>
<table class="table table-sm table-hover">
  <thead>
    <tr>
      <th scope="col" width="5" class="text-center">#</th>
      <th scope="col" width=""  class="text-center">Nama</th>
      <th scope="col" width="5" class="text-center">L/K</th>
      <th scope="col" width="90" class="text-center">Lahir</th>
      <th scope="col" width="100" class="text-center">Usia</th>
      <th scope="col" width="175" class="text-center">Nama Ayah</th>
      <th scope="col" width="200" class="text-center">Nama Ibu</th>
      <th scope="col" width="" class="text-center">Alamat</th>
    </tr>
  </thead>';

while($ro = $lansia->fetch_assoc()) {

$laki = $ro["jenis_klmin"];
if ($laki == "2") {
$laki = "Perempuan";
}else{
$laki = "Laki-Laki";
}

$alamat = $ro["alamat"];
$pattern[0] = '/DUSUN/i';
$pattern[1] = '/Dsn./i';
$pattern[2] = '/DUSU/i';
$alamat = preg_replace($pattern, " ", $alamat);
$alamat = ucwords(($alamat));


$ibu = $ro["nama_lgkp_ibu"];
if ($ibu != null ){
$ibu = ucwords(strtolower($ibu));
}

$ayah = $ro["nama_lgkp_ayah"];
if ($ayah != null ){
$ayah = ucwords(strtolower($ayah));
}

echo 
"<tr><td>".
$no++. "</td><td>" . ucwords(strtolower($ro["nama_lgkp"])). "</td><td>" . $laki."</td><td>" . $ro["tgl_lhr"]. 
"</td><td>" . usia($ro["tgl_lhr"]).
"</td><td>" . $ayah.
"</td><td>" . $ibu.
"</td><td>" . $alamat." RT 00".$ro["no_rt"] ." RW 00".$ro["no_rw"].
"</td></tr>";
} //while
echo "</table>";
}///RT -RW


function angka(){
global $no, $conn, $jeniskelamin;

echo '<div class="row row-cols-1 row-cols-sm-0 row-cols-md-2 g-4">';

///////////Umur
echo '<div class="col">';
$berdasar = "
SELECT
COUNT(IF(umur < 2,1,NULL)) AS 'hingga 2',
COUNT(IF(umur BETWEEN 2 and 4,1,NULL)) AS '2 - 4',
COUNT(IF(umur BETWEEN 4 and 5,1,NULL)) AS '4 - 5',
COUNT(IF(umur BETWEEN 5 and 12,1,NULL)) AS '4 - 12',
COUNT(IF(umur BETWEEN 12 and 18,1,NULL)) AS '12 - 18',
COUNT(IF(umur BETWEEN 18 and 64,1,NULL)) AS '18 - 64',
COUNT(IF(umur >= 65,1,NULL)) AS '65 ke-atas', count(*) as jujum
FROM (select nik, tgl_lhr, TIMESTAMPDIFF(YEAR, tgl_lhr,
CURDATE()) AS umur FROM biodata_wni WHERE flag_status='0') as dummy_table
";

$re = mysqli_fetch_array($conn->query($berdasar));

echo '<table class="table table-sm table-hover">
  <thead class="bg-warning">
    <tr>
      <th scope="col" width="5" class="text-center">#</th>
      <th scope="col" width="200"  class="text-center">Rentang Usia (tahun)</th>
      <th scope="col" width="" class="text-center">Jumlah Jiwa</th>
    </tr>
  </thead>';
$nos = "1";
foreach($re as $key => $value){
if($no % 2 == 0){
if ($key == 'ren')
{
echo '<tr class="table-dark">';
echo "<td colspan=\"2\" class=\"text-end\">Total
</td><td class=\"text-center\"><b>" . $re['ren'].
"</b></td>";
echo '</tr>';
}else{
echo 
"<tr><td>". $nos++.
".</td><td class=\"text-center\">" . $key.
"</td><td class=\"text-center\">" . $value.
"</td></tr>";
}}
$no++;
}

echo "</table>";
echo '</div>';

////// Jenis Kelamin
echo '<div class="col">';
echo '<table class="table table-sm table-hover">
  <thead class="bg-primary">
    <tr>
      <th scope="col" width="5" class="text-center">#</th>
      <th scope="col" width="200"  class="text-center">Jenis Kelamin</th>
      <th scope="col" width="" class="text-center">Jumlah Jiwa</th>
    </tr>
  </thead>';

$nop = "1";
foreach($conn->query('SELECT jenis_klmin,COUNT(*) as jum
FROM biodata_wni
WHERE biodata_wni.flag_status="0"
GROUP BY jenis_klmin ORDER BY COUNT(*) desc') as $row) {
echo "<tr>";
echo "<td>" . $nop++ . ".</td>";
echo "<td>" . $jeniskelamin[$row['jenis_klmin']] . "</td>";
echo "<td class=\"text-center\">" . $row['jum'] . "</td>";
echo "</tr>";
}
$jujum = mysqli_fetch_array($conn->query('SELECT COUNT(*) as jum FROM biodata_wni WHERE flag_status="0";'));
echo '<tr class="table-dark">';
echo "<td colspan=\"2\" class=\"text-end\">Total
</td><td class=\"text-center\"><b>" . $jujum['jum'].
"</b></td>";
echo '</tr>';
echo "</table>";
echo '<table class="table table-sm table-hover table-responsive-sm">
  <thead style="background:green">
    <tr>
      <th scope="col" width="5" class="text-center">#</th>
      <th scope="col" width="200"  class="text-center">Agama</th>
      <th scope="col" width="" class="text-center">Jumlah Jiwa</th>
    </tr>
  </thead>';
$nob = "1";  
foreach($conn->query('SELECT descrip, agama,COUNT(*)
FROM biodata_wni
JOIN agama_master ON agama_master.no = biodata_wni.agama
WHERE biodata_wni.flag_status="0"
GROUP BY agama') as $row) {
$agama = strtolower($row['descrip']);

echo "<tr>";
echo "<td>" . $nob++ . "</td>";
echo "<td><a class='text-black' href=./?p=data&a=".$row['agama'].">" . ucwords($agama) . "</a></td>";
echo "<td class=\"text-center\">". $row['COUNT(*)'] . "</td>";
echo "</tr>"; 
}
echo '<tr class="table-dark">';
echo "<td colspan=\"2\" class=\"text-end\">Total
</td><td class=\"text-center\"><b>" . $jujum['jum'].
"</b></td>";
echo '</tr>';
echo "</table>";
echo '</div>';

////////// Berdasar Pekerjaan
echo '<div class="col">';
echo '<table class="table table-sm table-hover">
  <thead class="bg-primary">
    <tr>
      <th scope="col" width="5" class="text-center">#</th>
      <th scope="col" width="200"  class="text-center">Pekerjaan</th>
      <th scope="col" width="" class="text-center">Jumlah Jiwa</th>
    </tr>
  </thead>';
$nop = "1";
foreach($conn->query('SELECT no,descrip, jenis_pkrjn,COUNT(*)
FROM biodata_wni
JOIN pkrjn_master ON pkrjn_master.no = biodata_wni.jenis_pkrjn
WHERE biodata_wni.flag_status="0"
GROUP BY jenis_pkrjn ORDER BY COUNT(*) desc') as $row) {
$kerja = strtolower($row['descrip']);

echo "<tr>";
echo "<td>" . $nop++ . ".</td>";
echo "<td><a class='text-black' href=./?p=data&k=".$row['no'].">" .  ucwords($kerja) . "</a></td>";
echo "<td class=\"text-center\">" . $row['COUNT(*)'] . "</td>";
echo "</tr>"; 
}
echo '<tr class="table-dark">';
echo "<td colspan=\"2\" class=\"text-end\">Total
</td><td class=\"text-center\"><b>" . $jujum['jum'].
"</b></td>";
echo '</tr>';
echo "</table>";
echo '</div>';

////////// Pendidikan
echo '<div class="col">';

echo '<table class="table table-sm table-hover">
  <thead class="bg-danger">
    <tr>
      <th scope="col" width="5" class="text-center">#</th>
      <th scope="col" width="250"  class="text-center">Pendidikan</th>
      <th scope="col" width="" class="text-center">Jumlah Jiwa</th>
    </tr>
  </thead>';
$nod = "1";  
foreach($conn->query('SELECT no,descrip, pddk_akh,COUNT(*)
FROM biodata_wni
JOIN pddkn_master ON pddkn_master.no = biodata_wni.pddk_akh
WHERE biodata_wni.flag_status="0"
GROUP BY pddk_akh') as $row) {
$pendidikan = $row['descrip'];

echo "<tr>";
echo "<td>" . $nod++ . "</td>";
echo "<td><a class='text-black' href=./?p=data&s=".$row['no'].">" .  $pendidikan . "</a></td>";
echo "<td class=\"text-center\">" . $row['COUNT(*)'] . "</td>";
echo "</tr>"; 
}
echo '<tr class="table-dark">';
echo "<td colspan=\"2\" class=\"text-end\">Total
</td><td class=\"text-center\"><b>" . $jujum['jum'].
"</b></td>";
echo '</tr>';
echo "</table>";
////////// Pernikahan
echo '<table class="table table-sm table-hover">
  <thead class="bg-primary">
    <tr>
      <th scope="col" width="5" class="text-center">#</th>
      <th scope="col" width="200"  class="text-center">Status Pernikahan</th>
      <th scope="col" width="" class="text-center">Jumlah Jiwa</th>
    </tr>
  </thead>';
$nop = "1";
foreach($conn->query('SELECT no, descrip, stat_kwn,COUNT(*)
FROM biodata_wni
JOIN kwn_master ON kwn_master.no = biodata_wni.stat_kwn
WHERE biodata_wni.flag_status="0"
GROUP BY stat_kwn ORDER BY COUNT(*) desc') as $row) {
$kawin = strtolower($row['descrip']);

echo "<tr>";
echo "<td>" . $nop++ . ".</td>";
echo "<td><a class='text-black' href=./?p=data&r=".$row['no'].">" . ucwords($kawin) . "</a></td>";
echo "<td class=\"text-center\">" . $row['COUNT(*)'] . "</td>";
echo "</tr>"; 
}
echo '<tr class="table-dark">';
echo "<td colspan=\"2\" class=\"text-end\">Total
</td><td class=\"text-center\"><b>" . $jujum['jum'].
"</b></td>";
echo '</tr>';
echo "</table>";
echo '<table class="table table-sm table-hover">
  <thead class="bg-primary">
    <tr>
      <th scope="col" width="5" class="text-center">#</th>
      <th scope="col" width="200"  class="text-center">Cacat Fisik</th>
      <th scope="col" width="" class="text-center">Jumlah Jiwa</th>
    </tr>
  </thead>';
$nop = "1";
foreach($conn->query('SELECT no, descrip, pnydng_cct,COUNT(*)
FROM biodata_wni
JOIN cct_master ON cct_master.no = biodata_wni.pnydng_cct
WHERE biodata_wni.flag_status="0"
GROUP BY pnydng_cct ORDER BY COUNT(*) desc') as $row) {
$cacat = strtolower($row['descrip']);

echo "<tr>";
echo "<td>" . $nop++ . ".</td>";
echo "<td><a class='text-black' href=./?p=data&c=".$row['no'].">" .  ucwords($cacat) . "</a></td>";
echo "<td class=\"text-center\">" . $row['COUNT(*)'] . "</td>";
echo "</tr>"; 
}
echo '<tr class="table-dark">';
echo "<td colspan=\"2\" class=\"text-end\">Total
</td><td class=\"text-center\"><b>" . $jujum['jum'].
"</b></td>";
echo '</tr>';
echo "</table>";
echo '</div>';

echo '</div>'; //rowwwwwww


} //funct angka

function warga(){
global $jeniskelamin, $ident, $no;
//s = sekolah; a = agama; k = pekerjaan
ob_start(); ///////generate html dengan ob

if (!empty($_GET['rt'])){ $rt = trim($_GET['rt']); $erte = " RT 00".$rt; } if (empty($_GET['rt'])){ $rt = "0"; $erte = ""; }
if (empty($_GET['rw2'])){$erwe2 = ""; $jumlahpddk2 ="0";$rw2="";}
if (!empty($_GET['jns'])){ $jns = $_GET['jns']; $jnis = "Jenis Kelamin ".$jeniskelamin[$jns]; }
if (empty($_GET['jns'])){ $jns = "0"; $jnis = ""; }
if (!empty($_GET['a'])){ $aga = $_GET['a']; $agam = "Agama ".agama($aga); } if (empty($_GET['a'])){ $agam = ""; }
if (!empty($_GET['s'])){ $seklah = $_GET['s']; $sekolah = "Pendidikan : ".sekolah($seklah); } if (empty($_GET['s'])){ $sekolah = ""; }
if (!empty($_GET['r'])){ $rabi = $_GET['r']; $rabis = "Status Pernikahan : ".status($rabi); } if (empty($_GET['r'])){ $rabis = ""; }
if (!empty($_GET['k'])){ $kerj = $_GET['k']; $kerja = "Perkerjaan : ".pekerjaan($kerj); } if (empty($_GET['k'])){ $kerja = ""; }
if (!empty($_GET['c'])){ $caca = $_GET['c']; $cacat = "Penyandang Cacat : ".cacat($caca); } if (empty($_GET['c'])){ $cacat = ""; }
if (!empty($_GET['u'])){ $usia = " Usia Di Bawah ".$_GET['u']." Tahun"; } if (empty($_GET['u'])){ $usia = ""; }

if (empty($_GET['rw']) && empty($_GET['jns']) && empty($_GET['rt'])){
$rw = "0";
$erwe = "";
$jumlahpddk = mysqli_num_rows(data($rw,$rt,$jns));
$data = data($rw,$rt,$jns);
$nadus = "";
}
if (!empty($_GET['rw'])){
$rw = trim($_GET['rw']); $erwe = " RW 00".$rw;
$jumlahpddk = mysqli_num_rows(data($rw,$rt,$jns));
$data = data($rw,$rt,$jns);
}

if (!empty($_GET['rw2'])){
$rw2 = trim($_GET['rw2']); $erwe2 = " RW 00".$rw2;
$jumlahpddk2 = mysqli_num_rows(data($rw2,$rt,$jns));
$data2 = data($rw,$rt,$jns);
}
if (($rw == "1") || ($rw == "2")  || ($rw2 == "1")  || ($rw2 == "2")) {$nadus = "Dusun Mrayun";}
if (($rw == "3") || ($rw2 == "3")) {$nadus = "Dusun Termas";}
if (($rw == "4") || ($rw == "5") || ($rw2 == "4") || ($rw2 == "5")) {$nadus = "Dusun Getas";}

echo '<div class="mx-auto text-center text-dark border border-dark my-2 mb-4 py-1 p-2 border-2" style="width:50%; padding: -15px 0 15px 0;">
<h5><b>Data Warga <br> Desa '.uckata($ident['nama_kel']).' '.$nadus.$erte.$erwe.$erwe2.'</h5>'.$jnis.$agam.$kerja.$sekolah.$rabis.$cacat.$usia.'</b><br>Jumlah Warga '.$jumlahpddk+$jumlahpddk2.' </div>';
echo '<table class="table table-sm table-hover"><tbody>';
foreach($data as $row) :
$nama = $row["nama_lgkp"];
$dsna = array("Dusn ", "DUSUN ", "Dsn ");
$alamat = str_replace($dsna, "", $row['alamat']);
echo 
'<tr>
<td>'.$no++. '.</td>
<td>' . $row['nik']. '</td>
<td><a class="text-dark" href="./?no='.base64_encode($row['no_kk']).'">' . uckata($nama).'</a></td>
<td>'.uckata($row['tmpt_lhr']).', ' .bulan($row['tgl_lhr']).'</td>
<td>' . usia($row['tgl_lhr']).'</td>
<td>' . uckata($alamat).' RT 00' . $row['no_rt']. ' RW 00' . $row['no_rw'].'</td>
</tr>';
endforeach;

if (!empty($_GET['rw2'])){
$rw2 = trim($_GET['rw2']);
$data2 = data($rw2,$rt,$jns);
foreach($data2 as $row) :
$nama = $row["nama_lgkp"];
$dsna = array("Dusn ", "DUSUN ", "Dsn ");
$alamat = $row["alamat"];
$alamat = str_replace($dsna, "", $alamat);
echo 
'<tr>
<td>'.$no++. '.</td>
<td>' . $row['nik']. '</td>
<td><a class="text-dark" href="./?no='.base64_encode($row['no_kk']).'">' . uckata($nama).'</a></td>
<td>'.uckata($row['tmpt_lhr']).', ' .bulan($row['tgl_lhr']).'</td>
<td>' . usia($row['tgl_lhr']).'</td>
<td>' . uckata($alamat).' RT 00' . $row['no_rt']. ' RW 00' . $row['no_rw'].'</td>
</tr>';
endforeach;
}
echo "</tbody></table>";
$html = ob_get_contents();
ob_end_clean();

echo "<form action='print.php' method='post'>";
echo "<input type='hidden' name='nokk' value='$nadus.$erte.$erwe.$erwe2.$jnis.$agam.$kerja'>";
echo '<textarea style="display:none;" name="data">'.$html.'</textarea>';
echo '<button class="btn float-end bi bi-printer w-2 p-2 text-success" type="submit" name="print"></button>';
echo "</form>";

echo $html;
}

function perkk() {
global $conn, $no, $jeniskel;
if (empty($_GET['no'])) {$nokk = '';$html='';}
ob_start(); ///////generate html dengan ob
if (!empty($_GET['no'])) {
$nokk = base64_decode($_GET['no']);
$datakk = "SELECT *,timestampdiff(year, tgl_lhr, curdate()) as umur FROM biodata_wni
JOIN shdk ON shdk.no = biodata_wni.stat_hbkel
WHERE biodata_wni.no_kk LIKE '%$nokk%' ORDER BY biodata_wni.stat_hbkel ASC, biodata_wni.tgl_lhr ASC
;";
$datakk = $conn->query($datakk);
echo '
<div class="mx-auto text-center text-dark border border-dark my-2 py-1 pt-2" style="width:40%"><h5><b>'.$nokk.'</b></h5></div>

<table class="table table-sm table-striped">
<thead>
<tr>
<td width="5" class="text-center">No</td>
<td class="text-center">NIK</td>
<td class="text-center">Nama Lengkap</td>
<td class="text-center">L/P</td>
<td class="text-center">TL</td>
<td class="text-center">Usia</td>
<td class="text-center">Pekerjaan</td>
<td class="text-center">Pendidikan</td>
<td class="text-center">Status</td>
<td class="text-center">Status KK</td>
<td class="text-center">Nama Ayah</td>
<td class="text-center">Nama Ibu</td>
</tr></thead>';
    
echo "<tbody>";
while ($r = mysqli_fetch_array($datakk)):

if (!empty($r['nama_lgkp_ibu'])){
$ibu = $r['nama_lgkp_ibu'];}else{$ibu="";}
if(!empty($r['nama_lgkp_ayah'])){
$ayah = $r['nama_lgkp_ayah'];}else{$ayah="";}
$no_pkrjn = $r['no'];
$descrip = $r['descrip'];
if ($no_pkrjn == "1"){$descrip = 'Kep Kel';}
echo '<tr>
<td>'.$no++.'.</td>
<td> '.$r['nik'].' </td>
<td>'.uckata($r['nama_lgkp']).'  </td>
<td align="center">'.$jeniskel[$r['jenis_klmin']].' </td>
<td> '.date("d/m/Y",strtotime($r['tgl_lhr'])).' </td>
<td align="center">'.$r['umur'].' </td>
<td>'.pekerjaan($r['jenis_pkrjn']).' </td>
<td>'.sekolah($r['pddk_akh']).' </td>
<td>'.status($r['stat_kwn']).' </td>
<td>'.uckata($descrip).' </td>
<td>'.uckata($ayah).' </td>
<td>'.uckata($ibu).' </td>

</tr>';
endwhile;
echo '</tbody></table>
';
$html = ob_get_contents();
ob_end_clean();

echo '<form action="print.php" method="post">';
echo "<input type='hidden' name='nokk' value='$nokk'>";
echo "<input type='hidden' name='data' value='$html'>";
echo '<button class="btn float-end bi bi-printer w-2 p-2 text-success" type="submit" name="print"></button>';
echo '</form>';

}

echo $html;
} //function perkk
?>