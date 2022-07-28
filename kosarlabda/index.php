<?php

require_once('feldolgoz.php');
?>

<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spanyol kosárlabda</title>
    <style>
        body {
            background-color: maroon;
            font-family: 'Lucida Sans', sans-serif;
            text-align: center;
        }

        h3, h4{
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
        <h2>A spanyol ACB Liga 2004 - 2005-ös idényének mérkőzései</h2>
        <div class="card">
            <h3>3. feladat</h3>
            <?php
            insert_arrays('eredmenyek.csv');
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
            <?php
            feladat5();
            ?>
        </div>

        <div class="card">
        <h3>6. feladat</h3>
            <?php
            feladat6();
            ?>
        </div>
    </main>
</body>

</html>