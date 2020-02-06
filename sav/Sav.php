<?php
/**
 * 
 */
class Sav 
{
	protected $linesTab;
	protected $csv;
	protected $upiece=array();
	protected $problemetype=array();
	protected $subject=array();
	protected $itemcode=array();
	protected $description=array();
	protected $calltype=array();
	protected $origin=array();
	protected $servicecallid=array();
	protected $nblines;
	protected $customercode;
	protected $today ;
	protected $nomfichier;
	protected $taillefichier;  
	function __construct($filename)
	{
		$fichier = $filename;
		$this->csv = new SplFileObject($fichier);
		$this->csv->setFlags(SplFileObject::READ_CSV);
		$this->csv->setCsvControl(';');
		$this->nblines=$this->csv->seek(PHP_INT_MAX);
		$this->nblines=$this->csv->key();
	}
	function afficher(){
		$tab="<table border='1' >";
		$tab.="
			<tr>\r\n
			<td>0</td>
			<td>1</td>
			<td>2</td>
			<td>3</td>
			<td>4</td>
			<td>5</td>
			<td>6</td>
			<td>7</td>
			<td>8</td>
			<td>9</td>
			<td>10</td>
			<td>11</td>
			<td>12</td>
			<td>13</td>
			<td>14</td>
			<td>15</td>
			<td>16</td>
			<td>17</td>
			<td>18</td>
			<td>19</td>
			<td>20</td>
			<td>21</td>
			<td>22</td>
			<td>23</td>
			\r\n
		</tr>";//"tr>td*25>{$}"
		foreach($this->csv as $ligne){
			if($ligne[0]!=""){
				$tab.="<tr>";
		        $tab.= "<td>".$ligne[0]."</td>";
		        $tab.= "<td>".$ligne[1]."</td>";
		        $tab.= "<td>".$ligne[2]."</td>";
		        $tab.= "<td>".$ligne[3]."</td>";
		        $tab.= "<td>".$ligne[4]."</td>";
		        $tab.= "<td>".$ligne[5]."</td>";
		        $tab.= "<td>".$ligne[6]."</td>";
		        $tab.= "<td>".$ligne[7]."</td>";
		        $tab.= "<td>".$ligne[8]."</td>";
		        $tab.= "<td>".$ligne[9]."</td>";
		        $tab.= "<td>".$ligne[10]."</td>";
		        $tab.= "<td>".$ligne[11]."</td>";
		        $tab.= "<td>".$ligne[12]."</td>";
		        $tab.= "<td>".$ligne[14]."</td>";
		        $tab.= "<td>".$ligne[15]."</td>";
		        $tab.= "<td>".$ligne[16]."</td>";
		        $tab.= "<td>".$ligne[17]."</td>";
		        $tab.= "<td>".$ligne[18]."</td>";
		        $tab.= "<td>".$ligne[19]."</td>";
		        $tab.= "<td>".$ligne[20]."</td>";
		        $tab.= "<td>".$ligne[21]."</td>";
		        $tab.= "<td>".$ligne[22]."</td>";
		        $tab.= "<td>".$ligne[23]."</td>";
		        $tab.= "<td>".$ligne[24]."</td>";
		        $tab.= "</tr>";
	        }        
		}
		$tab.="</table>";
		return $tab;
	}
	function commentairesenplus($ligne){
		$pairebranches=$ligne[7];
		$branchegauche=$ligne[8];
		$branchedroite=$ligne[9];
		$verrespresentation=$ligne[10];
		$verressolaires=$ligne[11];
		$face=$ligne[12];
		$tenon=$ligne[13];
		$visplaquettes=$ligne[14];
		$visface=$ligne[15];
		$visbranche=$ligne[16];
		$manchon=$ligne[17];
		$plaquettes=$ligne[18];
		$vis=$ligne[19];
		$manchongauche=$ligne[20];
		$manchondroit=$ligne[21];
		$tenongauche=$ligne[22];
		$tenondroit=$ligne[23];
		$clip=$ligne[24];		
		$subject="";
		if( intval($plaquettes)>=1 ){
			$subject.=" PLAQUETTES*".intval($ligne[18]);						
		}
		if( intval($vis)>=1 || intval($visplaquettes)>=1 || intval($visface)>=1 || intval($visbranche)>=1){
			$subject.=" VIS*".intval($vis);						
		}
		if( intval($ligne[24])>1 ){
			$subject.=" CLIP*".intval($ligne[24]);
			$first=substr($ligne[5], 0,1);
		$subject = $first."c".substr ($ligne[5],2);						
		}
		if(intval($verrespresentation)>1 || intval($verressolaires)>1){
			$subject.=" verrespresentation*2";
		} 
		return $subject;		
	}
	function uPiece(){
		foreach($this->csv as $ligne){
			if($ligne[0]!="" && $ligne[0]!="id"){
			$pairebranches=$ligne[7];
			$branchegauche=$ligne[8];
			$branchedroite=$ligne[9];
			$verrespresentation=$ligne[10];
			$verressolaires=$ligne[11];
			$face=$ligne[12];
			$tenon=$ligne[13];
			$visplaquettes=$ligne[14];
			$visface=$ligne[15];
			$visbranche=$ligne[16];
			$manchon=$ligne[17];
			$plaquettes=$ligne[18];
			$vis=$ligne[19];
			$manchongauche=$ligne[20];
			$manchondroit=$ligne[21];
			$tenongauche=$ligne[22];
			$tenondroit=$ligne[23];
			$clip=$ligne[24];
			if( $branchegauche!="" || $manchongauche!="" || $tenongauche!="" ){
				$branchegauche="1";
				$manchongauche=&$branchegauche;
				$tenongauche=&$branchegauche;
			}
			if( $branchedroite!="" || $manchondroit!="" || $tenondroit!="" ){
				$branchedroite="1";
				$manchondroit=&$branchedroite;
				$tenondroit=&$branchedroite;
			}			
				if( $pairebranches!='' XOR ($branchegauche!="" && $branchedroite!="" ) || ($manchondroit!="" && $manchongauche!="" ) || ($tenongauche!="" && $tenondroit!="" ) ) {
					if(strlen($face)!=0){
						$this->upiece[]='Monture';
					}else {
						$this->upiece[]='PB';
					}				 
				}else if( ($branchegauche!="" || $tenongauche!='' || $manchongauche!='') && $face=='' && $branchedroite=='' && $tenondroit=='' && $manchondroit==''){
					$this->upiece[]='BG';					 				
				}else if ( ($branchedroite!="" || $tenondroit!='' || $manchondroit!='') && $face=='' && $branchegauche=='' && $tenongauche=='' && $manchongauche=='') {
					$this->upiece[]='BD';		
				}else if ($verrespresentation!="" && $face=="" && $branchedroite=="" && $branchegauche=="") {
					$this->upiece[]='VERREPES';					
				}else if ($verressolaires!="" && $face=="" && $branchedroite=="" && $branchegauche=="") {
					$this->upiece[]='FACE';			
				}else if ($face!="" && $branchedroite=="" && $branchegauche=="" && $tenongauche=="" && $tenondroit=="" && $manchongauche=="" && $manchondroit=="") {
					$this->upiece[]='FACE';					
				}else if ( $visplaquettes!='' || $visface!='' || $visbranche!='' ||  $vis!="" && $face=="" && $branchedroite=='' && $branchegauche=='' && $manchondroit=='' && $manchongauche=='' && $tenongauche=='' && $tenondroit=='') {
					$this->upiece[]='VIS';				
				}else if ( $plaquettes!='' && $face=='' && $branchedroite=='' && $branchegauche=='' && $manchondroit=='' && $manchongauche=='' && $tenongauche=='' && $tenondroit=='' ) {
					$this->upiece[]='PLAQUETTES';
				}else if ($clip!="" && $face=='' && $branchedroite=='' && $branchegauche=='' && $manchondroit=='' && $manchongauche=='' && $tenongauche=='' && $tenondroit=='' ) {
					$this->upiece[]='CLIP';			
				}else if ( ( $face!='' &&  ($branchegauche!='' || $branchedroite!='' ) ) XOR ( $face!='' && ( $manchondroit!='' || $manchongauche!='') ) 
					XOR ( $face!='' && ($tenondroit!='' || $tenongauche!='') )
			  ) {
					$this->upiece[]='Monture';		
				}else {
					$this->upiece[]='Monture'; 										
				}
				if (!empty($clip)) {
					$first=substr($ligne[5], 0,1);
					$this->itemcode[] = $first."c".substr ($ligne[5],2);				
				}else {
					$this->itemcode[] = $ligne[5];
				}
				$remplacer=array("bonjour","cordialment","impo- ssible de vous joindre par tel","toujours","impossible","bien cordialment","tres",",","!","?");
				$remarque_clean = str_ireplace($remplacer, "", $ligne[6]);
				$subjtmp=trim($remarque_clean." ".$this->commentairesenplus($ligne));
				$this->subject[]=(empty($subjtmp))?"Ref":$subjtmp;				
			}
		}

	}
	function getUpiece(){
		return $this->upiece;
	}
	function getSubject(){
		return $this->subject;
	}
	function getItemcode(){
		return $this->itemcode;
	}	
	function getNblines(){
		return $this->nblines-1;
	}
	function getServiceCallId(){
		for($i=0;$i<$this->getNblines();$i++){
			$this->servicecallid[]=$i+1;
		}
		return $this->servicecallid;
	}
	function getOrigin(){
		for ($i=0; $i < $this->getNblines() ; $i++) { 
			$this->origin[]="-1";
		}
		return $this->origin;
	}
	function getCalltype(){
		for ($i=0; $i < $this->getNblines() ; $i++) { 
			$this->calltype[]="1";
		}
		return $this->calltype;
	}
	function getProblemtype(){
		for ($i=0; $i < $this->getNblines() ; $i++) { 
			$this->problemetype[]="3";
		}
		return $this->problemetype;
	}	
	function getDescription(){
		foreach($this->csv as $ligne){
			if($ligne[0]!="" && $ligne[0]!="id"){
			$this->description[]=$ligne[0]." ".$ligne[1];
			}
		}
		return $this->description;
	}
	function getCustomercode(){
		foreach($this->csv as $ligne){
			if($ligne[0]!="" && $ligne[0]!="id"){
				$this->customercode[]=$ligne[3];
			}
		}
		return $this->customercode;		
	}
	function afficherOutput() {
		$tab="<table border='1'>";
		$tab.="
		<tr>
		<td>ServiceCallID</td>
		<td>Origin</td>
		<td>Description</td>
		<td>CustomerCode</td>
		<td>CustomerCode</td>
		<td>ItemCode</td>
		<td>subject</td>
		<td>U_Piece</td>
		<td>ProblemType</td>
		</tr>";
		$tab.="
		<tr>
		<td>ServiceCallID</td>
		<td>origin</td>
		<td>description</td>
		<td>CustomerCode</td>
		<td>CustomerCode</td>
		<td>ItemCode</td>
		<td>subject</td>
		<td>U_Piece</td>
		<td>ProblemType</td>
		</tr>";
		for($i=0;$i<$this->nblines-1;$i++){
			$tab.="<tr>";
			$tab.="<td>".$this->linesTab[$i]["callid"]."</td>";
			$tab.="<td>".$this->linesTab[$i]["origin"]."</td>";
			$tab.="<td>".$this->linesTab[$i]["calltype"]."</td>";
			$tab.="<td>".$this->linesTab[$i]["description"]."</td>";
			$tab.="<td>".$this->linesTab[$i]["customercode"]."</td>";
			$tab.="<td>".$this->linesTab[$i]["itemcode"]."</td>";
			$tab.="<td>".$this->linesTab[$i]["subject"]."</td>";
			$tab.="<td>".$this->linesTab[$i]["upiece"]."</td>";
			$tab.="<td>".$this->linesTab[$i]["problemetype"]."</td>";
			$tab.="</tr>";
		}
		$tab.="</table>";
		return $tab;		
	}
	function generate(){
		$this->uPiece();
		$callid=$this->getServiceCallId();
		$origin = $this->getOrigin();
		$calltype=$this->getCalltype();
		$description=$this->getDescription();
		$customercode=$this->getCustomercode();
		$itemcode=$this->getItemcode();
		$subject=$this->getSubject();
		$upiece=$this->getUpiece();
		$pbtype=$this->getProblemtype();

		for ($i=0; $i <$this->nblines-1 ; $i++) { 
			$this->linesTab[]=array(
				'callid' => $callid[$i],
				'origin' =>$origin[$i],
				'calltype'=>$calltype[$i],
				'description'=>$description[$i],
				'customercode'=>$customercode[$i],
				'itemcode'=>$itemcode[$i],
				'subject'=>$subject[$i],
				'upiece'=>$upiece[$i],
				'problemetype'=>$pbtype[$i]
			);
		}
		return $this->linesTab;
	}
	function getDate(){
		 return date("dmY");
	}
	function getLinesTab(){
		return $this->linesTab;
	}
	function envoiMail($mail){
	$to  = $mail; // notez la virgule

     // Sujet
     $subject = 'Les SAV  ont été charges sur SAP Business ONE';

     // message
     $message = "<h4>Bonjour l'équipe de l'ADV</h4>";
     $message .= "<div style='background-color:#F1F1F1;padding:15px 10px;'><p>Je vous informe que l'importation des SAV WEB via DTW est  termine  ils sont disponibles sur SAP Business One!</p> ";
     $message .= "<p>Nombre des sav web <strong>:".$this->getNblines()."</strong></p></div>";
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
	function createFichier($nom_fichier){
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
	function getTaillefichier(){
		return $this->taillefichier;
	}
	function getNomfichier(){
		return $this->nomfichier;
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