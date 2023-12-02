<?php

class Arfolyam_Controller
{
	public $baseName = 'arfolyam';  //meghatározzuk, hogy melyik oldalon vagyunk
	public function main(array $vars) 
	{
		$view = new View_Loader($this->baseName."_main");
	}
}

?>