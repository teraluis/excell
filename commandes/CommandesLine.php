<?php
require_once('Fichier.php');
class CommandesLine extends Fichier {
	
	protected $nblines2;
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

	public function generateLine(){
		$somme=0;
		$pkey=0;
		foreach ($this->csv as $lines) {
			if(count($lines)>1 && $lines[0]!="id"){
				$id=$lines[0];
				$title=$lines[1];
				$date=$lines[2];
				$customercode=$lines[4];				
				$tmpitemcode = explode('|',$lines[5]);	
				$somme+=count($tmpitemcode);
				$quantity=$lines[6];
				$comments=$id." ".$title;
				$reduction=$lines[7];
				if(count($tmpitemcode)==1){
					$itemcode=$lines[5];
					$this->itemcode[]=$itemcode;
					$this->quantity[]=$quantity;
					$this->customercode[]=$customercode;
					$this->linenum[]=0;	
					$this->comments[]=$comments;	
					$this->docduedate[]=$date;	
					$pkey++;
					$this->parentkey[]=$pkey;
					if(substr($itemcode, 0,2)=="vo" || substr($itemcode, 0,2)=="vs" || substr($itemcode, 0,2)=="ic" || substr($itemcode, 0,2)=="fs" || substr($itemcode, 0,2)=="fo" || substr($itemcode, 0,2)=="mo" || substr($itemcode, 0,2)=="ms" || substr($itemcode, 0,2)=="lo" || substr($itemcode, 0,2)=="ls"){
						$this->discount[]="0";
					}else {
						$this->discount[] =$reduction;
					}					
				}else {
					$itemcode=$tmpitemcode;
					$tmpquantity=explode('|', $quantity);
					$pkey++;
					for ($i=0; $i <count($tmpitemcode) ; $i++) { 
						$this->itemcode[]=$tmpitemcode[$i];
						$this->quantity[]=$tmpquantity[$i];
						$this->customercode[]=$customercode;
						$this->linenum[]=$i;
						$this->comments[]=$comments;
						$this->docduedate[]=$date;
						$this->parentkey[]=$pkey;
						if(substr($tmpitemcode[$i], 0,2)=="vo" || substr($tmpitemcode[$i], 0,2)=="vs" || substr($tmpitemcode[$i], 0,2)=="ic" || substr($tmpitemcode[$i], 0,2)=="fs" || substr($tmpitemcode[$i], 0,2)=="fo" || substr($tmpitemcode[$i], 0,2)=="mo" || substr($tmpitemcode[$i], 0,2)=="ms" || substr($tmpitemcode[$i], 0,2)=="lo" || substr($tmpitemcode[$i], 0,2)=="ls"){
							$this->discount[]="0";
						}else {
							$this->discount[] =$reduction;
						}						
					}
				}
							
			}
		}
		$this->nblines2=$somme;
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
		$discount = $this->getDiscount();
		for ($i=0; $i <$this->getNblines2() ; $i++) { 
			$tmptab[]=array(
				"parentKey" =>	$parentkey[$i],
				"linenum"	=>	$linenum[$i],
				"comments"	=>	$comments[$i],
				"docduedate1" => $docduedate[$i],
				"docduedate2" => $docduedate[$i],
				"cardcode"	  => $cardcode[$i],
				"itemcode"	  => $itemcode[$i],
				"quantity"		=> $quantity[$i],
				"reduction"		=> $discount[$i]
			);
		}
		return $tmptab;
	}	
	function afficherOutput(){

	}
	function getParentKey(){
		return $this->parentkey;
	}
	function getNblines2(){
		return $this->nblines2;
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
	function getDiscount(){
		return $this->discount;
	}
	function createFichier(){
		$nom_fichier="line";
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
				'parentkey' => "Parentkey",
				'linenum' =>"Linenum",
				'comments'=>"comments",
				'docduedate1'=>"docduedate",
				'docduedate2'=>"DocDate",
				'cardcode'=>"CardCode",
				'itemcode'=>"itemcode",
				'quantity'=>"Quantity",
				'discount'=>"DiscountPercent"
			);
		fputcsv($fichier_csv, $ligne0, $delimiteur);
		$ligne1 = array(
				'parentkey' => "Parentkey",
				'linenum' =>"Linenum",
				'comments'=>"Comments",
				'docduedate1'=>"DocdueDate",
				'docduedate2'=>"DocDate",
				'cardcode'=>"CardCode",
				'itemcode'=>"itemcode",
				'quantity'=>"Quantity",
				'discount'=>"DiscPrcnt"
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