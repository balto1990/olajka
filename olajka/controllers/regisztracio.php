<?php

class Regisztracio_Controller //létrehoztuk a regisztráció kontroller osztályát
{
	public $baseName = 'regisztracio';  //meghatározni, hogy melyik oldalon vagyunk
	public function main(array $vars) // a router által továbbított paramétereket kapja
	{
		$regisztracioModel = new Regisztracio_Model;  
		//A regisztracio.php vezérlő a view_loader.php modell előtt még meghívja a regisztracio_model.php modellt is, 
		//ami elvégzi a beléptetést.
		
		$retData = $regisztracioModel->get_data($vars);
		if($retData['eredmeny'] == "ERROR")
			$this->baseName = "regisztracio";

		//csak ezután	
		//betöltjük a nézetet
		$view = new View_Loader($this->baseName.'_main');
		//átadjuk a lekérdezett adatokat a nézetnek
		foreach($retData as $name => $value)
			$view->assign($name, $value);
	}
}

?>