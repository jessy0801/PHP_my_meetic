<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="../jQuery/jquery.min.js"></script>
    <link rel="stylesheet" href="../Bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles.css">
    <title>My Meetic - Mon compte</title>
</head>
<body>
<?php include_once "header.php";
include_once "../model/DBO.php";
$bd = new DBO('my_meetic', '127.0.0.1', 'root', '080176');
$bd->connect();
echo "<div>";
if ($bd->userConnect() == 0){
    echo "OK";
}
else {
    echo 'NO ';
}
echo "</div>";?>
<aside>
    <nav>
        <a href="../controler/index.php?p=emailchg">Changer email</a>
        <a href="../controler/index.php?p=passwd">Changer Mot de passe</a>
        <a href="../controler/index.php?p="></a>
        <a href="../controler/index.php?p="></a>
        <a href="../controler/index.php?p="></a>
    </nav>
</aside>
<section>
    <article><h4>Mon Compte</h4>
        <ul>
            <?php $arr = $bd->query("SELECT * FROM members m INNER JOIN villes_france_free v on v.ville_id = m.id_ville WHERE email = ".$_SESSION['auth']." ");
            foreach ($arr as $val) {
                echo '<li>Pseudo : '.$val['pseudo'].'</li>';
                echo '<li>Nom : '.$val['nom'].'</li>';
                echo '<li>Prenom : '.$val['prenom'].'</li>';
                echo '<li>Email : '.$val['email'].'</li>';
                echo '<li>Ville : '.$val['ville_nom'].'</li>';
            }
            ?>
        </ul>
    </article>
</section>
<?php include_once "footer.php" ?>

</body>
</html>