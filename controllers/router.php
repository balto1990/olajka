<?php

session_start();
if(! isset($_SESSION['userid'])) $_SESSION['userid'] = 0;
if(! isset($_SESSION['userfirstname'])) $_SESSION['userfirstname'] = "";
if(! isset($_SESSION['userlastname'])) $_SESSION['userlastname'] = "";
if(! isset($_SESSION['userlevel'])) $_SESSION['userlevel'] = "1__";

include(SERVER_ROOT . 'includes/database.inc.php');
include(SERVER_ROOT . 'includes/menu.inc.php');

// Felbontjuk a paramétereket. Az & elválasztó jellel végzett felbontás
// megfelelő lesz, első eleme a megtekinteni kívánt oldal neve.

$page = "nyitolap"; //változó
$subpage = "";
$vars = array();

$request = $_SERVER['QUERY_STRING'];

if($request != "") //ha a request nem 0
{
	$params = explode('/', $request); // akkor params= /kulcs+request érték
	$page = array_shift($params); // a kért oldal neve
	
	if(array_key_exists($page, Menu::$menu) && count($params)>0) // Az oldal egy menüpont oldala és van még adat az url-ben
	{
		$subpage = array_shift($params); // a kért aloldal
		if(! (array_key_exists($subpage, Menu::$menu) && Menu::$menu[$subpage][1] == $page)) // ha nem egy alolal
		{
			$vars[] = $subpage; // akkor ez egy parameter
			$subpage = ""; // és nincs aloldal
		}
	}
	$vars += $_POST;
	
	foreach($params as $p) // a paraméterek tömbje feltöltése
	{
		$vars[] = $p;
	}
}

// Meghatározzuk a kért oldalhoz tartozó vezérlőt. 

$controllerfile = $page.($subpage != "" ? "_".$subpage : "");
$target = SERVER_ROOT.'controllers/'.$controllerfile.'.php';
if(! file_exists($target))
{
	$controllerfile = "error404";
	$target = SERVER_ROOT.'controllers/error404.php';
}

include_once($target);
$class = ucfirst($controllerfile).'_Controller';
if(class_exists($class))
	{ $controller = new $class; }
else
	{ die('class does not exists!'); }

// spl_autoload_register(...) függvény, amely ismeretlen osztály hívásakor, megpróbálja automatikusan betölteni a megfelelő fájlt. 
// A modellekhez használjuk, egységesen nevezzk el fájljainkat (osztály nevével megegyező, csupa kisbetűs .php)
spl_autoload_register(function($className) {
    $file = SERVER_ROOT.'models/'.strtolower($className).'.php';
    if(file_exists($file))
    { include_once($file); }
    else
    { die("File '$file' containing class '$className' not found.");    }
});

$controller->main($vars);

?>