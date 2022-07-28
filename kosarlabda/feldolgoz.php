<?php

$hazai       = [];
$idegen      = [];
$hazai_pont  = [];
$idegen_pont = [];
$helyszin    = [];
$idopont     = [];
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
    global $hazai;
    global $idegen;
    global $hazai_pont;
    global $idegen_pont;
    global $helyszin;
    global $idopont;

    $arrayOfLines = darabol($file);

    for ($i = 1; $i < count($arrayOfLines); $i++) {
        $hazai[]       = $arrayOfLines[$i][0];
        $idegen[]      = $arrayOfLines[$i][1];
        $hazai_pont[]  = $arrayOfLines[$i][2];
        $idegen_pont[] = $arrayOfLines[$i][3];
        $helyszin[]    = $arrayOfLines[$i][4];
        $idopont[]     = $arrayOfLines[$i][5];
    }
}

// 3. feladat
function feladat3()
{
    global $hazai;
    global $idegen;

    $otthon_jatszott    = 0;
    $idegenben_jatszott = 0;

    for ($i = 0; $i < count($hazai); $i++) {
        if ($hazai[$i] == 'Real Madrid') {
            $otthon_jatszott++;
        } elseif ($idegen[$i] == 'Real Madrid') {
            $idegenben_jatszott++;
        }
    }
    echo '<h4>A Real Madrid mennyi mérkőzést játszott hazai, illetve idegen csapatként</h4>';
    echo 'Otthon jatszott: <b>' . $otthon_jatszott . '</b> alkalommal. Idegenben játszott: <b>' . $idegenben_jatszott . '</b> alkalommal';
}

// 4. feladat
function feladat4()
{
    global $hazai_pont;
    global $idegen_pont;
    $dontetelen = 0;

    for ($i = 0; $i < count($hazai_pont); $i++) {
        if ($hazai_pont[$i] == $idegen_pont[$i]) {
            $dontetelen++;
        }
    }
    echo '<h4>Volt-e döntetlen mérkőzés?</h4>';

    if ($dontetelen === 0) {
        echo 'Nem született döntetlen eredmény';
    } else {
        echo 'Igen, játszott döntetlent';
    }
}

// 5. feladat
function feladat5()
{
    global $idegen;

    for ($i = 0; $i < count($idegen); $i++) {
        if (strpos($idegen[$i], "Barcelona") !== false) {
            echo 'A barcelonai csapat teljes neve: <b>' . $idegen[$i] . '</b>';
            break;
        }
    }
}

// 6. feladat
function feladat6()
{
    global $hazai;
    global $idegen;
    global $hazai_pont;
    global $idegen_pont;    
    global $idopont;
    
    $fejlec = ['Hazai csapat', 'Vendég csapat', 'Eredmény'];

    echo '<h4>2004. november 2I-én mely csapatok játszottak mérkőzéseket, és milyen eredmény született?</h4>';
    echo "<table><tr>";
    for ($j = 0; $j < count($fejlec); $j++) {
        echo ('<th>' . $fejlec[$j] . '</th>');
    };
    echo "</tr>";
    for ($i = 0; $i < count($idopont); $i++) {
        if($idopont[$i] =='2004-11-27'){
            echo "<tr>";
            echo "<td>" . $hazai[$i] . "</td>";
            echo "<td>" . $idegen[$i] . "</td>";
            echo "<td>" . $hazai_pont[$i].' : '.$idegen_pont[$i] . "</td>";
            echo "</tr>";
        }        
    }
    echo "</table>";

}


