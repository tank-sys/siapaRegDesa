<?php
function usia($tanggal_lahir){
	$birthDate = new DateTime($tanggal_lahir);
	$today = new DateTime("today");
	if ($birthDate > $today) { 
	    exit("0 tahun 0 bulan 0 hari");
	}
	$y = $today->diff($birthDate)->y;
	$m = $today->diff($birthDate)->m;
	$d = $today->diff($birthDate)->d;
	return $y." th ".$m." bl";
}

#echo usia("1980-12-01");


// Seluurh Penduduk
function penduduk() {
global $bacapddk, $no;
?>
<table class="table table-sm table-bordered table-hover dataTable" role="grid">
  <thead>
    <tr>
      <th scope="col" width="40">#</th>
      <th scope="col" width="150">N I K</th>
      <th scope="col">Nama Lengkap</th>
      <th scope="col" width="">DUSUN</th>
      <th scope="col" width="5">RT</th>
      <th scope="col" width="5">RW</th>
    </tr>
  </thead>
<?php

//$bacapddk = $conn->query("select * FROM biodata_wni
//JOIN data_keluarga ON data_keluarga.no_kk = biodata_wni.no_kk
//WHERE flag_status='0'
//;");

while($row = $bacapddk->fetch_assoc()) {
$nama = strtolower($row["nama_lgkp"]);
echo 
"<tr><td>".
$no++. "</td><td>" . $row["nik"]. "</td><td>" . ucwords($nama)."</td><td>" . $row["alamat"]."</td><td>00" . $row["no_rt"]. "</td><td>00" . $row["no_rw"].
"</td></tr>";
}
echo "</table>";
} //penduduk

function kepalakk() { ///kepala keluarga
global $bacakk, $no;
## KK
?>
<table class="table table-sm">
  <thead>
    <tr>
      <th scope="col" width="40" class="text-center">#</th>
      <th scope="col" width="150" class="text-center">No KK</th>
      <th scope="col" align="center">Nama Lengkap</th>
      <th scope="col" width="5" class="text-center">RT</th>
      <th scope="col" width="5" class="text-center">RW</th>
    </tr>
  </thead>
<?php

while($row = $bacakk->fetch_assoc()) {
$nama = strtolower($row["nama_lgkp"]);
echo 
"<tr><td>".
$no++. "</td><td>'" . $row["no_kk"]. "</td><td>" . ucwords($nama)."</td><td>00" . $row["no_rt"]. "</td><td>00" . $row["no_rw"].
"</td></tr>";
}
echo "</table>";
} //Kepala KK

function rtrw($rt,$rw,$jenis) {
global $conn;
$rwrt = $conn->query("select nama_lgkp,nik, no_rt, no_rw,jenis_klmin FROM biodata_wni
JOIN data_keluarga ON data_keluarga.no_kk = biodata_wni.no_kk
WHERE flag_status='0' AND no_rw='$rw' AND no_rt='$rt' AND jenis_klmin='$jenis' ORDER BY no_rw, no_rt asc
;");
return $rwrt;
}

function bgcolor(){return dechex(rand(0,10000000));}
// RT RW Dusun
function dusun() {
global $no, $conn;
function bacadusun($rw,$jns){global $conn;
$bacapddk = mysqli_fetch_array($conn->query("select COUNT(*) FROM biodata_wni JOIN data_keluarga ON data_keluarga.no_kk = biodata_wni.no_kk WHERE flag_status='0' AND data_keluarga.no_rw = $rw AND biodata_wni.jenis_klmin = $jns;"));
return $bacapddk[0];
}

$bacarw = $conn->query("select no_rw as rw FROM data_keluarga WHERE no_rw GROUP BY rw
;");
echo "<div class='card mx-auto text-center mb-3 pb-3 pt-3 bg-primary' style='width:50%'>Daftar Dusun, RT dan RW Desa Termas</div>";

//// Per Dusun
echo '<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 pl-3 pb-5 my-0">';
echo '<div class="col">';
echo '<div class="card text-center" >';
echo '<div class="card-header font-weight-bold bg-dark" style="color: #fff"><h3>DUSUN MRAYUN</h3></div>';
echo '<div class="card-body text-center" >';
$mrayunlaki = bacadusun('1','1')+bacadusun('2','1');
$mrayunwadon = bacadusun('1','2')+bacadusun('2','2');
echo '
Laki - Laki : <b>'.$mrayunlaki.'</b><br>
Perempuan : <b>'.$mrayunwadon.'</b><br>
Jumlah Penduduk<br><h3>'.$mrayunwadon+$mrayunlaki.'</h3>
';
echo '</div>';
echo '</div>';
echo '</div>';

echo '<div class="col">';
echo '<div class="card text-center" >
<div class="card-header font-weight-bold bg-dark" style="color: #fff"><h3>DUSUN TERMAS</h3></div>
<div class="card-body text-center" >';
$termaslaki = bacadusun('3','1');
$termaswadon = bacadusun('3','2');
echo '
Laki - Laki : <b>'.$termaslaki.'</b><br>
Perempuan : <b>'.$termaswadon.'</b><br>
Jumlah Penduduk<br><h3>'.$termaslaki+$termaswadon.'</h3>
';
echo '</div>';
echo '</div>';
echo '</div>';

echo '<div class="col">';
echo '<div class="card text-center" >
<div class="card-header font-weight-bold bg-dark" style="color: #fff"><h3>DUSUN GETAS</h3></div>
<div class="card-body text-center" >';
$getaslaki = bacadusun('4','1')+bacadusun('5','1');
$getaswadon = bacadusun('5','2')+bacadusun('4','2');
echo '
Laki - Laki : <b>'.$getaslaki.'</b><br>
Perempuan : <b>'.$getaswadon.'</b><br>
Jumlah Penduduk<h3>'.$getaslaki+$getaswadon.'</h3>
';
echo '</div>';
echo '</div>';
echo '</div>';

echo '</div>';
//// Per Dusun END

while($row = $bacarw->fetch_assoc()) {
$rwe = $row['rw'];
$bacart = $conn->query("select no_rt as rt FROM data_keluarga WHERE no_rw='$rwe' GROUP BY rt
;");
echo '<div class="row row-cols-1 row-cols-sm-2 row-cols-md-6 pl-3">';
//echo $no++.'. ';
echo '
<div class="col mb-3">
<div class="card text-center" >
              <div class="card-header font-weight-bold bg-dark" style="color: #fff">
<h3>RW 00'.$rwe.'</h3>
              </div>
              <div class="card-body text-center" >
<p>
Jumlah Warga
</p>
<h3> '.mysqli_num_rows($conn->query("select nik FROM biodata_wni JOIN data_keluarga ON data_keluarga.no_kk = biodata_wni.no_kk WHERE flag_status='0' AND no_rw='$rwe'")).' </h3>
              </div>
</div>
</div>
';

while($r = $bacart->fetch_assoc()) {
$rt = $r['rt'];
$rw = $row['rw'];
$wadon = mysqli_num_rows(rtrw($rt,$rw,'1'));
$lekong = mysqli_num_rows(rtrw($rt,$rw,2));

if($rt=="4" & $rw == "2"){
$dusun = "Dusun Limberejo ?";
}else{
$dusun = "";
}
echo '
<div class="col mb-3">
            <div class="card text-center" >
              <div class="card-header font-weight-bold" style="background-color:'.randomColor().';color:'.randomColor().'">
RT 00'.$rt.' / RW 00'.$rw.' '.$dusun.'
              </div>
              <div class="card-body text-center" >
<p>
Laki-Laki '.$lekong.'<br>Prempuan '.$wadon.'
</p>
<h3>'.$lekong+$wadon.'</h3>
              </div>
</div>
</div>';
}

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

$jumlahbalita = mysqli_num_rows($ba4tahun);

?>

<div class="text-center">Jumlah Usia <?php echo $e -1;?> Tahun Ke Bawah = <?php echo $jumlahbalita;?>
</div>
<table class="table table-sm table-hover">
  <thead>
    <tr>
      <th scope="col" width="5" class="text-center">#</th>
      <th scope="col" width=""  class="text-center">Nama</th>
      <th scope="col" width="5" class="text-center">L/K</th>
      <th scope="col" width="90" class="text-center">Lahir</th>
      <th scope="col" width="80" class="text-center">Usia</th>
      <th scope="col" width="175" class="text-center">Nama Ayah</th>
      <th scope="col" width="200" class="text-center">Nama Ibu</th>
      <th scope="col" width="" class="text-center">Alamat</th>
    </tr>
  </thead>
<?php
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
$lansia = $conn->query("select * FROM biodata_wni
JOIN data_keluarga ON data_keluarga.no_kk = biodata_wni.no_kk
WHERE flag_status='0' AND YEAR(tgl_lhr) < $lan ORDER BY no_rw, no_rt, tgl_lhr asc
;");

$jumlahlansia = mysqli_num_rows($lansia);

?>

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
  </thead>
<?php
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
echo '<div class="col">';
$berdasar = "
SELECT
COUNT(IF(umur < 2,1,NULL)) AS 'hingga 2',
COUNT(IF(umur BETWEEN 2 and 4,1,NULL)) AS '2 - 4',
COUNT(IF(umur BETWEEN 4 and 5,1,NULL)) AS '4 - 5',
COUNT(IF(umur BETWEEN 5 and 12,1,NULL)) AS '4 - 12',
COUNT(IF(umur BETWEEN 12 and 18,1,NULL)) AS '12 - 18',
COUNT(IF(umur BETWEEN 18 and 64,1,NULL)) AS '18 - 64',
COUNT(IF(umur >= 65,1,NULL)) AS '65 ke-atas'
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
echo 
"<tr><td>". $nos++.
".</td><td class=\"text-center\">" . $key.
"</td><td class=\"text-center\">" . $value.
"</td></tr>";
}
$no++;
}
echo "</table>";
echo '</div>';
echo '<div class="col">';
echo '<table class="table table-sm table-hover">
  <thead class="bg-primary">
    <tr>
      <th scope="col" width="5" class="text-center">#</th>
      <th scope="col" width="200"  class="text-center">Jenis Kelamin</th>
      <th scope="col" width="" class="text-center">Jumlah Jiwa</th>
    </tr>
  </thead>';
$pekerjaan = $conn->query('SELECT no, descrip FROM pkrjn_master');
while($row = mysqli_fetch_assoc($pekerjaan)){
//    print_r($row);
 }
$nop = "1";
foreach($conn->query('SELECT jenis_klmin,COUNT(*)
FROM biodata_wni
WHERE biodata_wni.flag_status="0"
GROUP BY jenis_klmin ORDER BY COUNT(*) desc') as $row) {

echo "<tr>";
echo "<td>" . $nop++ . ".</td>";
echo "<td>" . $jeniskelamin[$row['jenis_klmin']] . "</td>";
echo "<td class=\"text-center\">" . $row['COUNT(*)'] . "</td>";
echo "</tr>"; 
}
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
echo "<td>" . ucwords($agama) . "</td>";
echo "<td class=\"text-center\">" . $row['COUNT(*)'] . "</td>";
echo "</tr>"; 
}
echo "</table>";
echo '</div>';



echo '<div class="col">';
echo '<table class="table table-sm table-hover">
  <thead class="bg-primary">
    <tr>
      <th scope="col" width="5" class="text-center">#</th>
      <th scope="col" width="200"  class="text-center">Pekerjaan</th>
      <th scope="col" width="" class="text-center">Jumlah Jiwa</th>
    </tr>
  </thead>';
$pekerjaan = $conn->query('SELECT no, descrip FROM pkrjn_master');
while($row = mysqli_fetch_assoc($pekerjaan)){
//    print_r($row);
 }
$nop = "1";
foreach($conn->query('SELECT descrip, jenis_pkrjn,COUNT(*)
FROM biodata_wni
JOIN pkrjn_master ON pkrjn_master.no = biodata_wni.jenis_pkrjn
WHERE biodata_wni.flag_status="0"
GROUP BY jenis_pkrjn ORDER BY COUNT(*) desc') as $row) {
$kerja = strtolower($row['descrip']);

echo "<tr>";
echo "<td>" . $nop++ . ".</td>";
echo "<td>" . ucwords($kerja) . "</td>";
echo "<td class=\"text-center\">" . $row['COUNT(*)'] . "</td>";
echo "</tr>"; 
}
echo "</table>";
echo '</div>';
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
foreach($conn->query('SELECT descrip, pddk_akh,COUNT(*)
FROM biodata_wni
JOIN pddkn_master ON pddkn_master.no = biodata_wni.pddk_akh
WHERE biodata_wni.flag_status="0"
GROUP BY pddk_akh') as $row) {
$pendidikan = $row['descrip'];

echo "<tr>";
echo "<td>" . $nod++ . "</td>";
echo "<td>" . $pendidikan . "</td>";
echo "<td class=\"text-center\">" . $row['COUNT(*)'] . "</td>";
echo "</tr>"; 
}
echo "</table>";

echo '<table class="table table-sm table-hover">
  <thead class="bg-primary">
    <tr>
      <th scope="col" width="5" class="text-center">#</th>
      <th scope="col" width="200"  class="text-center">Status Pernikahan</th>
      <th scope="col" width="" class="text-center">Jumlah Jiwa</th>
    </tr>
  </thead>';
$pekerjaan = $conn->query('SELECT no, descrip FROM pkrjn_master');
while($row = mysqli_fetch_assoc($pekerjaan)){
//    print_r($row);
 }
$nop = "1";
foreach($conn->query('SELECT descrip, stat_kwn,COUNT(*)
FROM biodata_wni
JOIN kwn_master ON kwn_master.no = biodata_wni.stat_kwn
WHERE biodata_wni.flag_status="0"
GROUP BY stat_kwn ORDER BY COUNT(*) desc') as $row) {
$kawin = strtolower($row['descrip']);

echo "<tr>";
echo "<td>" . $nop++ . ".</td>";
echo "<td>" . ucwords($kawin) . "</td>";
echo "<td class=\"text-center\">" . $row['COUNT(*)'] . "</td>";
echo "</tr>"; 
}
echo "</table>";
echo '<table class="table table-sm table-hover">
  <thead class="bg-primary">
    <tr>
      <th scope="col" width="5" class="text-center">#</th>
      <th scope="col" width="200"  class="text-center">Cacat Fisik</th>
      <th scope="col" width="" class="text-center">Jumlah Jiwa</th>
    </tr>
  </thead>';
$pekerjaan = $conn->query('SELECT no, descrip FROM pkrjn_master');
while($row = mysqli_fetch_assoc($pekerjaan)){
//    print_r($row);
 }
$nop = "1";
foreach($conn->query('SELECT descrip, pnydng_cct,COUNT(*)
FROM biodata_wni
JOIN cct_master ON cct_master.no = biodata_wni.pnydng_cct
WHERE biodata_wni.flag_status="0"
GROUP BY pnydng_cct ORDER BY COUNT(*) desc') as $row) {
$kawin = strtolower($row['descrip']);

echo "<tr>";
echo "<td>" . $nop++ . ".</td>";
echo "<td>" . ucwords($kawin) . "</td>";
echo "<td class=\"text-center\">" . $row['COUNT(*)'] . "</td>";
echo "</tr>"; 
}
echo "</table>";
echo '</div>';

echo '</div>'; //rowwwwwww


} //funct angka

function perangkat() {
global $perangkat, $no;
?>
<table class="table table-sm table-striped table-hover">
<?php

while($row = $perangkat->fetch_assoc()) {
$nama = strtolower($row["nama_lgkp"]);
echo 
"<tr>
<td>".$no++. ".</td><td>" . $row["nik"]. "</td>
<td><a class='text-dark' href='./index.php?p=pkk&no=".base64_encode($row['no_kk'])."'>" . uckata($nama)."</a></td>
<td>".uckata($row['tmpt_lhr']).", " .bulan($row['tgl_lhr'])."</td>
<td>" . hitung_umur($row['tgl_lhr'])."</td>
<td>" . uckata($row["alamat"])." RT 00" . $row["no_rt"]. " RW 00" . $row["no_rw"]."</td>
</tr>";
}
echo "</table>";
} //penduduk


function wargarw(){global $conn;
if (!empty($_GET['$rw'])){
$rw = trim($_GET['rw']);
$erwe = "AND biodata_wni.jenis_klmin = $rw";
}
if (empty($_GET['$rw'])){
$erwe = "";
}
if (!empty($_GET['jns'])){
$jns = $_GET['jns'];
$jnis = "AND biodata_wni.jenis_klmin = $jns";
}else{
$jns = "";
$jnis = "";
}
echo $erwe." - ".$jns;
$wargarw = $conn->query("select * FROM biodata_wni
JOIN data_keluarga ON data_keluarga.no_kk = biodata_wni.no_kk
WHERE flag_status='0' $erwe $jnis;");
$jumlahpddk = mysqli_num_rows($wargarw);
echo "<br>";
echo $jumlahpddk;
echo "<br>";
while($row = mysqli_fetch_array($wargarw)) :
echo $row['nama_lgkp']." RT 00".$row['no_rt'];
echo "<br>";
endwhile;
}

function perkk() {
global $conn, $no, $jeniskel, $status;
if (!empty($_GET['no'])) {
$nokk = base64_decode($_GET['no']);

$datakk = "SELECT *,timestampdiff(year, tgl_lhr, curdate()) as umur FROM biodata_wni
JOIN shdk ON shdk.no = biodata_wni.stat_hbkel
WHERE biodata_wni.no_kk LIKE '%$nokk%' ORDER BY biodata_wni.stat_hbkel ASC,biodata_wni.tgl_lhr ASC
;";
$datakk = $conn->query($datakk);

echo '<div class="mx-auto text-center text-dark border border-dark my-3 py-2 pt-3 border-2" style="width:40%"><h5><b>'.$nokk.'</b></h5></div>
<table class="table table-sm table-striped">
<thead>
<tr>
<td width="10" class="text-center">No</td>
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
<td>'.uckata(pekerjaan($r['jenis_pkrjn'])).' </td>
<td>'.pendidikan($r['pddk_akh']).' </td>
<td>'.$status[$r['stat_kwn']].' </td>
<td>'.uckata($descrip).' </td>
<td>'.uckata($ayah).' </td>
<td>'.uckata($ibu).' </td>

</tr>';
endwhile;
echo '</tbody></table>
';
}else{
echo "Data Gak Ada";
}
} //function perkk
?>