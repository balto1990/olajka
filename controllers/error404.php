<?php

class Error404_Controller //létrehoztuk az error404 kontroller osztályát
{
	public $baseName = 'error404';  //meghatározni, hogy melyik oldalon vagyunk
	public function main(array $vars) // a router által továbbított paramétereket kapja
	{
		$view = new View_Loader($this->baseName.'_main'); //betöltjük a nézetet
	}
}
?>