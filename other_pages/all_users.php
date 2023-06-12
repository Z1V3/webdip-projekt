<?php
$putanja = dirname(dirname($_SERVER['REQUEST_URI']));

if ($putanja == "/azivko") {
    $putanja = "/azivko/webdip_projekt";
}
require "../php/functions.php";

$veza = new Baza();
$veza->spojiDB();

$upit = "SELECT * FROM korisnik WHERE korisnicko_ime = '{$_SESSION["korisnik"]}'";
$rezultat = $veza->selectDB($upit);
$korisnik_id;
while ($red = mysqli_fetch_array($rezultat)) {
    if ($red) {
        $korisnik_id = $red["korisnik_id"];
    }
}

if (isset($_GET["blokiraj"])) {
    zapisiDnevnik(10, $korisnik_id, $_GET["blokiraj"]);
    $upit = "UPDATE korisnik SET blokiran = 1 WHERE korisnik_id = {$_GET["blokiraj"]}";
    $rezultat = $veza->selectDB($upit);
}
if (isset($_GET["odblokiraj"])) {
    zapisiDnevnik(11, $korisnik_id, $_GET["odblokiraj"]);
    $upit = "UPDATE korisnik SET blokiran = 0 WHERE korisnik_id = {$_GET["odblokiraj"]}";
    $rezultat = $veza->selectDB($upit);
}
if (isset($_GET["moderiraj"])) {
    zapisiDnevnik(9, $korisnik_id, $_GET["moderiraj"]);
    $upit = "UPDATE korisnik SET tip_korisnika_id = 3 WHERE korisnik_id = {$_GET["moderiraj"]}";
    $rezultat = $veza->selectDB($upit);
}
if (isset($_GET["demoderiraj"])) {
    $upit = "UPDATE korisnik SET tip_korisnika_id = 2 WHERE korisnik_id = {$_GET["demoderiraj"]}";
    $rezultat = $veza->selectDB($upit);
}
$upit = "SELECT * FROM korisnik";
$rezultat = $veza->selectDB($upit);

$data = array();
if ($rezultat->num_rows > 0) {
    while ($red = mysqli_fetch_array($rezultat)) {
        $data[] = $red;
    }
}

$veza->zatvoriDB();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Intelektualno vlasnistvo</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../css/content.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
        <link href="https://fonts.cdnfonts.com/css/bahnschrift" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
        <script src="../js/ajax.js"></script>
        <style>
            html,body,h1,h2,h3,h4 {
                font-family:"Bahnschrift"
            }

            html,
            body {
                height: 100%;
                margin: 0;
                background: #1e202b;
                font-family: sans-serif;

            }

            .container {
                position: absolute;
                top: 30%;
                left: 20%;
            }

            table {
                height: 100%;
                width: 100%;
                border-collapse: collapse;
                overflow: hidden;
                box-shadow: 0 0 20px rgba(0,0,0,0.1);
            }

            th,
            td {
                padding: 15px;
                background-color: rgba(255,255,255,0.2);
                color: #fff;
            }

            th {
                text-align: left;
            }

            thead {
                th {
                    background-color: #55608f;
                }
            }

            tbody {
                tr {
                    &:hover {
                        background-color: rgba(255,255,255,0.3);
                    }
                }
                td {
                    position: relative;
                    &:hover {
                        &:before {
                            content: "";
                            position: absolute;
                            left: 0;
                            right: 0;
                            top: -9999px;
                            bottom: -9999px;
                            background-color: rgba(255,255,255,0.2);
                            z-index: -1;
                        }
                    }
                }
            }



            .panel{
                position: absolute;
                top: 10%;
                left: 37%;
            }
            h3,p,span {
                color: black;
            }
            h3,span {
                font-size: 30px;
            }
            .background{
                position: fixed;
                z-index: 0;
                width: 1080px;
                left: 0%;
                top: 0%;
            }
            .btn_b{
                border-radius: 10px;
                float: right;
                font-family:"Bahnschrift";
                width: 100px;
                height: 30px;
                font-weight: bold;
                background-color: white;
                margin-bottom: 5px;
            }

        </style>
    </head>
    <body>

        <!-- Menu -->
        <?php
        include "../php/meni.php";
        ?>

        <img src="../multimedia/abstract.jpg" class="background">
        <!-- Content -->
        <div class="content" style="max-width:1100px;margin-top:80px;margin-bottom:80px">

            <div class="panel">
                <h1><b>Intelektualna vlasništva</b></h1>
            </div>
            <div class="container">

                <?php
                if (!empty($data)) {
                    echo "<table id='tablica'>";
                    echo "<thead>";
                    echo "<tr>";
                    if ($_SESSION["uloga"] > 3) {
                        echo "<th>ID</th>";
                    }
                    echo "<th>Korisnicko ime</th>";
                    echo "<th>Ime</th>";
                    echo "<th>Prezime</th>";
                    if ($_SESSION["uloga"] > 3) {
                        echo "<th>Email</th>";
                        echo "<th>Uvjeti</th>";
                        echo "<th>Broj neuspjesnih prijava</th>";
                        echo "<th>Blokiran</th>";
                        echo "<th>Aktiviran</th>";
                        echo "<th>Tip korisnika</th>";
                        echo "<th>Opcije</th>";
                    }
                    echo "<tbody>";
                    foreach ($data as $product) {
                        echo "<tr>";
                        if ($_SESSION["uloga"] > 3) {
                            echo "<td>" . $product["korisnik_id"] . "</td>";
                        }
                        echo "<td>" . $product["korisnicko_ime"] . "</td>";
                        echo "<td>" . $product["ime"] . "</td>";
                        echo "<td>" . $product["prezime"] . "</td>";
                        if ($_SESSION["uloga"] > 3) {
                            echo "<td>" . $product["email"] . "</td>";
                            echo "<td>" . $product["uvjeti"] . "</td>";
                            echo "<td>" . $product["broj_neuspjesnih_prijava"] . "</td>";
                            echo "<td>" . $product["blokiran"] . "</td>";
                            echo "<td>" . $product["aktiviran"] . "</td>";
                            echo "<td>" . $product["tip_korisnika_id"] . "</td>";
                        }
                        if ($product["blokiran"] == "0") {
                            echo "<td><a href='" . $_SERVER["PHP_SELF"] . "?blokiraj=" . $product["korisnik_id"] . "'><button class='btn_b' id='{$product["korisnik_id"]}'>Blokiraj</button></a>";
                        } else if ($product["blokiran"] == "1") {
                            echo "<td><a href='" . $_SERVER["PHP_SELF"] . "?odblokiraj=" . $product["korisnik_id"] . "'><button class='btn_b' id='{$product["korisnik_id"]}'>Odblokiraj</button></a>";
                        }
                        if ($product["tip_korisnika_id"] != "3" && $product["tip_korisnika_id"] != "4") {
                            echo "<a href='" . $_SERVER["PHP_SELF"] . "?moderiraj=" . $product["korisnik_id"] . "'><button class='btn_b' id='{$product["korisnik_id"]}'>Moderiraj</button></a>";
                        } else if ($product["tip_korisnika_id"] == "3") {
                            echo "<a href='" . $_SERVER["PHP_SELF"] . "?demoderiraj=" . $product["korisnik_id"] . "'><button class='btn_b' id='{$product["korisnik_id"]}'>Demoderiraj</button></td></a>";
                        } else {
                            echo "</td>";
                        }
                        echo "</tr>";
                    }
                    echo "</tbody>";
                    echo "</table>";
                } else {
                    echo "No data found.";
                }
                ?>
            </div>

        </div>
        <script>

        </script>
    </body>
</html>