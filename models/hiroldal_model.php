<?php

class Hiroldal_Model
{
    public function get_data($vars)
    {
        $retData['eredmeny'] = "";

        try {
            $connection = Database::getConnection();
            $_SESSION['result_s'] = $connection->prepare("SELECT * FROM hirek ORDER BY published_at_hir DESC");
            $_SESSION['result_s']->execute();

            $connection3 = Database::getConnection();
            $_SESSION['result_c'] = $connection3->prepare("SELECT * FROM hozzaszolas ORDER BY published_at DESC");
            $_SESSION['result_c']->execute();


        }
        catch (PDOException $e)
        {
            $retData['eredmeny'] = "ERROR";
            $retData['uzenet'] = "Adatbazis hiba: " . $e->getMessage() . "!";
        }

        if (isset($_POST['tartalom'])) {
            try {
                $_POST['date'] = date("Y-m-d H:i:s");
                $_POST['user_name'] = $_SESSION['user_comment'];
                $connection_2 = Database::getConnection();
                $connection_2->query('SET NAMES utf8 COLLATE utf8_hungarian_ci');
                $sqlInsert = "insert into hozzaszolas(id, username, published_at, tartalom, melyik_hir)
                                            values(0, :username, :datetime, :tartalom, :melyik_hir)";
                $stmt = $connection_2->prepare($sqlInsert);
                $stmt->execute(array(':username' => $_POST['user_name'], ':datetime' => $_POST['date'], ':tartalom' => $_POST['tartalom'], ':melyik_hir' => $_POST['id_hirek']));




            } catch (PDOException $e) {
                echo "Hiba: " . $e->getMessage();
            }
        }


    }

}

