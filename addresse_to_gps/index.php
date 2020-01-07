<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
</head>
<body>


<?php
$fichier = 'inhollandaisvinyl.csv';

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
$j=0;

foreach($csv as $ligne){
	//$nblingnes=5;
	if($j>=1 && $j<=$nblingnes){
		$cardcode = $ligne[0];
		$nom=$ligne[1];	
		$rue = $ligne[2];
		$ville = $ligne[3];
		$postal = $ligne[4];
		$pays = $ligne[5];
		$telephone= $ligne[6];
		$telephone="0".$telephone;
		$telephone=tel($telephone);
		$leString=trim($ville)." ".trim($postal)." ".trim($pays);
		$cordonates = adressToCordenate($leString);
		$la=$cordonates[0];
		$lo=$cordonates[1];
		$adresse_tab [] = array(
			'cardcode'=>$cardcode,
			"nom"	=> $nom,
			"rue" => $rue,
			"ville"=>$ville,
			"postal" => $postal,			
			"pays"=>$pays,			
			'telephone'=>$telephone,
			'latitude' => $la,
			'longitude' => $lo,
			'addressecomplette' => $leString,

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
							echo $ligne['rue'];
					echo "</td>";
					echo "<td>";
							echo $ligne['ville'];
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
create_fichier("outhollandaisvf.csv",$adresse_tab);
?>
</body>
</html>
