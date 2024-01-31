<!DOCTYPE html>
<html>
<head>
    <meta charset="utf8_hungarian_ci">
    <title>Új hírek megosztása</title>
    <link rel="stylesheet" type="text/css" href="<?php echo SITE_ROOT?>css/input.css">
</head>
<body class="hir_background">
<div>
        <form action="" method="post">
        <fieldset>
            <legend><h2>Hír hozzáadása</h2></legend>

            <label for="title_hir">Hír címe</label><input  type="text" name="title_hir" id="title_hir" required><br>

            <label for="tartalom_hir">Tartalom</label><textarea class="hirin" type="text" name="tartalom_hir" id="tartalom_hir" required></textarea><br>

            <label for="link_hir">Hír - eredeti link</label><input class="hirin" type="text" name="link_hir" id="link_hir"><br>

            <label for="image_link_hir">Kép - link</label><input class="hirin" type="text" name="image_link_hir" id="image_link_hir"><br>

            <label for="published_at_hir">Dátum</label><input class="hirin" type="datetime-local" name="published_at_hir" id="published_at_hir" required><br>

            <input type="submit" class="re" value="Küldés">
        </fieldset>
    </form>
</div>

