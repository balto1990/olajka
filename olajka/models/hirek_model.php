<?php

class Hirek_Model
{
	public function get_data($vars)
	{
		$retData['eredmeny'] = "";
		try {

            if($_POST['message'] == "")
            {
                $retData['eredmeny'] = "ERROR";
		        $retData['uzenet'] = "Nincs üzenet";        
            }

            else
            {
                $connection = Database::getConnection();

					$retData['eredmeny'] = "ERROR";
					$retData['uzenet'] = "Sikeres küldés"; //. $vars['login'] ;

                    $sqlInsert = "insert into hirek(id, hir, felhasznalo, time) values (0, :hir, :felhasznalo, :time)";
                    $stmt = $connection->prepare($sqlInsert); 
                    $stmt->execute(array(':hir' => $vars['message'], ':felhasznalo' => $_SESSION['userlogin'],
                    ':time' => date('Y-m-d H:i:s'))); 
			
		    }
    }
		catch (PDOException $e) {
					$retData['eredmeny'] = "ERROR" ;
					$retData['uzenet'] = "Adatbázis hiba: ".$e->getMessage()."!";
		}
  
		return $retData;
  
	}

    public function get_news(){

        $connection = Database::getConnection();
         $sql="select hir, felhasznalo, time from hirek order by id desc";
         $query = $connection->query($sql);
         $felhasznalo = $query->fetchAll(PDO::FETCH_ASSOC);
         $_SESSION['cnt']=count($felhasznalo);

            for ($i=0; $i < count($felhasznalo) ; $i++) { 
    
         $_SESSION['hir'.$i]=$felhasznalo[$i]['hir'];
         $_SESSION['felhasznalo'.$i]=$felhasznalo[$i]['felhasznalo'];
         $_SESSION['time'.$i]=$felhasznalo[$i]['time'];

        }

       return $felhasznalo;
      
    }
}

?>