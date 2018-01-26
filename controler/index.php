<?php
//On démarre la session
session_start();
//On inclut le logo du site et le menu
/*if ($_POST['email'] != NULL) {
    include '../view/vue_Accueil.php';
    include_once '../model/DBO.php';
    $test = new DBO("base_tp",'127.0.0.1', 'phpmadmin', '080176');
    $test->connect();
    var_dump($test->userAdd($_POST['pseu']));
}*/
if(!empty($_SESSION['auth'])) {

    if ($_GET['p'] == NULL) {
        include '../view/vue_account.php';
    } elseif ($_GET['p'] == "search") {
        include '../view/vue_search.php';
    } elseif ($_GET['p'] == "account") {
        include '../view/vue_account.php';
    } elseif ($_GET['p'] == "aboutus") {
        include '../view/vue_aboutus.php';
    }
    elseif ($_GET['p'] == "disconect") {
        session_destroy();
        header('Location: http://127.0.0.1/my_meetic/controler/index.php?p=home');
    }

}

else {
    var_dump($_SESSION['auth']);
    if ($_GET['p'] == "home") {
        include '../view/vue_Accueil.php';
    } elseif ($_GET['p'] == "subscribe") {
        include '../view/vue_subscribe.php';
    } elseif ($_GET['p'] == "connect") {
        include '../view/vue_connect.php';
    } elseif ($_GET['p'] == "aboutus") {
        include '../view/vue_aboutus.php';
    }
}
//include 'view/test.php';
//On inclut le contrôleur s'il existe et s'il est spécifié
/*if (!empty($_GET['page']) && is_file('controleurs/'.$_GET['page'].'.php'))
{
    include 'controler/'.$_GET['page'].'.php';
}
else
{
    include 'controler/test.php';
}*/
//On inclut le pied de page
//include 'view/test.php';
//On ferme la connexion à MySQL

?>