<?php
require_once('Sav.php');
 $sav=file_get_contents('https://revendeurs.angeleyes-eyewear.com/wp-cron.php?export_hash=5805f1f735f3f80d&export_id=167&action=get_data');

$month = date("m");
$day=date("d");
$year=date("Y");
$chemin="in/".$year."/".$month."/sav_".$day.$month.$year.".csv";

if(!file_exists("in")){
mkdir("in");
}
if(!file_exists("in/".$year)){
mkdir("in/".$year);
}
if(!file_exists("in/".$year."/".$month)){
mkdir("in/".$year."/".$month);
}
//unlink($chemin);

file_put_contents($chemin, $sav);
function forcerTelechargement($chemin)
{
$poids = 100;
header('Content-Type: application/octet-stream');
header('Content-Length: '. $poids);
header('Content-disposition: attachment; filename='.$chemin );
header('Pragma: no-cache');
header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
header('Expires: 0');
readfile($chemin);
exit();
}	
forcerTelechargement($chemin);
?>