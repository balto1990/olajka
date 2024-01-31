<?php

class Ujhir_Controller
{
    public $baseName = 'ujhir';
    public function main(array $vars)
    {
        $adminModel = new Ujhir_Model;
        $adminModel->ujhir();
        $view = new View_Loader($this->baseName . "_main");
    }
}

?>