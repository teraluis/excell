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
	protected function generate() {

	}	
	protected function afficherOutput(){

	}
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
		$somme=0;

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
				if(count($tmpitemcode)==1){
					$itemcode=$lines[5];
					$this->itemcode[]=$itemcode;
					$this->quantity[]=$quantity;
					$this->customercode[]=$customercode;
					$this->linenum[]=0;	
					$this->comments[]=$comments;	
					$this->docduedate[]=$date;			
				}else {
					$itemcode=$tmpitemcode;
					$tmpquantity=explode('|', $quantity);
					for ($i=0; $i <count($tmpitemcode) ; $i++) { 
						$this->itemcode[]=$tmpitemcode[$i];
						$this->quantity[]=$tmpquantity[$i];
						$this->customercode[]=$customercode;
						$this->linenum[]=$i;
						$this->comments[]=$comments;
						$this->docduedate[]=$date;
					}
				}
							
			}
		}
		$this->nblines2=$somme;
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
}
$commandes = new CommandesLine("commandes.csv");
$commandes->generateLine();
echo "nb lines ".$commandes->getNblines2();
echo "<br>itemcode :<br> ";
var_dump($commandes->getDocduedate());
?>