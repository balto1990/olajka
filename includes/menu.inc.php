<?php

class Menu
{
    public static $menu = array();

    public static function setMenu()
    {
        self::$menu = array();
        $connection = Database::getConnection();
        $stmt = $connection->prepare("SELECT url, nev, szulo, jogosultsag FROM menu WHERE jogosultsag LIKE :userlevel ORDER BY sorrend");
        $stmt->bindValue(':userlevel', $_SESSION['userlevel'], PDO::PARAM_STR);
        $stmt->execute();

        while ($menuitem = $stmt->fetch(PDO::FETCH_ASSOC)) {
            self::$menu[$menuitem['url']] = array($menuitem['nev'], $menuitem['szulo'], $menuitem['jogosultsag']);
        }
    }

    public static function getMenu($sItems)
    {
        $submenu = "";

        $menu = "<ul>";
        foreach (self::$menu as $menuindex => $menuitem) {
            if ($menuitem[1] == "") {
                $menu .= "<li><a href='" . SITE_ROOT . $menuindex . "' " . ($menuindex == $sItems[0] ? "class='selected'" : "") . ">" . $menuitem[0] . "</a></li>";
            } else if ($menuitem[1] == $sItems[0]) {
                $submenu .= "<li><a href='" . SITE_ROOT . $sItems[0] . "/" . $menuindex . "' " . ($menuindex == $sItems[1] ? "class='selected'" : "") . ">" . $menuitem[0] . "</a></li>";
            }
        }
        $menu .= "</ul>";

        if ($submenu != "")
            $submenu = "<ul>" . $submenu . "</ul>";

        return $menu . $submenu;
        ;
    }
}

Menu::setMenu();
?>