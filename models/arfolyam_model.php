<?php
class Arfolyam_Model
{
    public function arfolyam()
    {
        if (isset($_POST['valtas'])) {
            if (isset($_POST["deviza"]) && ($_POST["deviza2"]) && ($_POST["date"]) && ($_POST["mennyi"])) {
                $deviza = $_POST["deviza"];
                $deviza2 = $_POST["deviza2"];
                $date = $_POST["date"];
                $mennyi = $_POST["mennyi"];
                $nenezd = "HUF";

                unset($currates);

                $client = new SoapClient("http://www.mnb.hu/arfolyamok.asmx?WSDL", array('trace' => true));
                $currrates = $client->GetExchangeRates(array('startDate' => $date, 'endDate' => $date, 'currencyNames' => "$deviza"))->GetExchangeRatesResult;

                $dom_root = new DOMDocument();
                $dom_root->loadXML($currrates);

                $searchNode = $dom_root->getElementsByTagName("Day");

                foreach ($searchNode as $searchNode) {

                    $rates = $searchNode->getElementsByTagName("Rate");

                    foreach ($rates as $rate) {
                        $unit_1 = "\t" . $rate->getAttribute('unit') . " ";
                        $deviza_ = $rate->getAttribute('curr');
                        $dev_rate = $rate->nodeValue;
                        $deviza_rate = str_replace(",", ".", $dev_rate);
           
                    }
                }

                $currrates2 = $client->GetExchangeRates(array('startDate' => $date, 'endDate' => $date, 'currencyNames' => "$deviza2"))->GetExchangeRatesResult;

                $dom_root = new DOMDocument();
                $dom_root->loadXML($currrates2);

                $searchNode = $dom_root->getElementsByTagName("Day");

                foreach ($searchNode as $searchNode) {

                    $rates = $searchNode->getElementsByTagName("Rate");

                    foreach ($rates as $rate) {
                        $unit_2 = "\t" . $rate->getAttribute('unit') . " ";
                        $deviza_2 = $rate->getAttribute('curr');
                        $dev_rate2 = $rate->nodeValue;
                        $deviza_rate2 = str_replace(",", ".", $dev_rate2);
                    }
                }
                if (isset($deviza_rate) or isset($deviza_rate2)) {
                    if ($deviza == $nenezd and $deviza2 !== $nenezd) {   //HUH - Deviza
                        $_POST['eredmeny'] = ($mennyi / $deviza_rate2) * $unit_2;
                    }
                    if ($deviza !== $nenezd and $deviza2 == $nenezd) {  //Deviza - HUF
                        $_POST['eredmeny'] = ($deviza_rate * $mennyi) / $unit_1;
                    }
                    if ($deviza !== $nenezd and $deviza2 !== $nenezd) {   //Deviza - Deviza
                        $_POST['eredmeny'] = (($deviza_rate * $unit_1) / ($deviza_rate2 * $unit_2)) * $mennyi;
                    }
                    if ($deviza == $nenezd and $deviza2 == $nenezd) {   //HUF - HUF
                        $_POST['eredmeny'] = $mennyi;
                    }
                }
            }
        }


        if (isset($_POST['valtas_interval'])) {
            if (isset($_POST["deviza_iv"]) && ($_POST["deviza2_iv"]) && ($_POST["date_interval_1"]) && ($_POST["date_interval_2"])) {

                $date_interval_1 = $_POST["date_interval_1"];
                $date_interval_2 = $_POST["date_interval_2"];
                $deviza_iv = $_POST["deviza_iv"];
                $deviza2_iv = $_POST["deviza2_iv"];
                $devizas_int = $_POST["deviza_iv"].",".$_POST["deviza2_iv"];
                $nenezd = "HUF";

                $client = new SoapClient("http://www.mnb.hu/arfolyamok.asmx?WSDL", array('trace' => true));
                $currrates = $client->GetExchangeRates(array('startDate' => $date_interval_1, 'endDate' => $date_interval_2, 'currencyNames' => $devizas_int))->GetExchangeRatesResult;

                $dom_root = new DOMDocument();
                $dom_root->loadXML($currrates);

                $searchNode = $dom_root->getElementsByTagName("Day");

                $dev_rule = true;
                $date_arr = array();
                $dev1_arr = array();
                $dev2_arr = array();
                $unit1_arr = array();
                $unit2_arr = array();
                $dev_rate1_arr = array();
                $dev_rate2_arr = array();
                foreach ($searchNode as $searchNode) {
                    $date = $searchNode->getAttribute('date');
                    array_push($date_arr, $date);
                    $rates = $searchNode->getElementsByTagName("Rate");

                    foreach ($rates as $rate) {
                        $unit_1_iv = "\t" . $rate->getAttribute('unit') . " ";
                        $deviza_iv_ = $rate->getAttribute('curr');
                        $dev_rate_iv = $rate->nodeValue;
                        $deviza_rate_iv = str_replace(",", ".", $dev_rate_iv);

                        if($dev_rule == true) {
                            array_push($unit1_arr, $unit_1_iv);
                            array_push($dev1_arr, $deviza_iv_);
                            array_push($dev_rate1_arr, $deviza_rate_iv);
                            $dev_rule = false;
                        }else{
                            array_push($unit2_arr, $unit_1_iv);
                            array_push($dev2_arr, $deviza_iv_);
                            array_push($dev_rate2_arr, $deviza_rate_iv);
                            $dev_rule = true;
                        }
                    }
                }
                        $_POST['date_arr'] = $date_arr;
                        $_POST['unit1_arr'] = $unit1_arr;
                        $_POST['dev1_arr'] = $dev1_arr;
                        $_POST['dev_rate1_arr'] = $dev_rate1_arr;
                        $_POST['unit2_arr'] = $unit2_arr;
                        $_POST['dev2_arr'] = $dev2_arr;
                        $_POST['dev_rate2_arr'] = $dev_rate2_arr;

                        $_POST['valtas_interval_end'] = true;
                        $_GET['valtas_interval'] = true;
                        
                        }
                        ?>
                </table>
                <?php
            }
        }
    }