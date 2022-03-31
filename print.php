<?php
define('web',true);
if (isset($_POST['print'])){
$nokk = $_POST["nokk"];
$data = $_POST["data"];
include("./cdn/cssjs.php");
$html = '<html>
<style>
.mx-auto {  margin-right: auto !important;  margin-left: auto !important;
}
.text-center {  text-align: center !important;}
.border {
  border: 2px solid #000000 !important;
  padding: -15px 0px -15px 0px !important;
}
h5, .h5 {
  font-size: 1.25rem;
}
table {
  border-collapse: collapse;
  width: 100%;
  margin: 15px 0px 0px 0px !important;
}
table tr:nth-child(odd){background-color: #f2f2f2;}

table thead tr td {
padding: 8px;
border-bottom: 2px solid #000000;
background-color: #ffffff;
}
table tbody tr td{
padding: 8px 2px;
border-bottom: 1px solid #b6b2b1;
}
a:link {text-decoration: none; color: black;}
</style>
';

echo '<body>';
$html .= $data;
$html .=  '</body></html>';

require_once './vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8',
    'format' => 'A4-L',
    'margin_left' => 3,
    'margin_right' => 3,
    'orientation' => 'L']);
$mpdf->SetDisplayMode('fullpage');    
$mpdf->WriteHTML($html);
$mpdf->Output('KK-'.$nokk.'.pdf', 'I');
}
?>
