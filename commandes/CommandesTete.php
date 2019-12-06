<?php
require_once('Fichier.php');
class CommandesTete extends Fichier {
	
	protected $itemcode=array();
	protected $customercode=array();
	protected $quantity=array();
	protected $linenum=array();
	protected $comments=array();
	protected $docduedate=array();
	protected $parentkey=array();
	protected $discount=array();
	public function afficher() {
		foreach ($this->csv as $lines) {
			if(count($lines)>1){
				var_dump($lines);
			}
		}
	}
	public function generateTete(){
		foreach ($this->csv as $lines) {
			if(count($lines)>1){
				$id=$lines[0];
				$title=$lines[1];
				$date=$lines[2];
				$customercode=$line[4];
				$itemcode=$line[5];				
				var_dump($lines);
			}
		}
	}
	public function generateLine(){
		$pkey=0;
		foreach ($this->csv as $lines) {
			if(count($lines)>1 && $lines[0]!="id"){
				$id=$lines[0];
				$title=$lines[1];
				$date=$lines[2];
				$customercode=$lines[4];				
				$quantity=$lines[6];
				$comments=$id." ".$title;				
				$itemcode=$lines[5];
				$pkey++;
				$this->parentkey[]=$pkey;
				$this->comments[]=$comments;
				$this->customercode[]=$customercode;					
				$this->docduedate[]=$date=$lines[2];			
			}
		}
		
	}
	function generate() {
		$this->generateLine();
		$tmptab=array();
		$linenum=$this->getLinenum();
		$parentkey=$this->getParentKey();
		$comments= $this->getComments();
		$docduedate=$this->getDocduedate();
		$cardcode=$this->getCustomercode();
		$itemcode=$this->getItemcode();
		$quantity = $this->getQuantity();
		for ($i=0; $i <$this->getNblines() ; $i++) { 
			$tmptab[]=array(
				"parentKey" =>	$parentkey[$i],
				"comments"	=>	$comments[$i],
				"docduedate1" => $docduedate[$i],
				"docduedate2" => $docduedate[$i],
				"cardcode"	  => $cardcode[$i]
			);
		}
		return $tmptab;
	}	
	function afficherOutput(){

	}
	function getParentKey(){
		for ($i=0; $i <$this->getNblines() ; $i++) { 
			$this->parentkey[]=$i+1;
		}
		return $this->parentkey;
	}

	function getItemcode(){
		return $this->itemcode;
	}
	function getCustomercode(){
		return $this->customercode;
	}	
	function getQuantity() {
		return $this->quantity;
	}
	function getLinenum(){
		return $this->linenum;
	}
	function getDocduedate(){
		return $this->docduedate;
	}
	function getComments(){
		return $this->comments;
	}
	function envoiMail($mail){
	$to  = $mail; // notez la virgule

     // Sujet
     $subject = 'Les Commandes sont en cour de chargement sur SAP Business ONE';

     // message
     $message = "<h4>Bonjour l'équipe de l'ADV</h4>";
     $message .= "<div style='background-color:#F1F1F1;padding:15px 10px;'><p>Je vous informe que l'importation des Commandes WEB sont en cours ils seront disponibles d'ici quelques minutes sur SAP !</p> ";
     $message .= "<p>Nombre des commandes web <strong>:".$this->getNblines()."</strong></p></div>";
     $message .="<p>Bien Cordialment</p>";
     // Pour envoyer un mail HTML, l'en-tête Content-type doit être défini
     $headers[] = 'MIME-Version: 1.0';
     $headers[] = 'Content-type: text/html; charset=UTF-8';

     // En-têtes additionnels
     //$headers[] = 'To: MR <mr@example.com>, Mr <mr@example.com>';
     $headers[] = 'From: Informatique <luismanresa@angeleyes-eyewear.com>';
     $headers[] = 'Cc: informatique@angeleyes-eyewear.com';
     $headers[] = 'Bcc: luismanresa@angeleyes-eyewear.com';

     // Envoi
     $envoye=mail($to, $subject, $message, implode("\r\n", $headers));
     return $envoye;
	}	
	function createFichier(){
		$nom_fichier="tete";
		// Paramétrage de l'écriture du futur fichier CSV
		$chemin = $nom_fichier."_".$this->getDate().".csv";
		$this->setNomfichier($chemin);
		$delimiteur = ';'; // Pour une tabulation, utiliser $delimiteur = "t";

		// Création du fichier csv (le fichier est vide pour le moment)
		// w+ : consulter http://php.net/manual/fr/function.fopen.php
		$fichier_csv = fopen($chemin, 'w+');

		// Si votre fichier a vocation a être importé dans Excel,
		// vous devez impérativement utiliser la ligne ci-dessous pour corriger
		// les problèmes d'affichage des caractères internationaux (les accents par exemple)
		fprintf($fichier_csv, chr(0xEF).chr(0xBB).chr(0xBF));
		$ligne0 = array(
				'parentkey' => "ParentKey",
				'comments'=>"Comments",
				'docduedate1'=>"DocDuedate",
				'docduedate2'=>"DocDate",
				'cardcode'=>"CardCode"
			);
		fputcsv($fichier_csv, $ligne0, $delimiteur);
		$ligne1 = array(
				'parentkey' => "ParentKey",
				'comments'=>"Comments",
				'docduedate1'=>"DocDuedate",
				'docduedate2'=>"DocDate",
				'cardcode'=>"CardCode"
			);		
		fputcsv($fichier_csv, $ligne1, $delimiteur);
		$lignestmp=$this->generate();
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
}


?>