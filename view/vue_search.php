<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="../jQuery/jquery.min.js"></script>
    <link rel="stylesheet" href="../Bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles.css">
    <title>My Meetic - Recherche</title>
</head>
<body>
<?php include_once "header.php";
include_once "../model/DBO.php";
$bd = new DBO('my_meetic', '127.0.0.1', 'root', '080176');
$bd->connect();
$query = $bd->query('SELECT ville_nom, ville_code_postal FROM villes_france_free ORDER BY ville_nom');
echo '<script> var test = {';
foreach ($query as $val) {
    echo '"'.$val['ville_nom'] . '":"' . $val["ville_code_postal"].'",';
}
echo '};';
echo '</script>';?>
<h1>Rechercher menbre</h1>
<form action="../controler/index.php?p=search" method="post" >
    <label>Femme : <input type="checkbox" name="femme" <?php if($_POST['femme']){echo "checked";} ?>"></label>
    <label>Homme : <input type="checkbox" name="homme" <?php if($_POST['homme']){echo "checked";} ?>"></label>
    <label>Autres : <input type="checkbox" <?php if($_POST['autres']){echo "checked";} ?> name="autres"></label>
    <select id="age">
        <option value=""></option>
        <option value=""></option>
        <option value=""></option>
        <option value=""></option>
        <option value=""></option>
    </select>
    <span id="ville_cur"></span>
    <div id="ville_box">
    <label for="cpostal">Code Postal :</label>
        <select name="cpostal" id="cpostal">
            <?php
            $str = "";
            $bd->connect();
            $query = $bd->query('SELECT DISTINCT ville_code_postal FROM villes_france_free ORDER BY ville_code_postal');
            foreach ($query as $val) {
                echo '<option value='.$val['ville_code_postal'].'>'.$val['ville_code_postal'].'</option>';
            }
            ?>
        </select>
    <label for="ville">Code Postal :</label>
    <select name="ville" id="ville">
        <option value="#">Selectionner un code postal</option>
    </select>
        <button id="ville_add">Ajouter une ville</button>
    </div>
    <script>
        var i = 1;
        $("#ville_add").click(function (e) {
            e.preventDefault();
            $("#ville_cur").append("<a href='#'>"+$("#ville").val()+"</a>");
        });
        $("#cpostal").on('change', function () {
            var value;
            var result = [];
            $("#ville option").remove();
            for(var key in test) {
                value = test[key];
                if (value === this.value) {
                    $("#ville").append("<option value='"+key+"'>"+key+"</option>");
                }
            }
        });
        $("#ville").on('change', function () {
            var b = i+'ville';
            $.ajax({
                type: 'POST',
                url: '../controler/index.php?p=subscribe',
                data: {
                    b: this.value
                },
                success: function (data) {
                    console.log("ok");
                }
            });
            i=i+1;
        })
    </script>
    <input type="submit" title="submit" value="Chercher">
</form>
<?php
if ($_POST['cpostal'] != NULL) {
    $bd->connect();
    echo $bd->userSearch($_POST['homme'], $_POST['femme'], $_POST['autres'], $_POST['cpostal']);
}
?><?php include_once "footer.php";?>
</body>
</html>