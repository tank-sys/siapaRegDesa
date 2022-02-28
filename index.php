<?php
define('web',true);
include("./head.php");
if(isset($_GET['no'])){
perkk();
}elseif(isset($_GET['p'])){
$page = $_GET['p'];

switch ($page) {
case 'pkk': echo perkk(); break;			
case 'data': echo warga(); break;
case 'kk': echo kepalakk(); break;
case 'angka': echo angka(); break;
case 'dusun': echo dusun(); break;			
case 'balita': echo ba4ta(); break;
case 'lansia': echo lansia(); break;
case 'chart': include "chart.php"; break;			
case 'perangkat': echo perangkat(); break;
case 'pdf': include "dopdf.php"; echo pdf(); break;			

default: echo "<center><h3>Halaman tidak di temukan !</h3></center>";
break;
	}
	}else{

$arraykolom = array('nama' =>  'nama_lgkp','nik' =>  'nik','nokk' =>  'no_kk','ibu' =>  'nama_lgkp_ibu');
$arrayk = array('nama' =>  'Nama', 'nik' =>  'No NIK', 'nokk' =>  'No KK', 'ibu' =>  'Nama Ibu');

$pesan = '';
$dev = '';
if (isset($_POST['submit'])) {
$q = trim ($_POST['q']);
if (empty($q)){
$dev .= "bg-danger text-white";
$pesan .= "Kolom pencarian harus diisi.";
echo "<div class='card mx-auto text-center mb-3 pb-3 pt-3 ".$dev."' style='width:50%'>" .$pesan. "</div>";
}else{
$kolom = $_POST['Kolom'];
$kolomCari = $arraykolom[$kolom];
$kolomo = $arrayk[$kolom];
$cari = "SELECT 'nama_lgkp', 'nik', 'no_kk', 'nama_lgkp_ibu' FROM biodata_wni WHERE $kolomCari LIKE '%$q%'
;";
$hasil = $conn->query($cari);
$juml=mysqli_num_rows($hasil);

if ($kolom == 'nik' && !is_numeric($q)){
$dev .= "bg-danger text-white";
$pesan .= $kolomo. " ".$q. " harus berupa angka";
}elseif ($kolom == 'nokk' && !is_numeric($q)){
$dev .= "bg-danger text-white";
$pesan .= $kolomo. " ".$q. " harus berupa angka.";
}elseif ($kolom == 'nama' && is_numeric($q)){
$dev .= "bg-danger text-white";
$pesan .= $kolomo. " ".$q. " harus bukan angka.";
}elseif ($kolom == 'ibu' && is_numeric($q)){
$dev .= "bg-danger text-white";
$pesan .= $kolomo. " ".$q. " harus bukan angka.";
}elseif ($juml == 0){
$dev .= "bg-warning";
$pesan .= $kolomo. " ".$q. " yang Anda cari tidak ditemukan di database kami.";
}else {
$dev .= "bg-success text-white";
$pesan .=  "Ditemukan  ".(float)$juml." ". $kolomo ." yang cocok.";
}

echo "<div class='card mx-auto text-center mb-3 pb-3 pt-3 ".$dev."' style='width:50%'>" .$pesan. "</div>";

$data = "SELECT * FROM biodata_wni
JOIN data_keluarga ON data_keluarga.no_kk = biodata_wni.no_kk
WHERE biodata_wni.$kolomCari LIKE '%$q%'
;";
$data = $conn->query($data);
echo '<div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4">';
while($row = mysqli_fetch_array($data)){
if ($no % 2 == 0){
    $warn = "table-light";
}else {
    $warn = "";
}
echo "<div class='col'>";
echo '<table class="table table-sm table-hover '.$warn.'" style="width:100%"><tr>';
$tl = bulan($row['tgl_lhr']);
$nokk = $row['no_kk'];
$nokkhash = sha1(base64_encode($nokk)).md5($nokk).md5(base64_encode($nokk));

if (!empty($row['nama_lgkp_ibu'])){
$ibu = $row['nama_lgkp_ibu'];}else{$ibu="";}
if(!empty($row['nama_lgkp_ayah'])){
$ayah = $row['nama_lgkp_ayah'];}else{$ayah="";}
echo "<td width='60'>NIK </td><td>:</td><td><a data-bs-toggle='modal' href='#Y2".strtoupper($nokkhash)."' class='text-dark'>". $row['nik'],
"</a></td></tr><tr><td>Nama </td><td>:</td><td>". uckata($row["nama_lgkp"]) ,
"</td></tr><tr><td>Lahir </td><td>:</td><td>". uckata($row['tmpt_lhr']). ", ".$tl.
"</td></tr><tr><td>Usia </td><td>:</td><td class='d-flex'>". usia($row['tgl_lhr']) ,
"</td></tr><tr><td>Status </td><td>:</td><td><span class='float-left'>". status($row['stat_kwn']),
"</span><span class='float-right' style='float:right;'>".$row["flag_status"]."</span></td></tr><tr><td>Alamat </td><td>:</td><td>". uckata($row['alamat']). " 00".$row['no_rt']. " / 00" .$row['no_rw'],
"</td></tr>";
if ($kolom == "ibu"){
echo "<tr><td>Ibu</td><td>:</td><td>". uckata($row["nama_lgkp_ibu"]),
"</td>"
   ;
}
if ($kolom == "nokk"){
echo "<tr><td>No KK</td><td>:</td><td>". $row["no_kk"],
"</td>"
   ;
}
echo "</tr></table>";
echo "</div>";
$no++;

echo '

<div class="modal fade  bd-example-modal-xl" id="Y2'.strtoupper($nokkhash).'" tabindex="-1">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <!-- Modal body -->
      <div class="modal-body"><button type="button" class="btn btn-danger float-end" data-bs-dismiss="modal">Tutup</button>
      <div class="mx-auto text-center font-weight-bold border border-dark my-2 py-1 pt-2 border-2" style="width:50%"><h5><b>'.$nokk.'</h5></b></div>
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
<td class="text-center">Status</td>
<td class="text-center">Status KK</td>
<td class="text-center">Nama Ayah</td>
<td class="text-center">Nama Ibu</td>
</tr></thead>';
$datakk = "SELECT *,timestampdiff(year, tgl_lhr, curdate()) as umur FROM biodata_wni
JOIN shdk ON shdk.no = biodata_wni.stat_hbkel
WHERE biodata_wni.no_kk LIKE '%$nokk%' ORDER BY umur DESC, biodata_wni.stat_hbkel ASC
;";
$datakk = $conn->query($datakk);
    
$nos = 1;
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
<td>'.$nos++.'</td>
<td> '.$r['nik'].' </td>
<td>'.uckata($r['nama_lgkp']).'  </td>
<td align="center">'.$jeniskel[$r['jenis_klmin']].' </td>
<td> '.date("d/m/Y",strtotime($r['tgl_lhr'])).' </td>
<td align="center">'.$r['umur'].' </td>
<td>'.pekerjaan($r['jenis_pkrjn']).' </td>
<td>'.status($r['stat_kwn']).' </td>
<td>'.uckata($descrip).' </td>
<td>'.uckata($ayah).' </td>
<td>'.uckata($ibu).' </td>

</tr>';
endwhile;
echo '</tbody></table>
      </div>

    </div>
  </div>
</div>';

}
echo '</div>';
}
}
else{
echo '
<div class="mx-auto text-center mb-3 pb-3 pt-3" style="width:50%">
<form action="./index.php" method="post"  class="d-flex">
              <select class="" name="Kolom" required="" style="width:80px;">
                <option value="nama">Nama</option>
                <option value="nik">NIK</option>
                <option value="nokk">No KK</option>
                <option value="ibu">Nama Ibu</option>
              </select>
          <input class="form-control border border-dark border-1" type="text" name="q" >
          <button class="btn btn-outline-dark btn-light" type="submit" name="submit">Search</button>
</form>
</div>';
}
	}
?>

</section>

<?php
include("./footer.php");
?>

