<?php

require_once('feldolgoz.php');

?>

<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Balkezesek</title>
    <style>
        body {
            background-color: maroon;
            font-family: 'Lucida Sans', sans-serif;
            text-align: center;
        }

        h3,
        h4 {
            color: teal;
        }

        main,
        .card {
            width: 85%;
            padding: 0.5vw;
            background-color: beige;
            margin: 10px auto;
            border: thin solid aqua;
            border-radius: 8px;
            box-shadow: 6px 8px 6px lavender;
        }

        hr {
            width: 60%;
            color: #ddd;
        }

        select {
            padding: 4px 8px;
            font-size: 15px;
        }

        table {
            border-collapse: collapse;
            width: 60%;
            margin: 20px auto;
        }

        th,
        td {
            text-align: center;
            padding: 8px;
            /*border: 1px solid navy;*/
        }

        tr:nth-child(even) {
            background-color: #D6EEEE;
        }

        tr:hover {
            background-color: white;
        }

        th {
            background-color: brown;
            color: white;
        }
    </style>
</head>

<body>
    <main>
        <h2>Balkezes baseball-osok</h2>
        <div class="card">
            <h3>3. feladat</h3>
            <?php
            insert_arrays('balkezesek.csv');
            feladat3();
            ?>
        </div>
        <div class="card">
            <h3>4. feladat</h3>
            <?php
            feladat4();
            ?>
        </div>
        <div class="card">
            <h3>5. feladat</h3>

            <form>
                <h4>Kérem adjon meg egy évszámot 1990 és 1999 között: </h4>

                <select name="evszam" onchange="sportsuly(this.value)">
                    <option value="" selected>Válasszon évszámot:</option>
                    <option value="1989">1989</option>
                    <option value="1990">1990</option>
                    <option value="1991">1991</option>
                    <option value="1992">1992</option>
                    <option value="1993">1993</option>
                    <option value="1994">1994</option>
                    <option value="1995">1995</option>
                    <option value="1996">1996</option>
                    <option value="1997">1997</option>
                    <option value="1998">1998</option>
                    <option value="1999">1999</option>
                    <option value="2000">2000</option>
                </select>
            </form>
            <h3>6. feladat</h3>
            <p id="txtSuly"></p>
            <script>
                function sportsuly(str) {
                    if (str == "") {
                        document.getElementById("txtSuly").innerHTML = "";
                        return;
                    }
                    let xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            document.getElementById("txtSuly").innerHTML = this.responseText;
                        }
                    }
                    xmlhttp.open("GET", "feldolgoz.php?evszam=" + str, true);
                    xmlhttp.send();
                }
            </script>
        </div>

    </main>
</body>

</html>