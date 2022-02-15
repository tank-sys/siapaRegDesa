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
echo kepalakk();
break;

case 'angka':
echo angka();
break;			

case 'dusun':
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
echo ba4ta();
break;

case 'lansia':
echo lansia();
break;

case 'perangkat':
echo perangkat();
break;

case 'data':
echo warga();
break;

case 'pkk':
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

