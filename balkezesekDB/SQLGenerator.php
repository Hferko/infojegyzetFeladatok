<?php
require_once './FileHandler.php';

class SQLGenerator
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

    public function insert_arrays($table, $fieldArray)
    {
        require('./config.php');
        $mysql = $this->getConnect();
        $row = $this->verify('id', $table);

        if ($row != NULL) {
            echo "<p>A kosárlabdások táblája már feltöltve, használatra kész.</p>";
        } else {

            $fileHandler = new FileHandler('balkezesek.csv');
            $resultArray = $fileHandler->beolvas();

            $sql = "INSERT INTO `$dbname`.`$table` (
                `$fieldArray[0]`,
                `$fieldArray[1]`, 
                `$fieldArray[2]`, 
                `$fieldArray[3]`, 
                `$fieldArray[4]`) VALUES (?, ?, ?, ?, ?) ;";               

            if ($stmt = mysqli_prepare($mysql, $sql)) {

                mysqli_stmt_bind_param($stmt, "sssii", $one, $two, $three, $four, $five);

                for ($i = 0; $i < count($resultArray); $i++) {
                    $one   = $resultArray[$i][0];
                    $two   = $resultArray[$i][1];
                    $three = $resultArray[$i][2];
                    $four  = $resultArray[$i][3];
                    $five  = $resultArray[$i][4];                   
                    mysqli_stmt_execute($stmt);
                }
                echo '<p>Balkezesek feltöltve</p>';
            } else {
                echo "Hibás adatbevitel: " . $sql . "<br>" . mysqli_error($mysql) . "<br>";
            }
            mysqli_stmt_close($stmt);
            $this->close();           
        }
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

    // Ellenőrzi, hogy az adott táblában (paraméterként átadva) van-e már adat (sor)
    private function verify($ident, $tabla)
    {
        require('./config.php');
        $mysql = $this->getConnect();
        $db = $dbname;

        $ellenor = "SELECT `$ident` FROM `$db`.$tabla;";
        $eredmeny = mysqli_query($mysql, $ellenor);
        $sor = mysqli_fetch_array($eredmeny);

        return $sor;
    }
}

/*
$fejlec = ['hazai', 'idegen', 'hazai_pont', 'idegen_pont', 'helyszin', 'idopont'];
$insert = new SQLGenerator();
$resultArray = $insert->insert_arrays('kosarlabda', $fejlec); */
