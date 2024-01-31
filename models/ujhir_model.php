<?php
class Ujhir_Model
{
    public function ujhir()
    {
        if (isset($_POST['title_hir']) && isset($_POST['tartalom_hir']) && isset($_POST['link_hir']) && isset($_POST['image_link_hir']) && isset($_POST['published_at_hir'])) {
            try {

                $dbh = Database::getConnection();
                $dbh->query('SET NAMES utf8 COLLATE utf8_hungarian_ci');

                // Létezik már ilyen című hír?
                $sqlSelect = "select id from hirek where title_hir = :title_hir";
                $sth = $dbh->prepare($sqlSelect);
                $sth->execute(array(':title_hir' => $_POST['title_hir']));

                $sqlInsert = "insert into hirek(id, title_hir, tartalom_hir, link_hir, image_link_hir, published_at_hir)
                                        values(0, :title_hir, :tartalom_hir, :link_hir, :image_link_hir, :published_at_hir)";
                $stmt = $dbh->prepare($sqlInsert);
                $stmt->execute(array(':title_hir' => $_POST['title_hir'], ':tartalom_hir' => $_POST['tartalom_hir'], ':link_hir' => $_POST['link_hir'], ':image_link_hir' => $_POST['image_link_hir'], ':published_at_hir' => $_POST['published_at_hir']));

                    if ($count = $stmt->rowCount()) {
                        $newid = $dbh->lastInsertId();
                        echo "<script>alert('A rögzítés sikeres. Azonosítója: {$newid}')</script>";
                        $redo = false;
                        $next = true;
                    } else {
                        echo "<script>alert('A rögzítés nem sikerült.')</script>";
                        $redo = true;
                    }

            } catch (PDOException $e) {
                echo "Hiba: " . $e->getMessage();
            }
        }
    }
}

