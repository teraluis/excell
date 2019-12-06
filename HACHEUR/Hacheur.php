<?php 
require_once('Fichier.php');
class Hacheur extends Fichier {
	public $tabfichiers=array();
	public function afficher() {
		foreach ($this->csv as $lines) {
			if(count($lines)>1){
				var_dump($lines);
			}
		}
	}
	public function getTeteFichier(){
		$this->csv->rewind();
		//$this->csv->next();
		return $this->csv->current();
	}

	public function generateArrays($decoupe){
		$i=0;
		$tmparray=array();

		foreach ($this->csv as $lines) {
			if(count($lines)>1 && $i<$decoupe){
				$tmparray[]=$lines;
				$i++;
			}else{
				$this->tabfichiers[]=$tmparray;	
				$tmparray=array();
				$tmparray[]=$lines;
				$i=0;
			}			
		}
		return $this->tabfichiers;		
	}
	function createFichier($nom_fichier,$numerofichier){
		// Paramétrage de l'écriture du futur fichier CSV
		$chemin = $nom_fichier."_".$this->getDate().".csv";
		$this->setNomfichier($chemin);
		$delimiteur = ';'; // Pour une tabulation, utiliser $delimiteur = "t";
		// Création du fichier csv (le fichier est vide pour le moment)
		// w+ : consulter http://php.net/manual/fr/function.fopen.php
		$fichier_csv = fopen($chemin, 'x+');
		// Si votre fichier a vocation a être importé dans Excel,
		// vous devez impérativement utiliser la ligne ci-dessous pour corriger
		// les problèmes d'affichage des caractères internationaux (les accents par exemple)
		if($numerofichier!=0){
			fprintf($fichier_csv, chr(0xEF).chr(0xBB).chr(0xBF));
			$ligne0 = $this->getTeteFichier();
			fputcsv($fichier_csv, $ligne0, $delimiteur);			
		}
		$lignestmp=$this->tabfichiers[$numerofichier];
		// Boucle foreach sur chaque ligne du tableau
		foreach($lignestmp as $ligne){			
			// chaque ligne en cours de lecture est insérée dans le fichier
			// les valeurs présentes dans chaque ligne seront séparées par $delimiteur
			fputcsv($fichier_csv, $ligne, $delimiteur);
		}
		// fermeture du fichier csv
		fclose($fichier_csv);
		$this->taillefichier=filesize($chemin);		
	}
	public function generateFichiers($maxlignes){
		$tete=$this->getTeteFichier();
		$fichier_total=$this->generateArrays($maxlignes);
		$numerofichier=0;
		$i=0;
		foreach ($fichier_total as $fichier) {
			$nom_fichier="Fichier".($i+1);
			$this->createFichier($nom_fichier,$numerofichier);
			$numerofichier++;
			$i++;
		}
	}	
}



