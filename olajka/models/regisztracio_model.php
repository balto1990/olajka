<?php

class Regisztracio_Model
{
	public function get_data($vars)
	{
		$retData['eredmeny'] = "";
		try {
      if($_POST['csaladi_nev'] == "" || $_POST['utonev'] == "" || $_POST['login'] == "" || $_POST['jelszo'] == "")
        {
          $retData['eredmeny'] = "ERROR";
					$retData['uzenet'] = "Nincs kitöltve az összes mező";        }
        // Ha megkaptunk minden adatot hozzuk létre a felhasználót a táblában
        else
        {
			$connection = Database::getConnection();
			$sql = "select id, csaladi_nev, utonev, jogosultsag from felhasznalok where bejelentkezes='".$vars['login']."' ";
			$stmt = $connection->query($sql);
			$felhasznalo = $stmt->fetchAll(PDO::FETCH_ASSOC);
			switch(count($felhasznalo)) {
				case 0:
					$retData['eredmeny'] = "OK";
					$retData['uzenet'] = "Sikeres regisztráció " . $vars['login'] ;
                    $sqlInsert = "insert into felhasznalok(id, csaladi_nev, utonev, bejelentkezes, jelszo, jogosultsag) values (0, :csaladinev, :utonev, :bejelentkezes, :jelszo, :jogosultsag  ) ";
                    $stmt = $connection->prepare($sqlInsert); 
                    $stmt->execute(array(':csaladinev' => $vars['csaladi_nev'], ':utonev' => $vars['utonev'],
                    ':bejelentkezes' => $vars['login'],':jogosultsag' => "_1_" ,':jelszo' => sha1($vars['jelszo']))); 
					break;
				
				default:
					$retData['eredmeny'] = "ERROR";
					$retData['uzenet'] = "Ezzel a felhasználónévvel már regisztráltak!";
			}
		}}
		catch (PDOException $e) {
					$retData['eredmeny'] = "ERROR" ;
					$retData['uzenet'] = "Adatbázis hiba: ".$e->getMessage()."!";
		}
  
		return $retData;
  
	}
}

?>