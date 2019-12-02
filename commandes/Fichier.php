<?php
/**
 * 
 */
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
	public function envoiMail($mail,$copy,$message){
	$to  = $mail; // notez la virgule

     // Sujet
     $subject = 'Les commandes sont sur SAP Business ONE';

     // message
     $message = "<h1>Bonjour l'équipe de l'ADV</h1>";
     $message .= "<p>".$message."</p>";
     $message .= "<p>Nombre  :".$this->getNblines()."</p>";
     // Pour envoyer un mail HTML, l'en-tête Content-type doit être défini
     $headers[] = 'MIME-Version: 1.0';
     $headers[] = 'Content-type: text/html; charset=UTF-8';

     // En-têtes additionnels
     //$headers[] = 'To: MR <mr@example.com>, Mr <mr@example.com>';
     $headers[] = 'From: Informatique <luismanresa@angeleyes-eyewear.com>';
     $headers[] = 'Cc:'.$copy;
     //$headers[] = 'Bcc: vinylfactory@vinylfactory.com';

     // Envoi
     $envoye=mail($to, $subject, $message, implode("\r\n", $headers));
     return $envoye;
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