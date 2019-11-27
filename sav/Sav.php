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
	function uPiece(){
		foreach($this->csv as $ligne){
			if($ligne[0]!="" && $ligne[0]!="id"){
				if(($ligne[7]!='' XOR ($ligne[8]!="" && $ligne[9]!="" ) )  ) {
					$this->upiece[]='PB';
					$this->subject[]=$ligne[6];
					$this->itemcode[] = $ligne[5];
				}else if($ligne[8]!=""){
					$this->upiece[]='BG';
					$this->subject[]=trim($ligne[6]." BG*".intval($ligne[8]));
					$this->itemcode[] = $ligne[5];
				}else if ($ligne[9]!="") {
					$this->upiece[]='BD';
					$this->subject[]=trim($ligne[6]." BD*".intval($ligne[9]));
				}else if ($ligne[10]!="") {
					$this->upiece[]='VO';
					$this->subject[]=trim($ligne[6]." VO*".intval($ligne[10]));
					$this->itemcode[] = $ligne[5];
				}else if ($ligne[11]!="") {
					$this->upiece[]='VS';
					$this->subject[]=trim($ligne[6]." VS*".intval($ligne[11]));
					$this->itemcode[] = $ligne[5];
				}else if ($ligne[12]!="") {
					$this->upiece[]='FACE';
					$this->subject[]=trim($ligne[6]." FACE*".intval($ligne[12]));
					$this->itemcode[] = $ligne[5];
				}else if ($ligne[13]!='' OR $ligne[14]=="" OR $ligne[15]!="" OR $ligne[18]!="") {
					$this->upiece[]='VISERIE';
					$this->subject[]=$ligne[6];
					$this->itemcode[] = $ligne[5];
				}else if ($ligne[16]!='' XOR ($ligne[19]!='' && $ligne[20]!='')) {
					$this->upiece[]='MANCHON';
					$this->subject[]=$ligne[16];
					$this->subject[]=trim($ligne[6]." MANCHON*".intval($ligne[16]));
					$this->itemcode[] = $ligne[5];
				}else if ($ligne[18]!="") {
					$this->upiece[]='PLAQUETTES';
					$this->subject[]=trim($ligne[6]." PLAQUETTES*".intval($ligne[18]));
					$this->itemcode[] = $ligne[5];
				}else if ($ligne[21]!="") {
					$this->upiece[]='MANCHOND';
					$this->subject[]=trim($ligne[6]." MANCHON*".intval($ligne[21]));
					$this->itemcode[] = $ligne[5];
				}else if ($ligne[22]!="" ) {
					$this->upiece[]='TENON';
					$this->subject[]=trim($ligne[6]." TENON*".intval($ligne[22]));
					$this->itemcode[] = $ligne[5];
				}else if ($ligne[23]!="") {
					$this->upiece[]='CLIP';
					$this->subject[]=trim($ligne[6]." CLIP*".intval($ligne[23]));
					$this->itemcode[] = "vc".subtr($ligne[5],2);
				}else {
					$this->upiece[]='MONTURE';
					$this->subject[]=$ligne[6];
					$this->itemcode[] = $ligne[5];
				}
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
		return $this->nblines;
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
}

?>