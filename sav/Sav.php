<?php
/**
 * 
 */
class Sav 
{
	protected $linesTab;
	protected $csv;
	protected $upiece=array();
	function __construct($filename)
	{
		$fichier = $filename;
		$this->csv = new SplFileObject($fichier);
		$this->csv->setFlags(SplFileObject::READ_CSV);
		$this->csv->setCsvControl(';');
	}
	function afficher(){
		$tab="<table border='1' >";
		$tab.="
			<tr>\r\n
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
			<td>24</td>\r\n
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
			if(($ligne[8]=='1' XOR ($ligne[9]=="1" && $ligne[10]=="2" ) )  ) {
				$upiece[]='PB';
			}else if($ligne[9]=="1"){
				$upiece[]='BG';
			}else if ($ligne[10]=="1") {
				$upiece[]='BD';
			}

		}
	}
}
$filename ="sav.csv";
$sav = new Sav($filename);
echo $sav->afficher()
?>