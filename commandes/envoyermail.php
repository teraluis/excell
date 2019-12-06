<?php

require_once('CommandesTete.php');
$filename ="commandes.csv";
$commandes = new CommandesTete($filename);
$commandes->generateLine();
$retour=$commandes->envoiMail("adv@angeleyes-eyewear.com");
//$retour=$commandes->envoiMail("luismanresaramirez@gmail.com");
if($retour==true){
	echo "<h1>Votrez Mail est bien parti</h1>";
}else {
	echo "<h1>Votrez Mail a rencontre un probleme et n'a pas pu partir :=(</h1>";
}


?>
<?php header("refresh:5;url=http://localhost/excell/commandes/");?>