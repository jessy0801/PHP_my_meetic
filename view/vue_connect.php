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
    <title>My Meetic - connection</title>
</head>
<body>
    <?php include_once "header.php"; include_once "../model/DBO.php";
    $bd = new DBO('my_meetic', '127.0.0.1', 'root', '080176');
    $bd->connect();?>
    <div class="container-fluid row center-block">
        <div class="col-lg-3">
            <aside>
                <h4>Dernier membre inscrit</h4>
                <table>
                    <tr>
                        <th>Pseudo</th>
                        <th>Date d'inscription</th>
                    </tr>

                    <?php foreach ($bd->userLast() as $val){
                        echo '<tr>';
                        echo "<li>".$val['pseudo'] ."</li>";
                        echo "<li>".$val['date_inscription'] ."</li>";
                        echo '<tr>';
                    } ?>
                </table>
            </aside>
        </div>
        <form class="col-lg-6" style="padding: 11%;" action="../controler/index.php?p=connect" method="post">
            <?php
            if ($_POST['email'] != NULL) {
                $bd = new DBO('my_meetic', '127.0.0.1', 'root', '080176');
                $bd->connect();
                $result = $bd->userConnect($_POST['email'], $_POST['pass']);
                echo $result;
                if ($result == 1) {
                    echo "<span class='center-block text-center'>Email ou mots de passe incorrect</span>";
                } else {
                    echo "of;";
                    header("Location: http://127.0.0.1/my_meetic/controler/index.php?p=account");
                }
            }?>
            <div class="form-group row">
                <label class="col-lg-3" for="email">Email address:</label>
                <div class="col-lg-9"><input type="email" class="form-control" name="email" id="email"></div>
            </div>
            <div class="form-group row">
                <label class="col-lg-3" for="pwd">Password:</label>
                <div class="col-lg-9"><input type="password" class="form-control" name="pass" id="pwd"></div>
            </div>
            <div class="checkbox">
                <label><input type="checkbox"> Remember me</label>
            </div>
            <button type="submit" class="btn btn-default center-block">Submit</button>
        </form>
        <div class="col-lg-3 pull-right">
            <aside>
                <h4>Dernier membre inscrit</h4>
            </aside>
        </div>
    </div>
    <?php

    include_once "footer.php"?>
</body>
</html>