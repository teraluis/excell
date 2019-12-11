<?php
require_once('Sav.php');
 $sav=file_get_contents('https://revendeurs.angeleyes-eyewear.com/wp-cron.php?export_hash=d4e26a3418a1288a&export_id=139&action=get_data');

$month = date("m");
$day=date("d");
$year=date("Y");
$chemin_ordinateur="in";
$chemin=$chemin_ordinateur."/".$year."/".$month."/".$day."/sav_".$day.$month.$year.".csv";


if(!file_exists($chemin_ordinateur)){
mkdir("01 - In");
}

if(!file_exists($chemin_ordinateur."/".$year)){
mkdir($chemin_ordinateur."/".$year);
}
if(!file_exists($chemin_ordinateur."/".$year."/".$month)){
mkdir($chemin_ordinateur."/".$year."/".$month);
}
if(!file_exists($chemin_ordinateur."/".$year."/".$month."/".$day)){
mkdir($chemin_ordinateur."/".$year."/".$month."/".$day);
}
/*if(!file_exists($chemin)){
unlink($chemin);
}*/


file_put_contents($chemin, $sav);
file_put_contents("sav.csv", $sav);
function forcerTelechargement($chemin) {
	$poids = 20000;
	header('Content-Type: application/octet-stream');
	header('Content-Length: '. $poids);
	header('Content-disposition: attachment; filename='.$chemin );
	header('Pragma: no-cache');
	header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
	header('Expires: 0');
	readfile($chemin);
	exit();
}	
echo "<p>dossiers generes</p>";
//forcerTelechargement($chemin);
?>