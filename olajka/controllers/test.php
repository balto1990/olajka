<?php

class Test_Controller
{
	public $baseName = 'test';  //meghatározni, hogy melyik oldalon vagyunk
	public function main(array $vars) // a router által továbbított paramétereket kapja
	{
		$testModel = new Test_Model;  //az osztályhoz tartozó modell
		//modellből lekérdezzék a kért adatot
		if(! isset($vars[0])) $vars[0] = "";
		$reqData = $testModel->get_data($vars[0]); 
		//betiltják a nézetet
		$view = new View_Loader($this->baseName.'_main');
		//átadjuk a lekérdezett adatokat a nézetnek
		$view->assign('title', $reqData['title']);
		$view->assign('content', $reqData['content']);
	}
}

?>