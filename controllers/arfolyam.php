<?php
class Arfolyam_Controller
{
    public $baseName = 'arfolyam';
    public function main(array $vars)
    {
        $arfolyamModel = new Arfolyam_Model;
        $arfolyamModel->arfolyam();
        $view = new View_Loader($this->baseName . "_main");
    }
}
?>