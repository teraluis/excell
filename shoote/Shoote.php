<?php
class Shoote {
	public $chemin;
	public $inside;
	public $csv;
	public $montures=array();
	public function __construct($fichier){
		$this->csv = new SplFileObject($fichier);
		$this->csv->setFlags(SplFileObject::READ_CSV);
		$this->csv->setCsvControl(';');
	}

	public function generer($limite){
		$l=0;		
		foreach ($this->csv as $line) {
			if($l<$limite && $line>0){
				$photo_file = 'https://revendeurs.angeleyes-eyewear.com/EspaceRevendeur/pic/'.$line[0].'_1.jpg';
	            if ($this->url_exists($photo_file)==true){
	            	$bol=1;
	            	array_push($this->montures,array($line[0],1,$photo_file));
	            }else {
	            	array_push($this->montures,array($line[0],0,$photo_file));
	            }				
			}
            $l++;			
		}
	}
	public function url_exists($url){
	    $url = get_headers($url);
	    $url0= $url[0];	   
	    if ($url0 == 'HTTP/1.1 404 Not Found') {
	        return false;
	    } else if($url0=='HTTP/1.1 200 OK'){ 
	        return true;
	    } else {
	        return false;
	    }
	}
	public function afficherOutput(){
		return $this->montures;
	}
	public function createfichier($nom_fichier,$delimiteur){
		$chemin = $nom_fichier;
		$fichier_csv = fopen($chemin, 'w+');
		fprintf($fichier_csv, chr(0xEF).chr(0xBB).chr(0xBF));
		fputcsv($fichier_csv, array('itemcode','shote','url'), $delimiteur);
		$montures = $this->afficherOutput();
		foreach($montures as $line){
			fputcsv($fichier_csv, $line , $delimiteur);
		}
		fclose($fichier_csv);
	}	 
}

?>