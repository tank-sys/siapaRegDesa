<?php
error_reporting(E_ALL); ini_set('display_errors', TRUE); ini_set('display_startup_errors', TRUE);

include("./head.php");
?>
<section class="mx-auto pt-3">

<?php
if(isset($_GET['p'])){
$page = $_GET['p'];
$no = 1;
		switch ($page) {
case 'kk':
include "klas.php";
echo kepalakk();
break;

case 'angka':
include "klas.php";
echo angka();
break;			

case 'dusun':
include "klas.php";
echo dusun();
break;			

case 'chart':
include "chart.php";
echo chart();
break;			

case 'pdf':
include "dopdf.php";
echo pdf();
break;			

case 'balita':
include "klas.php";
echo ba4ta();
break;

case 'lansia':
include "klas.php";
echo lansia();
break;

case 'perangkat':
include "klas.php";
echo perangkat();
break;

case 'data':
include "klas.php";
echo warga();
break;

case 'pkk':
include "klas.php";
echo perkk();
break;			

default:
echo "<center><h3>Halaman tidak di temukan !</h3></center>";
break;
		}
}else{

include "cari.php";

}
?>

</section>

<?php
include("./footer.php");
?>

