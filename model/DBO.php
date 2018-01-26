<?php
class DBO
{
    private $dbname, $dbhost, $dbuser, $dbpass, $db, $pseudo, $email, $password, $prenom, $nom, $dateofbirth, $id_ville, $sexe;
    function __construct($_dbname, $_dbhost, $_dbuser, $_dbpass)
    {
        $this->dbname = htmlspecialchars($_dbname);
        $this->dbhost = htmlspecialchars($_dbhost);
        $this->dbuser = htmlspecialchars($_dbuser);
        $this->dbpass = htmlspecialchars($_dbpass);
    }
    public function connect()
    {
        try {
            $this->db = new PDO('mysql:dbname='.$this->dbname.';host='.$this->dbhost, $this->dbuser, $this->dbpass);
        }
        catch (Exception $e) {
            echo 'Exception reu : '.$e->getMessage()."\n";
            return 1;
        }
        return 0;
    }
    public function query($text) {
        if (is_object($this->db)) {
            $_bd = $this->db;
            //$text = $_bd->quote($text);
            return $_bd->query($text)->fetchall();
        }
        else {
            echo "BD non connecter !";
            return 1;
        }
    }
    public function userAdd($_pseudo, $_prenom, $_nom, $_dateofbirth, $_id_ville, $_sexe, $_email, $_password) {
        $_bd = $this->db;
        $this->pseudo = $_bd->quote($_pseudo);
        $this->password = $_bd->quote($_password);
        $this->email = $_bd->quote($_email);
        $this->prenom = $_bd->quote($_prenom);
        $this->nom = $_bd->quote($_nom);
        $this->dateofbirth = $_bd->quote($_dateofbirth);
        $this->id_ville = intval($_id_ville);
        $this->sexe = intval($_sexe);
//        $this->activation_key = $_activation_key; //???????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????
        if (is_object($this->db)) {
            $_bd = $this->db;
            try {
                echo "try";
                $tmp = $_bd->exec('INSERT INTO members (pseudo, nom, prenom, date_naissance, sexe, id_ville, email, password) VALUES ('.$this->pseudo.', '.$this->nom.', '.$this->prenom.', '.$this->dateofbirth.', '.$this->sexe.', '.$this->id_ville.', '.$this->email.', '.$this->password.');');
                echo 'INSERT INTO members (pseudo, nom, prenom, date_naissance, sexe, id_ville, email, password) VALUES ('.$this->pseudo.', '.$this->nom.', '.$this->prenom.', '.$this->dateofbirth.', '.$this->sexe.', '.$this->id_ville.', '.$this->email.', '.$this->password.');';

            } catch (Exception $e) {
                echo "PB userAdd -> ".$e->getMessage()."\n";
                return 1;
            }
            return 0;
        }
        else {
            echo "BD non connecter !\n";
            return 1;
        }
    }
    public function userExist($_pseudo, $_email) {
        if (is_object($this->db)) {
            $_bd = $this->db;
            $_email = $_bd->quote($_email);
            $_pseudo = $_bd->quote($_pseudo);
            try {
                $query = $_bd->query('SELECT * FROM members WHERE email = '.$_email.' OR pseudo = '.$_pseudo.' ');
            } catch (Exception $e) {
                echo "PB userExist -> ".$e->getMessage()."\n";
                return 1;
            }
            if(count($query->fetchall()) < 1) {
                return 0;
            }
            else {
                return 2;
            }

        }
        else {
            echo "BD non connecter !\n";
            return 1;
        }
    }
    public function userAuth($_user = NULL, $_pass = NULL)
    {
        if($_SESSION['auth'] != NULL) {
            echo $_SESSION['auth'];
        }
    }
    public function userConnect($_email = NULL, $_password = NULL) {
        $_bd = $this->db;
        if ($_email == NULL && $_password == NULL && $_SESSION['auth'] != NULL) {
            $_email = $_SESSION['auth'];
            $_password = $_SESSION['user'];
        }
        else {
            $_email = $_bd->quote($_email);
            $_password = $_bd->quote($_password);
        }
        $reponse_login = $_bd->query('SELECT email FROM members WHERE email = '.$_email.' ');
        if ($reponse_login->fetchColumn() == false) {
            return 1;
        }
        else {
            $reponse_pass = $_bd->query('SELECT password FROM members WHERE email = '.$_email.' ');
            $arr = $reponse_pass->fetch();
            if (hash_equals($arr['password'], crypt($_password, $arr['password']))) {
                $_SESSION['auth'] = $_email;
                $_SESSION['user'] = $_password;
                return 0;
            }
            else {
                var_dump(hash_equals($arr['password'], crypt($_password, $arr['password'])));
                return 1;
            }

        }

    }
    public function toIdville($_ville) {
        if (is_object($this->db)) {
            $_bd = $this->db;
            $_ville = $_bd->quote($_ville);
            var_dump($_ville);
            try {
                $query = $_bd->query('SELECT ville_id FROM villes_france_free WHERE ville_nom = '.$_ville);
            } catch (Exception $e) {
                echo "PB toIdville -> ".$e->getMessage()."\n";
                return 1;
            }
            $resul = $query->fetch();
            if (count($resul) >= 1) {
                return $resul['ville_id'];
            }
            else {
                echo "Ville : ".$_ville." Introuvable";
                return 1;
            }

        }
        else {
            echo "BD non connecter !\n";
            return 1;
        }
    }
    public function quote($str) {
        if (is_object($this->db)) {
            $_bd = $this->db;
            $str = $_bd->quote($str);
            return $str;
        }
        else {
            echo "BD non connecter !\n";
            return 1;
        }
    }

    /**
     * @return mixed
     */
    public function userSearch($_homme, $_femme, $_autres, $cpostal)
    {
        $bd = $this->db;
        $i = 0;
        if ($_homme && $_femme && $_autres) {


            $tb = '<table>
    <tr>
        <th>Nom</th>
        <th>Prenom</th>
        <th>Email</th>
        <th>Code Postal</th>
        <th colspan="2">Avis</th>
    </tr>';
            //$cpostal = $bd->quote(htmlspecialchars($_cpostal));
            $arr = $bd->query('select * from members m INNER JOIN villes_france_free v on v.ville_id = m.id_ville WHERE (ville_code_postal = '.$cpostal.' ) ');
            foreach ($arr->fetchall() as $bdi) {
                $i++;
                $tb .= '<tr>';
                $tb .= '<td>' . ucfirst(strtolower($bdi['nom'])) . '</td>';
                $tb .= '<td>' . ucfirst(strtolower($bdi['prenom'])) . '</td>';
                $tb .= '<td>' . $bdi['email'] . '</td>';
                $tb .= '<td>' . $bdi['ville_nom'] . '</td>';
                $tb .= '<td><a href="vue_account.php?id_membre=' . $bdi['id'] . '" >Voir profil</a></td>';
                $tb .= '<td><a href="vue_account.php?id_membre=' . $bdi['id'] . '" >Envoyer un message</a></td>';
                $tb .= '</tr>';
            }
            $tb .= '</table>';
            if ($i >= 1) {
                return $tb;
            } else {
                return "<span>Aucun Resultat</span>";
            }
        }
        elseif (!$_homme && $_femme && $_autres) {
            $tb = '<table>
    <tr>
        <th>Nom</th>
        <th>Prenom</th>
        <th>Email</th>
        <th>Code Postal</th>
        <th colspan="2">Avis</th>
    </tr>';
            $cpostal = $bd->quote(htmlspecialchars_decode($_POST['cpostal']));
            $arr = $bd->query('select * from members m INNER JOIN villes_france_free v on v.ville_id = m.id_ville WHERE (ville_code_postal = '.$cpostal.' ) AND (sexe = 2 OR sexe = 3)');
            foreach ($arr->fetchall() as $bdi) {
                $i++;
                $tb .= '<tr>';
                $tb .= '<td>' . ucfirst(strtolower($bdi['nom'])) . '</td>';
                $tb .= '<td>' . ucfirst(strtolower($bdi['prenom'])) . '</td>';
                $tb .= '<td>' . $bdi['email'] . '</td>';
                $tb .= '<td>' . $bdi['cpostal'] . '</td>';
                $tb .= '<td><a href="vue_account.php?id_membre=' . $bdi['id'] . '" >Voir profil</a></td>';
                $tb .= '<td><a href="vue_account.php?id_membre=' . $bdi['id'] . '" >Envoyer un message</a></td>';
                $tb .= '</tr>';
            }
            $tb .= '</table>';
            if ($i >= 1) {
                return $tb;
            } else {
                return "<span>Aucun Resultat</span>";
            }
        }

        elseif (!$_homme && !$_femme && $_autres) {
            $tb = '<table>
    <tr>
        <th>Nom</th>
        <th>Prenom</th>
        <th>Email</th>
        <th>Code Postal</th>
        <th colspan="2">Avis</th>
    </tr>';
            $cpostal = $bd->quote(htmlspecialchars_decode($_POST['cpostal']));
            $arr = $bd->query('select * from members m INNER JOIN villes_france_free v on v.ville_id = m.id_ville WHERE (ville_code_postal = '.$cpostal.' ) AND (sexe = 3)');
            foreach ($arr->fetchall() as $bdi) {
                $i++;
                $tb .= '<tr>';
                $tb .= '<td>' . ucfirst(strtolower($bdi['nom'])) . '</td>';
                $tb .= '<td>' . ucfirst(strtolower($bdi['prenom'])) . '</td>';
                $tb .= '<td>' . $bdi['email'] . '</td>';
                $tb .= '<td>' . $bdi['cpostal'] . '</td>';
                $tb .= '<td><a href="vue_account.php?id_membre=' . $bdi['id'] . '" >Voir profil</a></td>';
                $tb .= '<td><a href="vue_account.php?id_membre=' . $bdi['id'] . '" >Envoyer un message</a></td>';
                $tb .= '</tr>';
            }
            $tb .= '</table>';
            if ($i >= 1) {
                return $tb;
            } else {
                return "<span>Aucun Resultat</span>";
            }
        }
        elseif (!$_homme && $_femme && !$_autres) {
            $tb = '<table>
    <tr>
        <th>Nom</th>
        <th>Prenom</th>
        <th>Email</th>
        <th>Code Postal</th>
        <th colspan="2">Avis</th>
    </tr>';
            //$cpostal = $bd->quote(htmlspecialchars_decode($_POST['cpostal']));
            $arr = $bd->query('select * from members m INNER JOIN villes_france_free v on v.ville_id = m.id_ville WHERE (ville_code_postal = '.$cpostal.') AND (sexe = 2) ');
            foreach ($arr->fetchall() as $bdi) {
                $i++;
                $tb .= '<tr>';
                $tb .= '<td>' . ucfirst(strtolower($bdi['nom'])) . '</td>';
                $tb .= '<td>' . ucfirst(strtolower($bdi['prenom'])) . '</td>';
                $tb .= '<td>' . $bdi['email'] . '</td>';
                $tb .= '<td>' . $bdi['cpostal'] . '</td>';
                $tb .= '<td><a href="vue_account.php?id_membre=' . $bdi['id'] . '" >Voir profil</a></td>';
                $tb .= '<td><a href="vue_account.php?id_membre=' . $bdi['id'] . '" >Envoyer un message</a></td>';
                $tb .= '</tr>';
            }
            $tb .= '</table>';
            if ($i >= 1) {
                return $tb;
            } else {
                return "<span>Aucun Resultat</span>";
            }
        }
        elseif ($_homme && !$_femme && $_autres) {
            $tb = '<table>
    <tr>
        <th>Nom</th>
        <th>Prenom</th>
        <th>Email</th>
        <th>Code Postal</th>
        <th colspan="2">Avis</th>
    </tr>';
            $cpostal = $bd->quote(htmlspecialchars_decode($_POST['cpostal']));
            $arr = $bd->query('select * from members m INNER JOIN villes_france_free v on v.ville_id = m.id_ville WHERE (ville_code_postal = '.$cpostal.') AND (sexe = 1 OR sexe = 3) ');
            foreach ($arr->fetchall() as $bdi) {
                $i++;
        $tb .= '<tr>';
        $tb .= '<td>' . ucfirst(strtolower($bdi['nom'])) . '</td>';
        $tb .= '<td>' . ucfirst(strtolower($bdi['prenom'])) . '</td>';
        $tb .= '<td>' . $bdi['email'] . '</td>';
        $tb .= '<td>' . $bdi['cpostal'] . '</td>';
        $tb .= '<td><a href="vue_account.php?id_membre=' . $bdi['id'] . '" >Voir profil</a></td>';
        $tb .= '<td><a href="vue_account.php?id_membre=' . $bdi['id'] . '" >Envoyer un message</a></td>';
        $tb .= '</tr>';
    }
            $tb .= '</table>';
            if ($i >= 1) {
                return $tb;
            } else {
                return "<span>Aucun Resultat</span>";
            }
        }
        else {
            $tb = '<table>
    <tr>
        <th>Photo</th>
        <th>Nom</th>
        <th>Prenom</th>
        <th>Email</th>
        <th>Code Postal</th>
        <th colspan="2">Avis</th>
    </tr>';
            $cpostal = $bd->quote(htmlspecialchars_decode($_POST['cpostal']));
            $arr = $bd->query('select * from members m INNER JOIN villes_france_free v on v.ville_id = m.id_ville WHERE (ville_code_postal = '.$cpostal.' ) AND (sexe = 1)');
            foreach ($arr->fetchall() as $bdi) {
                $i++;
                $tb .= '<tr>';
                $tb .= '<td>' . ucfirst(strtolower($bdi['nom'])) . '</td>';
                $tb .= '<td>' . ucfirst(strtolower($bdi['prenom'])) . '</td>';
                $tb .= '<td>' . $bdi['email'] . '</td>';
                $tb .= '<td>' . $bdi['ville_nom'] . '</td>';
                $tb .= '<td><a href="vue_account.php?id_membre=' . $bdi['id'] . '" >Voir profil</a></td>';
                $tb .= '<td><a href="vue_account.php?id_membre=' . $bdi['id'] . '" >Envoyer un message</a></td>';
                $tb .= '</tr>';
            }
            $tb .= '</table>';
            if ($i >= 1) {
                return $tb;
            } else {
                return "<span>Aucun Resultat</span>";
            }
        }
    }

    /**
     * @return mixed
     */
    public function userLast()
    {
        if (is_object($this->db)) {
            $_bd = $this->db;
            $arr = $_bd->query('SELECT pseudo, date_inscription FROM members ORDER BY date_inscription DESC LIMIT 10');
            return $arr->fetchall();
        }
        else {
            echo "BDD non connecter !\n";
            return 1;
        }

    }
    public function get_distance_m($lat1, $lng1, $lat2, $lng2) {
        $earth_radius = 6378137;   // Terre = sphère de 6378km de rayon
        $rlo1 = deg2rad($lng1);
        $rla1 = deg2rad($lat1);
        $rlo2 = deg2rad($lng2);
        $rla2 = deg2rad($lat2);
        $dlo = ($rlo2 - $rlo1) / 2;
        $dla = ($rla2 - $rla1) / 2;
        $a = (sin($dla) * sin($dla)) + cos($rla1) * cos($rla2) * (sin($dlo) * sin($dlo
                ));
        $d = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return ($earth_radius * $d);
    }

}