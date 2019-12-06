<?php

require_once('Sav.php');
$filename ="sav.csv";
$sav = new Sav($filename);
$sav->generate();
try {
	$sav->createFichier("sav");	
} catch (Exception $e) {
	echo 'Exception reçue : ',  $e->getMessage(), "\n";
	die();
}
//$sav->forcerTelechargement();
//echo $sav->afficherOutput();
//sleep(60*15);
$retour=$sav->envoiMail("adv@angeleyes-eyewear.com");
//$retour=$sav->envoiMail("luismanresaramirez@gmail.com");
if($retour==true){
	echo "<h1>Votrez Mail est bien parti</h1>";
}else {
	echo "<h1>Votrez Mail a rencontre un probleme et n'a pas pu partir :=(</h1>";
}
/*sleep(50);
header("Location:http://localhost/excell/sav/");*/

?>
<?php header("refresh:5;url=http://localhost/excell/sav/");?>