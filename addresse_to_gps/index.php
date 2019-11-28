<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
</head>
<body>


<?php
$fichier = 'clientsetrangers.csv';

$csv = new SplFileObject($fichier);
$csv->setFlags(SplFileObject::READ_CSV);
$csv->setCsvControl(';');
$adresse_tab =array();

$i=0;
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

	if($j>=2 && $j<40	){
	
		if(true){
			$cardcode = $ligne[0];
			$nom=$ligne[1];	
			$rue = "";//$ligne[2];
			$postal = $ligne[3];
			$ville = $ligne[4];
			$telephone= $ligne[5];
			$pays = $ligne[8];
			$leString=trim($rue)." ".trim($postal)." ".trim($ville)." ".trim($postal)." ".trim($pays);
			$cordonates = adressToCordenate($leString);
			$la=$cordonates[0];
			$lo=$cordonates[1];
			$adresse_tab [] = array('telephone'=>$cardcode,'addresse' => $leString,'latitude' => $la,'longitude' => $lo);
		}
	}
	$j++;
}

function afficher_tableau($tab){
	$i=0;
	echo "<table border='1'>";
		$head ="<tr>";
		$head.="<td>number</td>";
		$head.="<td>addresse</td>";
		$head.="<td>latitude</td>";
		$head.="<td>longitude</td>";
		$head.="</tr>";
		echo $head;
		foreach ($tab as $ligne) {
			echo "<tr>";
					echo "<td>".$i."</td>";
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
create_fichier("etrangers_generes.csv",$adresse_tab);
?>
</body>
</html>
