<?php
$fichier = 'ocrd_espange.csv';

$csv = new SplFileObject($fichier);
$csv->setFlags(SplFileObject::READ_CSV);
$csv->setCsvControl(';');
$adresse_tab =array();

$i=0;
function adressToCordenate($dlocation){
      $address = $dlocation; 
      
      $prepAddr = str_replace(' ','+',$address);

      $geocode=file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$prepAddr.'+View,+CA&key=AIzaSyCw7IF5dgrLYfevSM2pHzENz0ungw0dt88');

      $output= json_decode($geocode);

	  $latitude = $output->results[0]->geometry->location->lat;
      $longitude = $output->results[0]->geometry->location->lng;  
      return array($latitude,$longitude);
}
$j=0;
/*$tab_affichage="<table border='1'>";*/
foreach($csv as $ligne){
	if($j>=800 && $j<927){
/*		$tab_affichage.= "<tr>";
		$tab_affichage.= "<td>".$j."</td>";
		$tab_affichage.= "<td>".$ligne[0]."</td>";
		$tab_affichage.= "<td>".$ligne[1]."</td>";
		$tab_affichage.= "<td>".$ligne[2]."</td>";
		$tab_affichage.= "<td>".$ligne[3]."</td>";
		$tab_affichage.= "<td>".$ligne[4]."</td>";
		$tab_affichage.= "<td>".$ligne[5]."</td>";
		$tab_affichage.= "<td>".$ligne[6]."</td>";
		$tab_affichage.= "<td>".$ligne[7]."</td>";
		$tab_affichage.= "</tr>";*/
		if(true){
			//$leString=trim($ligne[5])." ".trim($ligne[3]);
			$leString=trim($ligne[3])." ".trim($ligne[5]);
			$leString=trim($ligne[3])." ".trim($ligne[5])." ".trim($ligne[6])." ".trim($ligne[7]);
			$cordonates = adressToCordenate($leString);
			$a=$ligne[1];
			$la=$cordonates[0];
			$lo=$cordonates[1];
			$adresse_tab [] = array('telephone'=>$ligne[0],'addresse' => $a,'latitude' => $la,'longitude' => $lo);
		}
	}
	$j++;
}
/*$tab_affichage.= "</table>";*/
//echo $tab_affichage;
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
							echo $ligne['addresse'];
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
$delimiteur = ','; // Pour une tabulation, utiliser $delimiteur = "t";

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
//afficher_tableau($adresse_tab);
create_fichier("kirk.csv",$adresse_tab);
?>
