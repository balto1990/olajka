<?php
?>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="<?= SITE_ROOT?>css/mnb.css">
</head>
<body class="mnb_main">

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<h2><?= (isset($viewData['uzenet']) ? $viewData['uzenet'] : "") ?></h2>


<form action="" method="post" id="form1">
    <label class="select" for="deviza">Válassza ki az átváltandó devizát:</label><br><br>

    <input type="date" class="mnb" name="date" id="date" value="<?php echo date("Y-m-d"); ?>" required>
    <input type="number" class="mnb" name="mennyi" id="mennyi" placeholder="Összeg" value="1" required>
    <select class="mnb" name="deviza" id="deviza">
        <option value="USD">USD - Amerikai dollár</option>
        <option value="EUR">EUR - Euro</option>
        <option value="HUF">HUF - Magyar forint</option>
        <option value="GBP">GBP - Angol font</option>
        <option value="AUD">AUD - Ausztrál dollár</option>
        <option value="BGN">BGN - Bolgár leva</option>
        <option value="CAD">CAD - Kanadai dollár</option>
        <option value="CHF">CHF - Svájci frank</option>
        <option value="CNY">CNY - Kínai juan</option>
        <option value="CZK">CZK - Cseh korona</option>
        <option value="DKK">DKK - Dán korona</option>
        <option value="HRK">HRK - Horvát kuna</option>
        <option value="JPY">JPY - Japán yen</option>
    </select>

    <select class="mnb" name="deviza2" id="deviza2">
        <option value="HUF">HUF - Magyar forint</option>
        <option value="CAD">CAD - Kanadai dollár</option>
        <option value="HUF">HUF - Magyar forint</option>
        <option value="EUR">EUR - Euro</option>
        <option value="USD">USD - Amerikai dollár</option>
        <option value="GBP">GBP - Angol font</option>
        <option value="AUD">AUD - Ausztrál dollár</option>
        <option value="BGN">BGN - Bolgár leva</option>
        <option value="CHF">CHF - Svájci frank</option>
        <option value="CNY">CNY - Kínai juan</option>
        <option value="CZK">CZK - Cseh korona</option>
        <option value="DKK">DKK - Dán korona</option>
        <option value="HRK">HRK - Horvát kuna</option>
        <option value="JPY">JPY - Japán yen</option>
    </select>



    <input class="mnb_btn" type="submit" name="valtas" value="Váltás" form="form1"><br><br>





    <?php
    if(isset($_POST['valtas'])){
        if(isset($_POST['eredmeny'])){
            ?>
            <input class="mnb" value="<?php echo $_POST['mennyi']; ?>" readonly>
            <input class="mnb" value="<?php echo $_POST['deviza']; ?>" readonly>
            <input class="mnb" value="<?php echo number_format($_POST['eredmeny'], 2); ?>" readonly>
            <input class="mnb" value="<?php echo $_POST['deviza2']; ?>" readonly>
            <?php
        }else{
            ?>
            <input class="mnb" value="" readonly>
            <input class="mnb" value="" readonly>
            <input class="mnb" value="" readonly>
            <input class="mnb" value="" readonly>
            <p class="select">Ezen a napon nem volt árfolyamváltozás!</p>
            <?php
        }
    }else{
        ?>
            <input class="mnb" value="" readonly>
            <input class="mnb" value="" readonly>
            <input class="mnb" value="" readonly>
            <input class="mnb" value="" readonly>
        <?php
    }
    ?>

</form>


<!--ELSŐ LEKÉRDEZÉS VÉGE-->



    <form action="" method="post" id="form2">
        <br><br>
        <label class="select" for="deviza">Devizapár árfolyama egy adott időintervallumban:</label><br>
        <label class="select" for="deviza">Kezdete - Vége</label><br><br>

        <input type="date" class="mnb" name="date_interval_1" id="date_interval_1" value="2021-10-01" required>
        <input type="date" class="mnb" name="date_interval_2" id="date_interval_2" value="2021-11-05" required>
        <select class="mnb" name="deviza_iv" id="deviza_iv">
            <option value="USD">USD - Amerikai dollár</option>
            <option value="EUR">EUR - Euro</option>
            <option value="GBP">GBP - Angol font</option>
            <option value="AUD">AUD - Ausztrál dollár</option>
            <option value="BGN">BGN - Bolgár leva</option>
            <option value="CAD">CAD - Kanadai dollár</option>
            <option value="CHF">CHF - Svájci frank</option>
            <option value="CNY">CNY - Kínai juan</option>
            <option value="CZK">CZK - Cseh korona</option>
            <option value="DKK">DKK - Dán korona</option>
            <option value="HRK">HRK - Horvát kuna</option>
            <option value="JPY">JPY - Japán yen</option>
        </select>

        <select class="mnb" name="deviza2_iv" id="deviza2_iv">
            <option value="JPY">JPY - Japán yen</option>
            <option value="CAD">CAD - Kanadai dollár</option>
            <option value="EUR">EUR - Euro</option>
            <option value="USD">USD - Amerikai dollár</option>
            <option value="GBP">GBP - Angol font</option>
            <option value="AUD">AUD - Ausztrál dollár</option>
            <option value="BGN">BGN - Bolgár leva</option>
            <option value="CHF">CHF - Svájci frank</option>
            <option value="CNY">CNY - Kínai juan</option>
            <option value="CZK">CZK - Cseh korona</option>
            <option value="DKK">DKK - Dán korona</option>
            <option value="HRK">HRK - Horvát kuna</option>

        </select>
        
        <input class=mnb_btn type="submit" name="valtas_interval" value="Váltás" form="form2"><br><br>
        
     </form>

<div style="overflow-x:auto;">
<table>
<?php
    if(isset($_GET['valtas_interval'])){
        
        if($_POST['valtas_interval_end']  = true) 
    {?>
                    <thead>
                    <tr>
                        <th>Dátum</th>
                        <th>Egység</th>
                        <th>Deviza</th>
                        <th>Árfolyam</th>
                        <th>Egység</th>
                        <th>Deviza</th>
                        <th>Árfolyam</th>
                    </tr>
                    </thead>
                     <?php
                        $y = (count($_POST['date_arr']) -1);
                        for ($x = 0; $x <= $y; $x++) {
                        ?>
                    <tbody>
                    <tr>        
                         <td><?php print_r($_POST['date_arr'][$x]); ?></td>
                         <td><?php print_r($_POST['unit1_arr'][$x]); ?></td>
                         <td><?php print_r($_POST['dev1_arr'][$x]); ?></td>
                         <td><?php print_r($_POST['dev_rate1_arr'][$x]); ?></td>
                         <td><?php print_r($_POST['unit2_arr'][$x]); ?></td>
                         <td><?php print_r($_POST['dev2_arr'][$x]); ?></td>
                         <td><?php print_r($_POST['dev_rate2_arr'][$x]); ?></td>
                    </tr>
                    </tbody>
                        <?php
                        $labels = $_POST['date_arr'];
                        $title1 = $_POST['dev1_arr'][0];
                        $adatok1 = $_POST['dev_rate1_arr'];
                        $title2 = $_POST['dev2_arr'][0];
                        $adatok2 = $_POST['dev_rate2_arr'];
                        }
                        ?>
                
<?php
    }
}
?>
</table>
</div>
<div>
  <canvas id="myChart" width="200" height="100"></canvas>
</div>
<?php 

?>
<script>	//-------- diagramm --------

const ctx = document.getElementById('myChart');
const myChart = new Chart(ctx, {
    type: 'line',
    data: {
       datasets: [{
           label: <?php echo json_encode($title1); ?>,
           data: <?php echo json_encode($adatok1); ?>,
           borderColor: 'rgb(255,28,37)',
           borderWidth: 4,
           order: 2
       }, {
           label: <?php echo json_encode($title2); ?>,
           data: <?php echo json_encode($adatok2); ?>,
           type: 'line',
           borderColor: 'rgb(0,111,255)',
           borderWidth: 4,
           order: 1
           
       }],
       
       labels: <?php echo json_encode($labels); ?>
   },
    options: {
        scales: {
            y: {
                beginAtZero: false
            }
        }
    }
});
</script>
</body>