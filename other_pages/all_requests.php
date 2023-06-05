<?php
$putanja = dirname(dirname($_SERVER['REQUEST_URI']));

if ($putanja == "/azivko") {
    $putanja = "/azivko/webdip_projekt";
}
require "../php/functions.php";

$veza = new Baza();
$veza->spojiDB();

$data = array();

if ($_SESSION["uloga"] === "3") {
    $upit = "SELECT * FROM korisnik WHERE korisnicko_ime = '{$_SESSION["korisnik"]}'";
    $rezultat = $veza->selectDB($upit);
    $user_id;
    while ($red = mysqli_fetch_array($rezultat)) {
        if ($red) {
            $user_id = $red["korisnik_id"];
        }
    }

    $upit = "SELECT * FROM upravlja WHERE korisnik_id = {$user_id}";
    $rezultat = $veza->selectDB($upit);
    $mod_tipovi = array();
    if ($rezultat->num_rows > 0) {
        while ($red = mysqli_fetch_array($rezultat)) {
            $mod_tipovi[] = $red["tip_intelektualnog_vlasnistva_id"];
        }
    }

    foreach ($mod_tipovi as $tip) {
        $upit = "SELECT z.zahtjev_id, z.opis, tz.naziv_tip_zahtjeva, k.korisnicko_ime, s.naziv_status, tiv.naziv_tip_intelektualno_vlasnistvo FROM zahtjev AS z JOIN tip_zahtjeva AS tz ON z.tip_zahtjeva_id = tz.tip_zahtjeva_id JOIN korisnik AS k ON z.korisnik_id = k.korisnik_id JOIN status AS s ON z.status_id = s.status_id JOIN tip_intelektualnog_vlasnistva AS tiv ON z.tip_intelektualnog_vlasnistva_id = tiv.tip_intelektualnog_vlasnistva_id WHERE tiv.tip_intelektualnog_vlasnistva_id = {$tip} AND z.status_id != 2";
        $rezultat = $veza->selectDB($upit);
        if ($rezultat->num_rows > 0) {
            while ($red = mysqli_fetch_array($rezultat)) {
                $data[] = $red;
            }
        }
    }
} else if ($_SESSION["uloga"] === "4") {
    $upit = "SELECT z.zahtjev_id, z.opis, tz.naziv_tip_zahtjeva, k.korisnicko_ime, s.naziv_status, tiv.naziv_tip_intelektualno_vlasnistvo FROM zahtjev AS z JOIN tip_zahtjeva AS tz ON z.tip_zahtjeva_id = tz.tip_zahtjeva_id JOIN korisnik AS k ON z.korisnik_id = k.korisnik_id JOIN status AS s ON z.status_id = s.status_id JOIN tip_intelektualnog_vlasnistva AS tiv ON z.tip_intelektualnog_vlasnistva_id = tiv.tip_intelektualnog_vlasnistva_id WHERE z.status_id != 2";
    $rezultat = $veza->selectDB($upit);
    if ($rezultat->num_rows > 0) {
        while ($red = mysqli_fetch_array($rezultat)) {
            $data[] = $red;
        }
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
                font-weight: 100;
            }

            .container {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
            }

            table {
                width: 800px;
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
            .btn_p{
                font-family:"Bahnschrift";
                width: 100px;
                height: 30px;
                margin-bottom: 5px;
                background-color: lightgreen;
                font-weight: bold;
            }
            .btn_o{
                font-family:"Bahnschrift";
                width: 100px;
                height: 30px;
                background-color: red;
                font-weight: bold;
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
                    echo "<table>";
                    echo "<thead>";
                    echo "<tr>";
                    echo "<th>ID</th>";
                    echo "<th>Naziv</th>";
                    echo "<th>Tip vlasnistva</th>";
                    echo "<th>Opis</th>";
                    echo "<th>Slika</th>";
                    echo "<th>Cijena koristenja</th>";
                    echo "<th>Vlasnik</th>";
                    echo "<th>Tip zahtjeva</th>";
                    echo "<th>Status</th>";
                    echo "<th>Opcija</th>";
                    echo "<tbody>";
                    foreach ($data as $product) {

                        $opis = explode(":_:", $product["opis"]);

                        echo "<tr>";
                        echo "<td>" . $product["zahtjev_id"] . "</td>";
                        echo "<td>" . $opis[0] . "</td>";
                        echo "<td>" . $product["naziv_tip_intelektualno_vlasnistvo"] . "</td>";
                        echo "<td>" . $opis[1] . "</td>";
                        echo "<td>" . "<img src=\"../multimedia/{$opis[2]}\" alt='{$product["slika"]}' width=50px>" . "</td>";
                        echo "<td>" . $opis[3] . "$</td>";
                        echo "<td>" . $product["korisnicko_ime"] . "</td>";
                        echo "<td>" . $product["naziv_tip_zahtjeva"] . "</td>";
                        echo "<td>" . $product["naziv_status"] . "</td>";
                        echo "<td><button class='btn_p' name='{$product["zahtjev_id"]}' value='prihvati'>Prihvati</button>"
                        . "<button class='btn_o' id='{$product["zahtjev_id"]}' name='{$product["zahtjev_id"]}' value='odbij'>Odbij</button></td>";
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
            var allButtonsP = document.querySelectorAll(".btn_p");
            var allButtonsO = document.querySelectorAll(".btn_o");
            for (i = 0; i < allButtonsP.length; i++) {
                allButtonsP[i].addEventListener("click", prihvati_odbij(allButtonsP[i].name, allButtonsP[i].value));
            }
            for (i = 0; i < allButtonsO.length; i++) {
                allButtonsO[i].addEventListener("click", prihvati_odbij(allButtonsO[i].name, allButtonsO[i].value));
            }
            function prihvati_odbij(button_id, button_value) {
                return function () {
                    $.ajax({
                        type: "GET",
                        url: "../php/resolve_request.php",
                        data: {id: button_id, value: button_value},
                        success: function (result) {
                            if (result === "1") {
                                alert("Zahtjev prihvacen!");
                                var row = document.getElementById(button_id).parentNode.parentNode;
                                row.parentNode.removeChild(row);
                                $("[name='" + button_id + "p']").remove();
                                $("[name='" + button_id + "o']").remove();
                            } else if (result === "0") {
                                alert("Zahtjev odbijen!");
                                var row = document.getElementById(button_id).parentNode.parentNode;
                                row.parentNode.removeChild(row);
                                $("[name='" + button_id + "p']").remove();
                                $("[name='" + button_id + "o']").remove();
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error('Error:', error);
                        }
                    });
                };
            }
        </script>
    </body>
</html>