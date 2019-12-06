<?php
abstract class Fichier 
{
	protected $linesTab;
	protected $csv;
	public $nblines;
	protected $today ;
	public $nomfichier;
	protected $taillefichier;  

	function __construct($filename)
	{
		$fichier = $filename;
		$this->csv = new SplFileObject($fichier);
		$this->csv->setFlags(SplFileObject::READ_CSV);
		$this->csv->setCsvControl(';');
		$this->nblines=$this->csv->seek(PHP_INT_MAX);
		$this->nblines=$this->csv->key()-1;
	}
	public function getCabeza(){
		return $this->cabeza;
	}
	public function getNblines(){
		return $this->nblines;
	}
	public function getCsv(){
		return $this->csv;
	}
	public function getDate(){
		 return date("dmY");
	}
	function getTaillefichier(){
		return $this->taillefichier;
	}
	public function getNomfichier(){
		return $this->nomfichier;
	}	
	public function setNomfichier($nomfichier){
		$this->nomfichier=$nomfichier;
	}		
	public function forcerTelechargement()
	  {
	  	$poids = $this->getTaillefichier();
	    header('Content-Type: application/octet-stream');
	    header('Content-Length: '. $poids);
	    header('Content-disposition: attachment; filename='.$this->getNomfichier() );
	    header('Pragma: no-cache');
	    header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
	    header('Expires: 0');
	    readfile($this->getNomfichier());
	    exit();
	  }	
}

?>