<?php

 $sav=file_get_contents('https://revendeurs.angeleyes-eyewear.com/wp-cron.php?export_hash=80d8b15079579e71&export_id=149&action=get_data');

$month = date("m");
$day=date("d");
$year=date("Y");

$chemin="C:/Users/luis.manresa/Documents".$year."/".$month."/".$day."";
echo getcwd() . "<br>"; 
chdir("C:/Users/luis.manresa/Documents");
echo getcwd() . "<br>"; 
if(!file_exists("in")){
	
	if(!mkdir("in",0700)){
		echo "<p>echec lors de la creation du repertoire</p>";
	}
}
if(!file_exists("in/".$year)){
	if(!mkdir("in/".$year)){
		echo "<p>echec lors de la creation du repertoire year</p>";
	}	
}
if(!file_exists("in/".$year."/".$month)){
	if(mkdir("in/".$year."/".$month)){
		echo "<p>echec lors de la creation du repertoire mois</p>";
	}	
}
if(!file_exists("in/".$year."/".$month."/".$day)){
	if(mkdir("in/".$year."/".$month."/".$day)){
		echo "<p>echec lors de la creation du repertoire jour</p>";
	}	
}
/*if(!file_exists($chemin)){
unlink($chemin);
}*/
die();

file_put_contents($chemin, $sav);
file_put_contents("commandes.csv", $sav);
function forcerTelechargement($chemin) {
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