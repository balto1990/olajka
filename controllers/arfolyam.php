<?php

class Arfolyam_Controller //létrehoztuk az árfolyam kontroller osztályát
{
	public $baseName = 'arfolyam';  //meghatározni, hogy melyik oldalon vagyunk
	public function main(array $vars) // a router által továbbított paramétereket kapja
	{
		$arfolyamModel = new Arfolyam_Model; //Az arfolyam.php vezérlő a view_loader.php modell előtt még 
		//meghívja az arfolyam_model.php modellt is, 

		if(isset($vars['data']))
		{
			$retData = $arfolyamModel->get_data($vars['data']); //modellből lekérdezzük a kért adatokat
			$view = new View_Loader($this->baseName."_main"); //betöltjük a nézetet
			$view->assign('title', $retData['title']); //átadjuk a lekérdezett adatokat a nézetnek
		}
		else
		{
			echo "No data to show";
		}
	}
}
?>