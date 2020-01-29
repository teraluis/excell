<!DOCTYPE html>
<html>
<head>
	<title>recherchev</title>
	<meta charset="utf-8">
</head>
<body>
<?php
/**
 * l'objectif est de realiser l equivalent du recherchv sur excell
 */
class Recherchev 
{
	protected $csv1;
	protected $csv2;
	protected $nblines1;
	protected $nblines2;
	protected $cardcodes1 = array();
	protected $cardcodes2 = array();
	protected $inactifs = array();
	protected $nbinactifs ;
	function __construct($filename,$filename2)
	{
		$this->initfile($filename,1);
		$this->initfile($filename2,2);
	}
	public function initfile($filename,$numero) {
		$fichier = $filename;
		$csv ="csv".$numero;
		$nblines="nblines".$numero;
		$this->$csv = new SplFileObject($fichier);
		$this->$csv->setFlags(SplFileObject::READ_CSV);
		$this->$csv->setCsvControl(';');
		$this->$nblines=$this->$csv->seek(PHP_INT_MAX);
		$this->$nblines=$this->$csv->key();	
		$cardcodes = "cardcodes".$numero;
		foreach($this->$csv as $ligne){
			if( isset($ligne[1]) && $ligne[1]!="Code du partenaire" && !$this->$csv->eof() ){
				$array=array( trim($ligne[1]), trim($ligne[0]),trim($ligne[2]),trim($ligne[3]),trim($ligne[4]),$ligne[5],$ligne[8],$ligne[6],$ligne[7] );
				$this->$cardcodes[strtoupper(trim($ligne[1]))]=$array;
			}
			
		}		
	}
	public function afficher($numero){
		$cardcodes = "cardcodes".$numero;
		var_dump($this->$cardcodes);
	}
	public function afficherInactifs(){
		$tabhtml="<table border='1'>";

		foreach($this->inactifs as $key => $ina){
			$tabhtml.="<tr>";
			$tabhtml.="<td>".$key."</td>";
			$tabhtml.="<td>".$ina[1]."</td>";
			$tabhtml.="<td>".$ina[2]."</td>";
			$tabhtml.="<td>".$ina[3]."</td>";
			$tabhtml.="<td>".$ina[4]."</td>";
			$tabhtml.="<td>".$ina[6]."</td>";
			$tabhtml.="<td>".$ina[5]."</td>";			
			$tabhtml.="<td>".$ina[7]."</td>";
			$tabhtml.="<td>".$ina[8]."</td>";
			$tabhtml.="<tr>";
		}
		$tabhtml.="</table>";
		return $tabhtml;
	}	
	public function compare(){
		$compteur=0;
		foreach($this->cardcodes1 as $key => $card){
			if(!array_key_exists(trim($key), $this->cardcodes2)){
				$this->inactifs[trim($key)] = $card;
				$compteur++;
			}
		}
		$this->nbinactifs=$compteur;
	}
	public function createfichier(){
		$chemin = "ajouter_".date("dmY").".csv";
		$delimiteur = ';'; // Pour une tabulation, utiliser $delimiteur = "t";
		$fichier_csv = fopen($chemin, 'w+');
		foreach($this->inactifs as $ligne){			
			// chaque ligne en cours de lecture est insérée dans le fichier
			// les valeurs présentes dans chaque ligne seront séparées par $delimiteur
			fputcsv($fichier_csv, $ligne, $delimiteur);
		}
		// fermeture du fichier csv
		fclose($fichier_csv);
		return filesize($chemin);				
	}
	public function getNbinactifs(){
		return $this->nbinactifs;
	}
}
$recherchev = new Recherchev("rev_sapfr.csv","rev_site.csv");
$recherchev->compare();

var_dump($recherchev->getNbinactifs());
echo $recherchev->afficherInactifs();
//$recherchev->createfichier();
?>
</body>
</html>