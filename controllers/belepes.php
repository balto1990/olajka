<?php

class Belepes_Controller //létrehoztuk a belépés kontroller osztályát
{
	public $baseName = 'belepes';  //meghatározni, hogy melyik oldalon vagyunk
	public function main(array $vars) // a router által továbbított paramétereket kapja
	{
		$testModel = new Test_Model; //az osztályhoz tartozó modell
			if(isset($vars['data']))
			{
				$retdata = $testModel->get_data($vars['data']); //modellből lekérdezzük a kért adatot		
				$view = new View_Loader($this->baseName."_main"); //betöltjük a nézetet
				$view->assign('title', $retdata['title']); //átadjuk a lekérdezett adatokat a nézetnek
				$view->assign('content', $retdata['content']);
			}
		else
			{
				echo "No data to show";
			}	
	}
}
?>