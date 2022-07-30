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
        $games = [];

        $query1 = "SELECT COUNT(hazai) AS 'Otthon játszott' FROM `$db`.`kosarlabda` WHERE hazai = 'Real Madrid';";

        $hazai = mysqli_query($mysql, $query1);
        while ($row = mysqli_fetch_array($hazai)) {
            $games[] = $row["Otthon játszott"];
        }

        $query2 = "SELECT COUNT(idegen) AS 'Idegenben játszot' FROM `kosarlabda` WHERE idegen = 'Real Madrid';";

        $idegen = mysqli_query($mysql, $query2);
        while ($row = mysqli_fetch_array($idegen)) {
            $games[] = $row["Idegenben játszot"];
        }       
        return $games;
    }

    public function feladat4()
    {
        require('./config.php');
        $mysql = $this->getConnect();
        $db = $dbname;
        $query = "SELECT COUNT(id) AS 'egal' FROM `$db`.`kosarlabda` WHERE hazai_pont = idegen_pont;";

        $egal = mysqli_query($mysql, $query);

        while ($row = mysqli_fetch_array($egal)) {
            if ((int)$row["egal"] === 0) {
                echo 'Nem született döntetlen eredmény';
            } else {
                echo 'A szezonban ' . $row["egal"] . ' döntetlen eredmény született.';
            }
        }
    }

    public function feladat5()
    {
        require('./config.php');
        $mysql = $this->getConnect();
        $db = $dbname;
        $query = "SELECT hazai FROM `$db`.`kosarlabda` WHERE hazai LIKE '%Barcelona%' LIMIT 1;";
        $barca = mysqli_query($mysql, $query);

        while ($row = mysqli_fetch_array($barca)) {
            echo 'A barcelonai csapat teljes neve: <b> '.$row["hazai"] . '</b>';            
        }
        
    }

    public function feladat6()
    {
        require('./config.php');
        $mysql = $this->getConnect();
        $db = $dbname;
        $query = "SELECT hazai, idegen, hazai_pont, idegen_pont FROM `$db`.`kosarlabda` WHERE idopont = '2004-11-21';";
        $result = mysqli_query($mysql, $query);

        // Táblázat
        $fejlec = ['Hazai csapat', 'Vendég csapat', 'Eredmény'];

        echo "<table><tr>";
        for ($j = 0; $j < count($fejlec); $j++) {
            echo ('<th>' . $fejlec[$j] . '</th>');
        };
        echo "</tr>";
        while ($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<td>" . $row["hazai"] . "</td>";
            echo "<td>" . $row["idegen"] . "</td>";
            echo "<td>" . $row["hazai_pont"] . ' : ' . $row["idegen_pont"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }

    public function feladat7()
    {
        require('./config.php');
        $mysql = $this->getConnect();
        $db = $dbname;
        $query2 = "SELECT helyszin, COUNT(helyszin)AS 'games' FROM `$db`.`kosarlabda` GROUP BY helyszin HAVING COUNT(helyszin)>20 ORDER BY `games` DESC;";
        $result2 = mysqli_query($mysql, $query2);

        // Táblázat
        $fejlec = ['Stadion neve', 'Mérkőzések száma'];
        echo "<table><tr>";
        for ($x = 0; $x < count($fejlec); $x++) {
            echo ('<th>' . $fejlec[$x] . '</th>');
        };
        echo "</tr>";
        while ($row = mysqli_fetch_array($result2)) {
            echo "<tr>";
            echo "<td>" . $row["helyszin"] . "</td>";
            echo "<td>" . $row["games"] . "</td>";            
            echo "</tr>";
        }
        echo "</table>";

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
