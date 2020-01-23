<!DOCTYPE html>
<html>
<head>
	<title>gps</title>
	<meta charset="utf-8">
</head>
<body>

<?php
$fichier = 'newsrev_belgique.csv';

$csv = new SplFileObject($fichier);
$csv->setFlags(SplFileObject::READ_CSV);
$csv->setCsvControl(';');
$adresse_tab =array();
$csv->seek(PHP_INT_MAX);
$nblingnes=$csv->key()-1;
$i=0;
function tel($str) {
    $res = substr($str, 0, 2) .' ';
    $res .= substr($str, 2, 2) .' ';
    $res .= substr($str, 4, 2) .' ';
    $res .= substr($str, 6, 2) .' ';
    $res .= substr($str, 8, 2) .' ';
    return $res;
}
function tel2($str) {
    $res = substr($str, 0, 4) .' ';//0037 79 77 75 090
    $res .= substr($str, 4, 2) .' ';
    $res .= substr($str, 6, 2) .' ';
    $res .= substr($str, 8, 2) .' ';
    $res .= substr($str, 10, 3) .' ';
    return $res;
}
function adressToCordenate($dlocation){
      $address = $dlocation;       
      $prepAddr = str_replace(' ','+',$address);
      $prepAddr = str_replace(array(",","[","]","(",")"),'',$prepAddr);
      $geocode=file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$prepAddr.'+View,+CA&key=AIzaSyCw7IF5dgrLYfevSM2pHzENz0ungw0dt88');
      $output= json_decode($geocode);
	  $latitude = $output->results[0]->geometry->location->lat;
      $longitude = $output->results[0]->geometry->location->lng;  
      return array($latitude,$longitude);
}
function formaterStrings($chaine){
	$good="";
	if ( !empty( $chaine ) ) {
	$tab= array("é","è");
	$good = str_replace($tab,'e',$chaine);
	$good = str_replace(",",' ',$good);
	$good = str_replace("ê",'e',$good);
	$good = str_replace("ê",'e',$good);
	$good = str_replace("'",' ',$good);
	}
	return trim($good);
}
$j=0;

foreach($csv as $ligne){
	//$nblingnes=1;
	if($j>=0 && $j<=$nblingnes){		
		$nom=trim($ligne[0]);	
		$rue = trim($ligne[1]);
		$postal = trim($ligne[3]);
		$ville = trim($ligne[2]);		
		$pays = trim($ligne[4]);
		$paysname="";
		switch ($pays) {
			case 'FR':
				$paysname="FRANCE";
				$cardcode = "C0".$ligne[5];
				break;
			case 'ES':
				$paysname="ESPAGNE";
				$cardcode = "ES".$ligne[5];
				break;	
			case 'PT':
				$paysname="PORTUGAL";
				$cardcode = "PT".$ligne[5];
				break;
			case 'BL':
				$paysname="BELGIQUE";
				$cardcode = "BL".$ligne[5];
				break;										
			default:
				$paysname="FRANCE";
				$cardcode = "C0".$ligne[5];
				break;
		}
		$telephone= $ligne[5];
		$telephone="0".$telephone;
		$telephone=trim($telephone);
		if(strlen($telephone)==9){
			$telephone=tel($telephone);
			$telephone="0032 ".$telephone;
		}else {
			$telephone=tel2($telephone);
		}		
		$leString=trim($ville)." ".trim($postal)." ".trim($paysname);
		$cordonates = adressToCordenate($leString);
		$la=$cordonates[0];
		$lo=$cordonates[1];
		$url="https://www.vinylfactory.fr/revendeurs/localisation-revendeurs/?latitude_user=".$la."&longitude_user=".$lo;
		$adresse_tab [] = array(
			'cardcode'=>$cardcode,
			"nom"	=> $nom,
			"rue" => formaterStrings($rue),
			"ville"=>formaterStrings($ville),
			"postal" => $postal,			
			"pays"=>$pays,			
			'telephone'=>$telephone,
			'latitude' => $la,
			'longitude' => $lo,
			'url' => $url,

		);
	}
	$j++;
}

function afficher_tableau($tab){
	$i=0;
	echo "<table border='1'>";
		$head ="<tr>";
		$head.="<td>cardcode</td>";
		$head.="<td>nom</td>";
		$head.="<td>rue</td>";
		$head.="<td>ville</td>";
		$head.="<td>postal</td>";
		$head.="<td>pays</td>";
		$head.="<td>telephone</td>";
		$head.="<td>latitude</td>";
		$head.="<td>longitude</td>";
		$head.="</tr>";
		echo $head;
		foreach ($tab as $ligne) {
			echo "<tr>";
					echo "<td>".$ligne['cardcode']."</td>";
					echo "<td>";
							echo $ligne['nom'];
					echo "</td>";
					echo "<td>";
							echo formaterStrings($ligne['rue']);
					echo "</td>";
					echo "<td>";
							echo formaterStrings($ligne['ville']);
					echo "</td>";					
					echo "<td>";
							echo $ligne['postal'];
					echo "</td>";
					echo "<td>";
							echo $ligne['pays'];
					echo "</td>";
					echo "<td>";
							echo $ligne['telephone'];
					echo "</td>";																								
					echo "<td>";
							echo $ligne['latitude'];
					echo "</td>";					
					echo "<td>";
							echo $ligne['longitude'];
					echo "</td>";			
			echo "</tr>";
			$i++;
		}
	echo "</table>";
}
function create_fichier($nom_fichier,$tab){
	// Paramétrage de l'écriture du futur fichier CSV
	$chemin = $nom_fichier;
	$delimiteur = ';'; // Pour une tabulation, utiliser $delimiteur = "t";

	// Création du fichier csv (le fichier est vide pour le moment)
	// w+ : consulter http://php.net/manual/fr/function.fopen.php
	$fichier_csv = fopen($chemin, 'w+');

	// Si votre fichier a vocation a être importé dans Excel,
	// vous devez impérativement utiliser la ligne ci-dessous pour corriger
	// les problèmes d'affichage des caractères internationaux (les accents par exemple)
	fprintf($fichier_csv, chr(0xEF).chr(0xBB).chr(0xBF));
	$tete = array(
		"cardcode","nom","rue","ville","postal","pays","telephone","latitude",
		"longitude","url"
	);
	//fputcsv($fichier_csv, $tete, $delimiteur);
	// Boucle foreach sur chaque ligne du tableau
	foreach($tab as $ligne){
		// chaque ligne en cours de lecture est insérée dans le fichier
		// les valeurs présentes dans chaque ligne seront séparées par $delimiteur
		fputcsv($fichier_csv, $ligne, $delimiteur);
	}

	// fermeture du fichier csv
	fclose($fichier_csv);
}
afficher_tableau($adresse_tab);
create_fichier("out_rev_belges.csv",$adresse_tab);
?>
</body>
</html>
