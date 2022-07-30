<?php
class Queries
{
    private $mysql;
    public function __construct()
    {
        if (file_exists('config.php')) {
            require_once('config.php');
        } else {
            //dobunk egy hibát throw new Exception();
        }
    }

    public function feladat3()
    {
        require('./config.php');
        $mysql = $this->getConnect();
        $db = $dbname;
        $osszes = [];

        $query1 = "SELECT COUNT(*) AS 'osszes' FROM `$db`.`balkezes`;";

        $result = mysqli_query($mysql, $query1);
        while ($row = mysqli_fetch_array($result)) {
            $osszes[] = $row["osszes"];
        }

        return $osszes;
    }

    public function feladat4()
    {
        require('./config.php');
        $mysql = $this->getConnect();
        $db = $dbname;

        $query = "SELECT nev, magas FROM `$db`.`balkezes` WHERE utolso BETWEEN '1999-10-01' AND '1999-10-31';";

        $egal = mysqli_query($mysql, $query);

        // Táblázat
        $fejlec = ['Játékos neve', 'Magassága'];
        echo "<table><tr>";
        for ($j = 0; $j < count($fejlec); $j++) {
            echo ('<th>' . $fejlec[$j] . '</th>');
        };
        echo "</tr>";

        while ($row = mysqli_fetch_array($egal)) {
            echo "<tr>";
            echo "<td>" . $row["nev"] . "</td>";
            echo "<td>" . number_format(((int)$row["magas"] * 2.54), 1, ',', '') . " cm</td>";
            echo "</tr>";
        }
        echo "</table>";
    }

    public function feladat6($evszam)
    {
        require('./config.php');
        $mysql = $this->getConnect();
        $db = $dbname;
        $ev = $evszam;
        echo 'A választott év: <b>' . $ev . '</b><br>';
        echo '<br>';

        $query = "SELECT AVG(suly) AS 'atlag' FROM `$db`.`balkezes` WHERE YEAR(elso) <= '$ev' AND YEAR(utolso) >= '$ev';";

        $atlagsuly = [];

        $result = mysqli_query($mysql, $query);
        while ($row = mysqli_fetch_array($result)) {
            $atlagsuly[] = number_format($row["atlag"], 2, ',', '');
            $atlagsuly[] = number_format((0.45359237 * $row["atlag"]), 2, ',', '');
        }

        echo 'Az ebben az évben pályára lépő versenyzők átlagsúlya: <br>';
        echo '<b>' . $atlagsuly[0] . ' </b>font, vagyis <b>' . $atlagsuly[1] . '</b> kilogramm';

        $this->close();
    }
    

    private function getConnect()
    {
        if ($this->mysql !== NULL) {
            return $this->mysql;
        } else {
            require('./config.php');

            mysqli_report(MYSQLI_REPORT_OFF);
            $connect = @mysqli_connect($servername, $username, $password, $dbname);

            if (!$connect) {
                die("Kapcsolódás sikertelen: " . mysqli_connect_error());
            }
            //echo '<h4 style="text-align:center;color:maroon;">Sikeres a kapcsolat !</h4>';
            return $connect;
        }
    }

    private function close()
    {
        if ($this->mysql !== NULL) {
            $this->mysql->close();
        }
    }
}

if (isset($_GET["evszam"])) {
    $evszam = (int)$_GET["evszam"]; //$_GET["evszam"]; 
    if ($evszam < 1990 || 1999 < $evszam) {
        echo 'A <b>' . $evszam . '</b>  Hibás adat! Kérek egy 1990 és 1999 közötti évszámot ';
    } else {
        $lekerdez = new Queries();
        $feladat6 = $lekerdez->feladat6($evszam);
    }
}
