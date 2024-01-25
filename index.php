<?php

//alkalmazás gyökér könyvtára a szerveren
define('SERVER_ROOT', $_SERVER['DOCUMENT_ROOT'].'/olajka/'); //root a szerveren

//URL cím az alkalmazás gyökeréhez
define('SITE_ROOT', 'http://localhost/olajka/'); //url a roothoz

// a router.php vezérlő betöltése
require_once(SERVER_ROOT . 'controllers/' . 'router.php');

?>