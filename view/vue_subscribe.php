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
    <title>My Meetic - inscription</title>
</head>
<body>
<?php include_once "header.php";
include_once "../model/DBO.php";
$bd = new DBO('my_meetic', '127.0.0.1', 'root', '080176');
$bd->connect();
if ($_POST['email']!= NULL) {
    echo "OK!";
}

    $cpostal = $bd->quote($_GET['cpostal']);
    $str = "";
    $query = $bd->query('SELECT ville_nom, ville_code_postal FROM villes_france_free');
    echo '<script>var test = {';
    foreach ($query as $val) {
        echo '"'.$val['ville_nom'] . '":"' . $val["ville_code_postal"].'",';
    }
    echo '};';
    echo '</script>';


?>

<div class="container">
    <form class="center-block" style="width: 40%" method="post" action="../controler/index.php?p=subscribe">
        <div class="form-group row">
            <label for="nom"  class="col-lg-5 col-form-label" >Nom : </label>
            <div class="col-lg-7"><input required class="form-control" value="<?php echo $_POST['nom'];?>" id="nom" name="nom" type="text"></div>
        </div>
        <div class="form-group row">
            <label for="prenom"  class="col-lg-5 col-form-label" >Prenom : </label>
            <div class="col-lg-7"><input required class="form-control" value="<?php echo $_POST['prenom'];?>" id="prenom" name="prenom" type="text"></div>
        </div>
        <div class="form-group row">
            <label for="pseudo"  class="col-lg-5 col-form-label" >Pseudo :</label>
            <div class="col-lg-7"><input required class="form-control" value="<?php echo $_POST['pseudo'];?>" id="pseudo" name="pseudo" type="text"></div>
        </div>
        <div class="form-group row">
            <label for="date"  class="col-lg-5 col-form-label" >Date de naissance : </label>
            <div class="col-lg-7">
                <select name="day">
                    <?php
                    for ($i=1; $i<= 31; $i++) {
                        echo "<option value='".$i."'>".$i."</option>";
                    }
                    ?>
                </select>
                <select name="mounth">
                    <?php
                    for ($i=1; $i<= 12; $i++) {
                        echo "<option value='".$i."'>".$i."</option>";
                    }
                    ?>
                </select>
                <select name="year">
                    <?php
                    for ($i=1900; $i<= date("Y") - 18; $i++) {
                        echo "<option value='".$i."'>".$i."</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="select1"  class="col-lg-5 col-form-label" >Sexe : </label>
            <div class="col-lg-7"><select required id="select1" class="form-control" name="sexe" >
                    <option value="1">Homme</option>
                    <option value="2">Femme</option>
                    <option value="3">Autre</option>
                </select></div>
        </div>
        <div class="form-group row">
            <label for="select"  class="col-lg-5 col-form-label" >Code postal : </label>
            <div class="col-lg-7"><select id="select" required class="form-control" id="cpostal" name="cpostal" >
                    <?php

                    $str = "";
                    $query = $bd->query('SELECT DISTINCT ville_code_postal FROM villes_france_free ORDER BY ville_code_postal');
                    foreach ($query as $val) {
                        echo '<option value='.$val['ville_code_postal'].'>'.$val['ville_code_postal'].'</option>';
                    }
                    ?>
                </select></div>
        </div>
        <div class="form-group row">
            <label for="select2"  class="col-lg-5 col-form-label" >Ville : </label>
            <div class="col-lg-7"><select id="select2" required class="form-control" name="ville" >
                    <option value="<?php echo $_POST['ville'] ?>">Selectioner un code postal</option>
                </select></div>
        </div>
        <script>
            var select = $('#select');
            var select1 = $('#select1');
            var select2 = $('#select2');
            $(function () {
                select.val("<?php echo $_GET['cpostal'];?>");
                select1.val("<?php echo $_POST['sexe'];?>");
                //select2.val("<?php echo $_POST['ville'];?>");
            });
            select.on('change', function () {
                var value;
                var result = [];
                $("#select2 option").remove();
                for(var key in test) {
                    value = test[key];
                    if (value === this.value) {
                        console.log(key);
                        select2.append("<option value='"+key+"'>"+key+"</option>");
                    }
                }
            });
            select2.on('change', function () {
                $.ajax({
                    type: 'POST',
                    url: '../controler/index.php?p=subscribe',
                    data: {
                        'ville': this.value
                    },
                    success: function (data) {
                        console.log("ok");
                    }
                });
            })
        </script>
        <div class="form-group row">
            <label for="email"  class="col-lg-5 col-form-label" >Email : </label>
            <div class="col-lg-7"><input required class="form-control" value="<?php echo $_POST['email'];?>" id="email" name="email" type="email"></div>
        </div>
        <div class="form-group row">
            <label for="pass"  class="col-lg-5 col-form-label" >Mot de passe : </label>
            <div class="col-lg-7"><input required class="form-control" id="pass" name="pass" type="password"></div>
        </div>
        <div class="form-group row">
            <label for="passconf"  class="col-lg-5 col-form-label" >Comfirmation : </label>
            <div class="col-lg-7"><input required class="form-control " id="passconf" name="passconf" type="password"></div>
        </div>
        <div class="form-group row">
            <div class="col-lg-7"><input required class="btn btn-primary" type="submit"></div>
        </div>
    </form>
    <?php
    if ($_POST['email']!= NULL) {
        if ($_POST['pass'] != $_POST['passconf']) {

            echo "<span>Erreur Mot de passe diferent</span>";
        }
        if (strlen($_POST['pass']) < 8 ) {

            echo "<span>Mot de passe trop faible</span>";
        }
        if($bd->userExist($_POST['pseudo'], $_POST['email']) == 2) {

            echo "<span>Erreur email ou pseudo deja existant</span>";
        }
        else {
            echo "OK!1";
            var_dump($_POST['ville']);
            $id_ville = $bd->toIdville($_POST['ville']);
            echo "OK!2".$id_ville;
            $bd->userAdd($_POST['pseudo'], $_POST['nom'], $_POST['prenom'], $_POST['year'].'-'.$_POST['mounth'].'-'.$_POST['day'],  $id_ville, $_POST['sexe'], $_POST['email'], crypt($bd->quote($_POST['pass'])));
            echo "OK!3";
        }
    }
    ?>
</div>
<?php include_once "footer.php"; ?>
</body>
</html>