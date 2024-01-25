<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset=""UTF-8">
    <title>MNB árfolyamok lekérdezése PHP, SQL és SOAP segítségével</title>
</head>
<body>

<?php
    // Az elején lerendezzük, hogy esetleg felküldött értékek vannak-e, ha igen, betesszük változóba
    if (isset($_POST['foreigncurr1'])) $fromCurrency = $_POST['foreigncurr1'];
    if (isset($_POST['foreigncurr2'])) $toCurrency = $_POST['foreigncurr2'];
    if (isset($_POST['firstdate'])) $firstDate = $_POST['firstdate'];
    if (isset($_POST['lastdate'])) $lastDate = $_POST['lastdate'];

    $kitoltott = isset($fromCurrency) && isset($toCurrency) && isset($firstDate) && isset($lastDate);
    
    // Ha minden ki van töltve, lekérdezzük az árfolyamot az időszakra
    if ($kitoltott) {
        $client = new SoapClient("http://www.mnb.hu/arfolyamok.asmx?WSDL");
        $penznemparok = $toCurrency . "," . $fromCurrency;
    
        $param = array('startDate' => $firstDate, 'endDate' => $lastDate, 'currencyNames' => $penznemparok);
        $result = $client->__soapCall('GetExchangeRates', array('parameters' => $param));
        $xml = new SimpleXMLElement($result->GetExchangeRatesResult);

        $nap = $xml->Day;
        $curr = $toCurrency . " - " . $fromCurrency;
        for ($i = 0; $i < count($nap); $i++) {
            $retData['valuta'][$i]['date'] = $nap[$i]['date'];
            $retData['valuta'][$i]['curr'] = $curr;
            $retData['valuta'][$i]['unit'] = (strpos($curr, "JPY") > -1) ? "100" : "1";
            if ($nap[$i]->Rate[0]['curr'] == $fromCurrency) {
                $retData['valuta'][$i]['foreigncurr2'] = str_replace(",", ".", $nap[$i]->Rate[0]);
                $retData['valuta'][$i]['foreigncurr1'] = str_replace(",", ".", $nap[$i]->Rate[1]);
            } else {
                $retData['valuta'][$i]['foreigncurr1'] = str_replace(",", ".", $nap[$i]->Rate[0]);
                $retData['valuta'][$i]['foreigncurr2'] = str_replace(",", ".", $nap[$i]->Rate[1]);
            }
        }
    }
    // Ettől a ponttól fogva ha létezik a $retData változó, akkor felküldött adattal dolgozunk, ha nem létezik, akkor még nem ment le a lekérdezés
?>

<div class="container">
    <h1>MNB Árfolyamok</h1><br>

    <div><h2>Napi és havi árfolyamok:</h2></div>
    <div><h3>Deviza választások</h3></div>

    <form name="lekerdezes" action="arfolyam_main.php" method="POST">
        <div><h5>Amiről át szeretnénk váltani (1 egységet betöltő pénznem)</h5></div>
        <select name="foreigncurr1" id="foreigncurr1" class="form-select" required>
            <?php
            try {
                $client = new SoapClient("http://www.mnb.hu/arfolyamok.asmx?WSDL");
                $result = $client->__soapCall('GetCurrencies', array());
                $xml = new SimpleXMLElement($result->GetCurrenciesResult);

                $deviza = $xml->Currencies->Curr;
                for ($i = 0; $i < count($deviza); $i++) {
                    // Ha létezik a fromCurrency változó (fentről), akkor egy "selected"-et még beillesztünk az adott opcióhoz, hogy felküldés után ki legyen választva az amit felküldtünk
                    $kivalasztott = isset($fromCurrency) && $fromCurrency == $deviza[$i];
                    $kivalaszto = '';
                    if ($kivalasztott) $kivalaszto = ' selected';
                    echo '<option' . $kivalaszto . '>' . $deviza[$i] . '</option>';
                }
            } catch (SoapFault $e) {
                var_dump($e);
            }
            ?>
        </select>

        <div><h5>Amelyik pénznemre át szeretnénk váltani</h5></div>
        <div class="col-auto">
            <select name="foreigncurr2" id="foreigncurr2" class="form-select" required>
                <?php
                    for ($i = 0; $i < count($deviza); $i++) {
                        // Ugyanúgy selected-et állítunk csak be
                        $kivalasztott = isset($toCurrency) && $toCurrency == $deviza[$i];
                        $kivalaszto = '';
                        if ($kivalasztott) $kivalaszto = ' selected';
                        echo '<option>' . $deviza[$i] . '</option>';
                    }
                ?>
            </select>
        </div>
        
        <div><h3>Dátumok</h3></div>
        
        <label for="kezdodatum">
            <?php
                // Itt pedig pl. egy value="2011-02-10" értéket teszünk be, hogy ki legyen választva a dátum, ha felküldött adattal dolgozunk már
                $kivalasztott = isset($firstDate);
                $kivalaszto = '';
                if ($kivalasztott) $kivalaszto = 'value="' . $firstDate . '"';
                echo '<h5>Kezdő dátum: <input type="date" ' . $kivalaszto . ' class="form-control" name="firstdate" id="kezdodatum" required></h5>';
            ?>
        </label>

        <label for="zarodatum">
            <?php
                // Ugyanaz
                $kivalasztott = isset($lastDate);
                $kivalaszto = '';
                if ($kivalasztott) $kivalaszto = 'value="' . $lastDate . '"';
                echo '<h5>Záró dátum: <input type="date" ' . $kivalaszto . ' class="form-control" name="lastdate" id="zarodatum" required></h5>';
            ?>
        </label>

        <button type="submit" class="exchangeratesubmit">Lekérdez</button>
    </form>

    <?php
        // Ha volt felküldött adat, még tegyük bele ezt...
        if (isset($retData)) {
    ?>
        <table class="table searching exchangerate">
            <thead>
                <tr>
                    <th>Dátum</th>
                    <th>Egység</th>
                    <th>Külföldi pénznem</th>
                    <th>Árfolyam</th>
                </tr>
            </thead>
            <tbody id="eredmeny">

            <?php
                for ($i = 0; $i < count($retData['valuta']); $i++) {
                    echo '<tr>';
                    echo "<td>" . $retData['valuta'][$i]['date'] . "</td>";
                    echo "<td>" . $retData['valuta'][$i]['unit'] . "</td>";
                    echo "<td>" . $retData['valuta'][$i]['curr'] . "</td>";
                    if (strpos($retData['valuta'][$i]['curr'], "HUF") > -1) {
                        $ertek = ($retData['valuta'][$i]['foreigncurr2']=="") ? $retData['valuta'][$i]['foreigncurr1'] : $retData['valuta'][$i]['foreigncurr2'];
                        echo "<td>" . $ertek . "</td>";
                    } else {
                        $ertek = (float)$retData['valuta'][$i]['foreigncurr2'] / (float)$retData['valuta'][$i]['foreigncurr1'];
                        echo "<td>" . $ertek . "</td>";
                    }
                    echo '</tr>';
                }
                $retData = array();
            ?>
            </tbody>
        </table>
    <?php
        }
    ?>

</div>
</body>
</html>
arfolyam_main.php

arfolyam_main.php megjelenítése.