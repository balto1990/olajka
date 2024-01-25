<?php

class Hirek_Controller //létrehoztuk a hírek kontroller osztályát
{
	public $baseName = 'hirek';  //meghatározni, hogy melyik oldalon vagyunk
	public function main(array $vars) // a router által továbbított paramétereket kapja
	{
		$hirekModel = new Hirek_Model;  
        
        $retData = $hirekModel->get_data($vars);
        $getNews=$hirekModel->get_news();

		if($retData['eredmeny'] == "ERROR")
			$this->baseName = "hirek";
			
		//betöltjük a nézetet
		$view = new View_Loader($this->baseName."_main"); 
	}
}

?>