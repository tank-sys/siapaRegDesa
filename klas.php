<?php
function kepalakk() { ///kepala keluarga
global $bacakk, $no;
?>
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
<?php

while($row = $bacakk->fetch_assoc()) {
$nama = strtolower($row["nama_lgkp"]);
echo 
"<tr><td>".
$no++. ".</td><td><a class='text-dark' href='./index.php?p=pkk&nos=".base64_encode($row['no_kk'])."'>" . $row["no_kk"]. "</a></td><td>" . ucwords($nama)."</td><td>00" . $row["no_rt"]. "</td><td>00" . $row["no_rw"].
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
Jumlah Penduduk<br><h3><a href="index.php?p=data&rw=1&rw2=2" class="text-dark">'.$mrayunwadon+$mrayunlaki.'</a></h3>
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
Jumlah Penduduk<br><h3><a href="index.php?p=data&rw=3" class="text-dark">'.$termaslaki+$termaswadon.'</a></h3>
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
Jumlah Penduduk<h3><a href="index.php?p=data&rw=4&rw2=5" class="text-dark">'.$getaslaki+$getaswadon.'</a></h3>
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
Laki-Laki <a href="./index.php?p=data&rw='.$rwes.'&jns=1" class="text-danger">'.mysqli_num_rows(data($rwes,"0","1")).'</a>
<br>Prempuan <a href="./index.php?p=data&rw='.$rwes.'&jns=2" class="text-danger">'.mysqli_num_rows(data($rwes,"0","2")).'
</a><br><h3><a href="./index.php?p=data&rw='.$rwes.'" class="text-dark">'.mysqli_num_rows(data($rwes,"0","0")).'</a></h3>
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
Laki-Laki <a href="./index.php?p=data&rw='.$rw.'&rt='.$rt.'&jns=1" class="text-dark">'.$laki.'</a><br>Prempuan <a href="./index.php?p=data&rw='.$rw.'&rt='.$rt.'&jns=2" class="text-dark">'.$wadon.'</a>
</p>
<h3><a href="./index.php?p=data&rw='.$rw.'&rt='.$rt.'" class="text-dark">'.$laki+$wadon.'</a></h3>
              </div>
</div>
</div>';
endwhile;
// per RT END
echo "</div>";
}
// Per RW dan RT END


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
if ($key == 'jujum')
{
echo '<tr class="table-dark">';
echo "<td colspan=\"2\" class=\"text-end\">Total
</td><td class=\"text-center\"><b>" . $re['jujum'].
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
echo "<td>" . ucwords($agama) . "</td>";
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
echo '<tr class="table-dark">';
echo "<td colspan=\"2\" class=\"text-end\">Total
</td><td class=\"text-center\"><b>" . $jujum['jum'].
"</b></td>";
echo '</tr>';
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
echo '<tr class="table-dark">';
echo "<td colspan=\"2\" class=\"text-end\">Total
</td><td class=\"text-center\"><b>" . $jujum['jum'].
"</b></td>";
echo '</tr>';
echo "</table>";
echo '</div>';

echo '</div>'; //rowwwwwww


} //funct angka

function perangkat() {
global $perangkat, $no;

echo '<table class="table table-sm table-striped table-hover">';

while($row = $perangkat->fetch_assoc()) {
$nama = strtolower($row["nama_lgkp"]);
$nokks = base64_encode($row['no_kk']);
echo 
"<tr>
<td>".$no++. ".</td>
<td>" . $row["nik"]. "</td>
<td><a class='text-dark' href='./index.php?p=pkk&nos=".base64_encode($row['no_kk'])."'>" . uckata($nama)."</a></td>
<td>".uckata($row['tmpt_lhr']).", " .bulan($row['tgl_lhr'])."</td>
<td>" . usia($row['tgl_lhr'])."</td>
<td>" . uckata($row["alamat"])." RT 00" . $row["no_rt"]. " RW 00" . $row["no_rw"]."</td>
</tr>";
}
echo "</table>";

} //penduduk


function warga(){
global $jeniskelamin, $ident, $no;
if (!empty($_GET['rt'])){ $rt = trim($_GET['rt']); $erte = " RT 00".$rt; }
if (empty($_GET['rt'])){ $rt = "0"; $erte = ""; }
if (!empty($_GET['jns'])){ $jns = $_GET['jns']; $jnis = $jeniskelamin[$jns]; }
if (empty($_GET['jns'])){ $jns = "0"; $jnis = ""; }
if (empty($_GET['rw2'])){$erwe2 = ""; $jumlahpddk2 ="0";}
if (empty($_GET['rw']) && empty($_GET['jns']) && empty($_GET['rt'])){
$rw = "0";
$erwe = "";
$jumlahpddk = mysqli_num_rows(data($rw,$rt,$jns));
$data = data($rw,$rt,$jns);
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

echo '<div class="mx-auto text-center text-dark border border-dark my-2 mb-4 py-1 p-2 border-2" style="width:50%">
<h5><b>Data Warga <br> Desa '.uckata($ident['nama_kel']).' '.$nadus.$erte.$erwe.$erwe2.'</h5>Jenis Kelamin '.$jnis.'</b><br>Jumlah Warga '.$jumlahpddk+$jumlahpddk2.' </div>';
echo '<table class="table table-sm table-hover">';
foreach($data as $row) :
$nama = $row["nama_lgkp"];
$dsna = array("Dusn ", "DUSUN ", "Dsn ");
$alamat = $row["alamat"];
$alamat = str_replace($dsna, "", $alamat);
echo 
"<tr>
<td>".$no++. ".</td>
<td>" . $row["nik"]. "</td>
<td><a class='text-dark' href='./index.php?p=pkk&nos=".base64_encode($row['no_kk'])."'>" . uckata($nama)."</a></td>
<td>".uckata($row['tmpt_lhr']).", " .bulan($row['tgl_lhr'])."</td>
<td>" . usia($row['tgl_lhr'])."</td>
<td>" . uckata($alamat)." RT 00" . $row["no_rt"]. " RW 00" . $row["no_rw"]."</td>
</tr>";
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
"<tr>
<td>".$no++. ".</td>
<td>" . $row["nik"]. "</td>
<td><a class='text-dark' href='./index.php?p=pkk&nos=".base64_encode($row['no_kk'])."'>" . uckata($nama)."</a></td>
<td>".uckata($row['tmpt_lhr']).", " .bulan($row['tgl_lhr'])."</td>
<td>" . usia($row['tgl_lhr'])."</td>
<td>" . uckata($alamat)." RT 00" . $row["no_rt"]. " RW 00" . $row["no_rw"]."</td>
</tr>";
endforeach;
}
echo "</table>";

}

function perkk() {
global $conn, $no, $jeniskel, $status;
if (!empty($_GET['nos'])) {
$nokk = base64_decode($_GET['nos']);

$datakk = "SELECT *,timestampdiff(year, tgl_lhr, curdate()) as umur FROM biodata_wni
JOIN shdk ON shdk.no = biodata_wni.stat_hbkel
WHERE biodata_wni.no_kk LIKE '%$nokk%' ORDER BY biodata_wni.stat_hbkel ASC,biodata_wni.tgl_lhr ASC
;";
$datakk = $conn->query($datakk);
echo '
<span class="float-end bi bi-printer w-2 p-2 text-success"></span>

<div class="mx-auto text-center text-dark border border-dark my-2 py-1 pt-2 border-2" style="width:40%"><h5><b>'.$nokk.'</b></h5></div>

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
<td>'.sekolah($r['pddk_akh']).' </td>
<td>'.$status[$r['stat_kwn']].' </td>
<td>'.uckata($descrip).' </td>
<td>'.uckata($ayah).' </td>
<td>'.uckata($ibu).' </td>

</tr>';
endwhile;
echo '</tbody></table>
';
}
} //function perkk
?>