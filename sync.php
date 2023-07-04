<?php
    $s1 = "localhost:6969"; 
    $u1= "ta"; 
    $p1 = "tank"; 
    $db1 = "smard"; 
     
    $s2 = "localhost:3306"; 
    $u2= "root"; 
    $p2 = ""; 
    $db2 = "penduduk"; 

    // Create connection 
    $conn1 = new mysqli($s1, $u1, $p1, $db1); 
    $conn2 = new mysqli($s2, $u2, $p2, $db2); 
$result = $conn1->query("SHOW TABLES");
$hasil2 = $conn2->query("SHOW TABLES");
    
    // Check connection 
    if ($conn1->connect_error) { die("Connection failed: " . $conn1->connect_error);}  
    if ($conn2->connect_error) { die("Connection failed: " . $conn2->connect_error);}
    
if(isset($_GET['p'])){
$page = $_GET['p'];

switch ($page) {
case 'b': echo banding(); break;			
case 'data': echo warga(); break;
default: echo "<center><h3>Halaman tidak di temukan !</h3></center>";break;
	}
}else{
echo "<center><h3>Halaman tidak di temukan !</h3></center>";
}	

function banding(){
global $conn1,$conn2,$s1,$db1,$result,$s2,$db2,$hasil2;

echo "<table><pr><td>";
echo $s1. " - " .$db1. " - " .$result->num_rows;
echo "<hr>";
foreach ($result->fetch_all() as $tabs) {
$row = $conn1->query("SELECT * FROM $tabs[0]")->num_rows;
echo $tabs[0]."  ($row)<br>";
}
echo "</td><td>";

echo $s2. " - " .$db2. " - " .$result->num_rows;
echo "<hr>";
foreach ($hasil2->fetch_all() as $tabs) {
$row2 = $conn2->query("SELECT * FROM $tabs[0]")->num_rows;

echo $tabs[0]."  ($row2)<br>";
}

echo "</td><td valign=top>";
echo $result->num_rows - $hasil2->num_rows;
echo "<hr>";
echo "</td></pr>";
}

?>