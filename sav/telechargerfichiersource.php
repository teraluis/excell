<?php 

$trigger=file_get_contents('https://revendeurs.angeleyes-eyewear.com/wp-cron.php?export_key=XpJtOAVjN2Cf&export_id=139&action=trigger');
 $exec=file_get_contents('https://revendeurs.angeleyes-eyewear.com/wp-cron.php?export_key=XpJtOAVjN2Cf&export_id=139&action=processing');


?>
<?php
require_once('Sav.php');
 $sav=file_get_contents('https://revendeurs.angeleyes-eyewear.com/wp-cron.php?export_hash=5805f1f735f3f80d&export_id=167&action=get_data');
$chemin="sav.csv";
$fichier_csv = fopen($chemin, 'w+');
fwrite($fichier_csv,$sav);
?>