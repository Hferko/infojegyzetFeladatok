<?php

$nev      = [];
$elso     = [];
$utolso   = [];
$suly     = [];
$magassag = [];

// File beolvasása, darabolása sorokra
function fileBeolvas($allomany)
{
    $lines = file($allomany, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    return $lines;
}

// Sorok feldarabolása a ";" pontos-vessző mentént
function darabol($file)
{
    $lines        = fileBeolvas($file);
    $arrayOfLines = [];

    foreach ($lines as $line) {
        $arrayOfLines[] = explode(';', $line);
    }
    return $arrayOfLines;
}

// A feldarabolt elemek betöltése tömbökbe
function insert_arrays($file)
{
    global $nev;
    global $elso;
    global $utolso;
    global $suly;
    global $magassag;

    $arrayOfLines = darabol($file);

    for ($i = 1; $i < count($arrayOfLines); $i++) {
        $nev[]      = $arrayOfLines[$i][0];
        $elso[]     = $arrayOfLines[$i][1];
        $utolso[]   = $arrayOfLines[$i][2];
        $suly[]     = $arrayOfLines[$i][3];
        $magassag[] = $arrayOfLines[$i][4];
    }
}

// 3. feladat
function feladat3()
{
    echo '<h4>Határozza meg, hogy hány adatsor található a forrásállományban?</h4>';
    global $nev;

    echo 'A balkezesek.csv file-ban: <b>' . count($nev) . '</b>  adatsor található.';
}

// 4. feladat
function feladat4()
{
    echo '<h4>Határozza meg azoknak a játékosoknak a nevét és testmagasságát,<br> akik utoljára 1999 októberében léptek pályára</h4>';

    global $nev;
    global $utolso;
    global $magassag;
    $nev99   = [];
    $magas99 = [];

    for ($i = 0; $i < count($utolso); $i++) {

        if (strpos($utolso[$i], "1999-10-") === 0) {
            $nev99[]   = $nev[$i];
            $magas99[] = number_format(((int)$magassag[$i] * 2.54), 1, ',', '');
        }
    }

    // Táblázat
    $fejlec = ['Játékos neve', 'Magassága'];
    echo "<table><tr>";
    for ($j = 0; $j < count($fejlec); $j++) {
        echo ('<th>' . $fejlec[$j] . '</th>');
    };
    echo "</tr>";
    for ($x = 0; $x < count($nev99); $x++) {
        echo "<tr>";
        echo "<td>" . $nev99[$x] . "</td>";
        echo "<td>" . $magas99[$x] . " cm</td>";
        echo "</tr>";
    }
    echo "</table>";
}

//   6. feladat
if (isset($_GET["evszam"])) {  
    
    $evszam = (int)$_GET["evszam"]; //$_GET["evszam"];   
    
    if ($evszam < 1990 || 1999 < $evszam) {
        echo 'A <b>'.$evszam. '</b>  Hibás adat! Kérek egy 1990 és 1999 közötti évszámot '; 
       
    }
    else{
        $ev = $evszam;
        echo 'A választott év: <b>' . $ev . '</b><br>';
        echo '<br>';
        insert_arrays('balkezesek.csv');
        if ($ev !== 0) {
            $szemelyek = 0;
            $osszSuly = 0;
            for ($i = 0; $i < count($suly); $i++) {
                $first = (int)substr($elso[$i], 0, 4);
                $last  = (int)substr($utolso[$i], 0, 4);
                if ($first < $ev &&  $ev < $last || $first == $ev || $last == $ev) {
                    $osszSuly = $osszSuly + (int)$suly[$i];
                    $szemelyek++;
                    //echo $szemelyek . '. ' .$osszSuly .' -- ' . $nev[$i].'<br>';
                }
            }
            $atlag = number_format(($osszSuly / $szemelyek), 2, ',', '');
            $kilo  = number_format((0.45359237 * ($osszSuly / $szemelyek)), 2, ',', '');
            echo 'Az ebben az évben pályára lépő versenyzők átlagsúlya: <br>';
            echo '<b>' . $atlag . ' </b>font, vagyis <b>' . $kilo . '</b> kilogramm';
        }
    }
    
}
