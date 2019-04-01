<?php
require_once('connection_bdd/connection_bdd.php');
$bdd = connectionDb();
$sql ="SELECT * FROM bdd_montures.prix_montures";
$pdo = connectionDb();
$stmt = $pdo->query($sql);
$montures = $stmt->fetchAll();
$data =array();
foreach ($montures as $key => $value) {
/*	echo $montures[$key]['cardcode']." ".$montures[$key]['prix']."<br>" ;*/
	$face = substr($montures[$key]['cardcode'], 2);
/*	echo "FA".$face." ".$montures[$key]['face']."<br>";
	echo "BD".$face." ".$montures[$key]['bd']."<br>";
	echo "BG".$face." ".$montures[$key]['bg']."<br>";*/
	$data [] = array(
		"FA".$face=>$montures[$key]['prix'],
		"BD".$face=>$montures[$key]['bd'],
		"BG".$face=>$montures[$key]['bg']
		);
}
function create_fichier($nom_fichier,$tab){
// Paramétrage de l'écriture du futur fichier CSV
$chemin = $nom_fichier;
$delimiteur = ','; // Pour une tabulation, utiliser $delimiteur = "t";

// Création du fichier csv (le fichier est vide pour le moment)
// w+ : consulter http://php.net/manual/fr/function.fopen.php
$fichier_csv = fopen($chemin, 'w+');

// Si votre fichier a vocation a être importé dans Excel,
// vous devez impérativement utiliser la ligne ci-dessous pour corriger
// les problèmes d'affichage des caractères internationaux (les accents par exemple)
fprintf($fichier_csv, chr(0xEF).chr(0xBB).chr(0xBF));

// Boucle foreach sur chaque ligne du tableau
foreach($tab as $key => $value){
	// chaque ligne en cours de lecture est insérée dans le fichier
	// les valeurs présentes dans chaque ligne seront séparées par $delimiteur
	$tab2 =$tab[$key];
	foreach ($tab2 as $key => $value) {
		$ligne = array($key,$value);
		fputcsv($fichier_csv, $ligne, $delimiteur);
	}
	//fputcsv($fichier_csv, $ligne, $delimiteur);
}

// fermeture du fichier csv
fclose($fichier_csv);

}

create_fichier("formatage_prix.csv",$data);
?>