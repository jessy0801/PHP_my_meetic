<?php
echo '<footer class="navbar navbar-inverse" style="bottom: 0; width: 100%">
<nav><div class="container-fluid">
        <ul id="nav" class="nav navbar-nav">
            <li><a href="../controler/index.php?p=subscribe">Home</a></li>
            <li><a href="../controler/index.php?p=subscribe">Inscription</a></li>
            <li><a href="../controler/index.php?p=connect">Connextion</a></li>
            <li><a href="../controler/index.php?p=aboutus">Contacter-nous</a></li>
        </ul>
        <script>
            var li = $("li");
            li.hover(function() {this.setAttribute("class", "active");});
            li.mouseout(function() {this.setAttribute("class", "");});
        </script>
    </div></nav>
</footer>';
?>