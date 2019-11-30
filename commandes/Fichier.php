<?php
/**
 * 
 */
abstract class Fichier 
{
	protected $linesTab;
	protected $csv;
	protected $nblines;
	protected $today ;
	protected $nomfichier;
	protected $taillefichier;  
	abstract protected function generate();
	abstract protected function afficherOutput();
	function __construct($filename)
	{
		$fichier = $filename;
		$this->csv = new SplFileObject($fichier);
		$this->csv->setFlags(SplFileObject::READ_CSV);
		$this->csv->setCsvControl(';');
		$this->nblines=$this->csv->seek(PHP_INT_MAX);
		$this->nblines=$this->csv->key();
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
	function getNomfichier(){
		return $this->nomfichier;
	}	
	public function envoiMail($mail,$copy,$message){
	$to  = $mail; // notez la virgule

     // Sujet
     $subject = 'Les SAV sont sur SAP Business ONE';

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
	public function createFichier($nom_fichier){
		// Paramétrage de l'écriture du futur fichier CSV
		$chemin = $nom_fichier."_".$this->getDate().".csv";
		$this->nomfichier=$chemin;
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
		foreach($this->linesTab as $ligne){			
			// chaque ligne en cours de lecture est insérée dans le fichier
			// les valeurs présentes dans chaque ligne seront séparées par $delimiteur
			fputcsv($fichier_csv, $ligne, $delimiteur);
		}
		// fermeture du fichier csv
		fclose($fichier_csv);
		$this->taillefichier=filesize($chemin);		
	}

	  function forcerTelechargement()
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