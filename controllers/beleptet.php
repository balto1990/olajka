<?php

class Beleptet_Controller //létrehoztuk a beléptet kontroller osztályát
{
	public $baseName = 'beleptet';  //meghatározni, hogy melyik oldalon vagyunk
	public function main(array $vars) // a router által továbbított paramétereket kapja
	{
		$beleptetModel = new Beleptet_Model;  //A beleptet.php vezérlő a view_loader.php modell előtt még meghívja a beleptet_model.php modellt is, 
		//ami elvégzi a beléptetést.

		$retData = $beleptetModel->get_data($vars); //modellből lekérdezzük a kért adatokat
		if($retData['eredmeny'] == "ERROR")
			$this->baseName = "belepes";
		//ha a retData = ERROR, akkor vissza irányít a belepes oldalra (viewloader_paramétere)
		//csak ezután	
		//betöltjük a nézetet
		$view = new View_Loader($this->baseName.'_main');
		//átadjuk a lekérdezett adatokat a nézetnek
		foreach($retData as $name => $value)
			$view->assign($name, $value);
	}
}

?>