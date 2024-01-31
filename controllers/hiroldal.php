<?php

class Hiroldal_Controller
{
	public $baseName = 'hiroldal';
	public function main(array $vars)
	{
		$hiroldalModel = new Hiroldal_Model;
        $retData = $hiroldalModel->get_data($vars);

        $view = new View_Loader($this->baseName . "_main");
      
	}
}

?>