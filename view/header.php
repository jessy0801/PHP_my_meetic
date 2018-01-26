<?php
if($_SESSION['auth'] !=NULL) {
    echo '<header>
<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="../controler/index.php?p=home">My Meetic</a>
        </div>
        <ul id="nav" class="nav navbar-nav">
            <li id="menu" ><a href="../controler/index.php?p=account">Mon compte</a></li>
            <li><a href="../controler/index.php?p=search">Recherche</a></li>
            <li><a href="../controler/index.php?p=disconect">Déconnextion</a></li>
            <li><a href="../controler/index.php?p=aboutus">Contacter-nous</a></li>
        </ul>
        
        
    </div>
</nav>
<div class="nav" style="display: none; position: absolute;margin-left: 77px;margin-top: -22px;height: 100px;" id="menu_content">
        <ul  >
        <li>Changer D\'email</li>
        <li>Changer de mot de passe</li>
        <li>Supprimer votre compte</li>
</ul>
</div>
<script>
            var li = $("li");
            var menucont = $("#menu_content");
            li.hover(function() {this.setAttribute("class", "active");});
            li.mouseout(function() {this.setAttribute("class", "");});
            $("#menu").hover(function() {
                if (menucont.css("display") === "none") {
                  menucont.css("display", "block");
                }
                else {
                    menucont.css("display", "none");
                }
            });
            menucont.hover(function() {
                if (menucont.css("display") === "none") {
                  menucont.css("display", "block");
                }
                else {
                    menucont.css("display", "none");
                }
            });
        </script>
</header>';
}
else {
    echo '<header>
<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="../controler/index.php?p=home">My Meetic</a>
        </div>
        <ul id="nav" class="nav navbar-nav">
            <li><a href="../controler/index.php?p=subscribe">Inscription</a></li>
            <li><a href="../controler/index.php?p=connect">Connextion</a></li>
            <li><a href="../controler/index.php?p=aboutus">Contacter-nous</a></li>
        </ul>
        <script>
            var li = $("li");
            li.hover(function() {this.setAttribute("class", "active");});
            li.mouseout(function() {this.setAttribute("class", "");});
        </script>
    </div>
</nav>
</header>';
}
?>