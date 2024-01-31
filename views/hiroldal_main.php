<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="<?php echo SITE_ROOT?>css/hiroldal.css">
</head>
<body class="hir_background"></body>
<h2 style="text-align:center;" id="kek"><b>HÍREK</b></h2>
<div class="container">
    <div class="row">
	
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
<h2 style="text-align:center;" id="kek"><b>NEM MINDEGY, MILYEN NYOMOT HAGYUNK!</b></h2>
<table>
    <tbody>

    <?php
    date_default_timezone_set("Europe/Budapest");

    for($i=0; $row = $_SESSION['result_s']->fetch(); $i++){
        $_SESSION['hir_id'] = $row['id'];

        ?>
        <tr>
            <th><label><?php echo $row['title_hir']; ?></label></th>
        </tr>
        <tr>
            <td><label><?php echo $row['tartalom_hir']; ?></label></td>
            <td>
                <div class="comment_div">
                    <?php
                    if ($_SESSION['hir_id']) {
                        $hir_id = $_SESSION['hir_id'];
                        while ($row2 = $_SESSION['result_c']->fetch()) {
                            if ($row2['melyik_hir'] == $hir_id) {
                                echo $row2['username'] . "<br> ";
                                echo $row2['tartalom'] . "<br> ";
                                echo $row2['published_at'] . "<br><br> ";
                            }
                        }
                        $_SESSION['result_c']->execute();
                    } ?>
                </div>
            </td>
        </tr>
        <tr>
            <form action="" method="post">
                <tr>
                    <td><label><?php echo $row['published_at_hir']; ?></label></td>
                </tr>

                <td><label><a class="link" href="<?php echo $row['link_hir']; ?>" target="_blank">Eredeti link</a>
                    <img class="like" onclick="like()" src="<?= SITE_ROOT ?>/images/like.gif">
                        <img class="like" onclick="unlike()" src="<?= SITE_ROOT ?>/images/unlike.gif">
                            <input id="id_hirek" name="id_hirek" type="hidden" value=<?php echo $row['id']; ?>>
                                <input id="tartalom" name="tartalom" class="comment" type="text" placeholder="Hozzászólás...">
                                    <input type="submit" class="btn_comment" value="Küldés...">
                    </label></td>
            </form>
        </tr>
    <?php
    }
    ?>
    </tbody>
</table>

