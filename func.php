<?php
$servername = "localhost:6969";
$username = "ta";
$password = "tank";
$dbname = "smard";
$conn = new MySQLi($servername, $username, $password, $dbname);
if ($conn->connect_error) {die("Connection failed: Error nda..." . $conn->connect_error);} 

$join = "SELECT * FROM data_keluarga JOIN biodata_wni ON biodata_wni.no_kk = data_keluarga.no_kk WHERE biodata_wni.stat_hbkel='1' AND biodata_wni.flag_status='0' ORDER BY data_keluarga.no_rw ASC";

$ident = $conn->query("select nama_kel,nama_kec,nama_kab,last_kons FROM instansi;");
$perangkat = $conn->query("select * FROM biodata_wni JOIN pkrjn_master ON biodata_wni.jenis_pkrjn = pkrjn_master.no JOIN data_keluarga ON data_keluarga.no_kk = biodata_wni.no_kk WHERE biodata_wni.jenis_pkrjn = '85' ORDER BY biodata_wni.tgl_lhr ASC;");
$jumperangkat = mysqli_num_rows($perangkat);

$bacakk  = $conn->query($join);
$jumlahKK = mysqli_num_rows($bacakk);
$ident = mysqli_fetch_array($ident);

$no = 1;
$hari = array (0 =>  'Ahad', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'); //gunakan date('w', strtotime($tanggal);
$status = array (1 =>  'Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati');
$jeniskelamin = array (1 =>  'Laki-Laki', 'Perempuan');
$jeniskel = array (1 =>  'L', 'P');
$dusunku = array (1 =>  'Mrayun', 'Termas', 'Getas');

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
return $jenispekerjaan[1];
}

function sekolah($no) {global $conn;
$pendidikan = mysqli_fetch_row($conn->query("select * FROM pddkn_master WHERE no='$no'"));
return $pendidikan[1];
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

$warna = array ('text-white bg-primary', 'text-white bg-secondary', 'text-white bg-success', 'text-white bg-danger', 'text-white bg-dark', 'text-dark bg-info','text-dark bg-light','text-white bg-dark'); 
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
if ($jenis !== '0'){
$jeniss = "AND biodata_wni.jenis_klmin='$jenis'";
}else {$jeniss = "";}
if ($rt !== '0'){
$rts = "AND data_keluarga.no_rt='$rt'";
}else {$rts = "";}
if ($rw !== '0'){
$rws = "AND data_keluarga.no_rw='$rw'";
}else {$rws = "";}

$rwrt = $conn->query("SELECT *
FROM biodata_wni
JOIN data_keluarga ON data_keluarga.no_kk = biodata_wni.no_kk
WHERE biodata_wni.flag_status='0' $rws $rts $jeniss
ORDER BY data_keluarga.no_rw ASC, data_keluarga.no_rt ASC
;");
//echo '<small>RW '.$rw. ' - RT ' .$rt. ' - Jenis ' .$jenis.'</small><br>';
return $rwrt;
}
?>