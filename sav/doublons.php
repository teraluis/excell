<?php

require_once('Sav.php');
$filename ="sav.csv";
$sav = new Sav($filename);
$sav->generate();

$tabgenere= $sav->getLinestab();
$tabsansdoublons= array();
$vartmp=null;
foreach ($tabgenere as $key => $value) {
	$vartmp = $tabgenere[$key]['description'].",".$tabgenere[$key]['customercode'].",".$tabgenere[$key]['itemcode'].",".$tabgenere[$key]['subject'].",".$tabgenere[$key]['upiece'];
	array_push($tabsansdoublons, $vartmp);
}
$tabsansdoublons = array_unique($tabsansdoublons);
//var_dump($tabsansdoublons);
function generertableau($tab){
	$csv=array();
	for($i=0;$i<count($tab);$i++){
		$infos=explode(",", $tab[$i]);
		$csv [] = array(
			"callid" => $i,
			"origin" => "-1",
			"calltype" => "1",
			"description" => $infos[0],
			"customercode" => $infos[1],
			"itemcode" => $infos[2],
			"subject" => $infos[3],
			"upiece" => $infos[4],
			"problemtype" => 3
		);
	}
	return $csv;
}
$tabsansdoublons = generertableau($tabsansdoublons);
createFichier("cleandoublons",$tabsansdoublons);
var_dump($tabsansdoublons);
	function createFichier($nom_fichier,$tab){
		// Paramétrage de l'écriture du futur fichier CSV
		$chemin = $nom_fichier."_".date("dmY").".csv";
		$delimiteur = ';'; // Pour une tabulation, utiliser $delimiteur = "t";

		// Création du fichier csv (le fichier est vide pour le moment)
		// w+ : consulter http://php.net/manual/fr/function.fopen.php
		$fichier_csv = fopen($chemin, 'w+');

		// Si votre fichier a vocation a être importé dans Excel,
		// vous devez impérativement utiliser la ligne ci-dessous pour corriger
		// les problèmes d'affichage des caractères internationaux (les accents par exemple)
		fprintf($fichier_csv, chr(0xEF).chr(0xBB).chr(0xBF));
		$ligne0 = array(
				'callid' => "ServiceCallID",
				'origin' =>"origin",
				'calltype'=>"callType",
				'description'=>"description",
				'customercode'=>"CustomerCode",
				'itemcode'=>"ItemCode",
				'subject'=>"subject",
				'upiece'=>"U_Piece",
				'problemetype'=>"ProblemType"
			);
		fputcsv($fichier_csv, $ligne0, $delimiteur);
		$ligne1 = array(
				'callid' => "callID",
				'origin' =>"origin",
				'calltype'=>"callType",
				'description'=>"description",
				'customercode'=>"CustomerCode",
				'itemcode'=>"ItemCode",
				'subject'=>"subject",
				'upiece'=>"U_Piece",
				'problemetype'=>"ProblemType"
			);		
		fputcsv($fichier_csv, $ligne1, $delimiteur);
		// Boucle foreach sur chaque ligne du tableau
		foreach($tab as $ligne){			
			// chaque ligne en cours de lecture est insérée dans le fichier
			// les valeurs présentes dans chaque ligne seront séparées par $delimiteur
			fputcsv($fichier_csv, $ligne, $delimiteur);
		}
		// fermeture du fichier csv
		fclose($fichier_csv);
		$taillefichier=filesize($chemin);		
	}
//$sav->forcerTelechargement();
?>