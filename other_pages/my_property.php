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
$user_id;
while ($red = mysqli_fetch_array($rezultat)) {
    if ($red) {
        $user_id = $red["korisnik_id"];
    }
}

$upit = "SELECT * FROM placanje WHERE korisnik_id = '{$user_id}'";
$rezultat = $veza->selectDB($upit);
$data = array();
$placanja = array();
if ($rezultat->num_rows > 0) {
    while ($red = mysqli_fetch_array($rezultat)) {
        $placanja[] = $red["intelektualno_vlasnistvo_id"];
    }
}

foreach ($placanja as $placanje) {
    $upit = "SELECT iv.intelektualno_vlasnistvo_id, iv.naziv_intelektualno_vlasnistvo, iv.opis_intelektualno_vlasnistvo, iv.slika, iv.cijena_koristenja, k.korisnicko_ime, tiv.naziv_tip_intelektualno_vlasnistvo, s.naziv_status FROM intelektualno_vlasnistvo AS iv JOIN korisnik  AS k ON iv.korisnik_id = k.korisnik_id JOIN tip_intelektualnog_vlasnistva AS tiv ON iv.tip_intelektualnog_vlasnistva_id = tiv.tip_intelektualnog_vlasnistva_id JOIN status AS s ON iv.status_id = s.status_id WHERE iv.intelektualno_vlasnistvo_id = '{$placanje}'";
    $rezultat = $veza->selectDB($upit);
    if ($rezultat->num_rows > 0) {
        while ($row = $rezultat->fetch_assoc()) {
            $data[] = $row;
        }
    }
}

$upit = "SELECT iv.intelektualno_vlasnistvo_id, iv.naziv_intelektualno_vlasnistvo, iv.opis_intelektualno_vlasnistvo, iv.slika, iv.cijena_koristenja, k.korisnicko_ime, tiv.naziv_tip_intelektualno_vlasnistvo, s.naziv_status FROM intelektualno_vlasnistvo AS iv JOIN korisnik  AS k ON iv.korisnik_id = k.korisnik_id JOIN tip_intelektualnog_vlasnistva AS tiv ON iv.tip_intelektualnog_vlasnistva_id = tiv.tip_intelektualnog_vlasnistva_id JOIN status AS s ON iv.status_id = s.status_id WHERE k.korisnik_id = '{$user_id}' AND s.status_id != '5' AND s.status_id != '2'";
$rezultat = $veza->selectDB($upit);
if ($rezultat->num_rows > 0) {
    while ($row = $rezultat->fetch_assoc()) {
        $data[] = $row;
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
            .btn{
                border-radius: 10px;
                padding: 10px;
                padding-left: 30px;
                padding-right: 30px;
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
                    echo "<th>Placanje</th>";
                    echo "<tbody>";
                    foreach ($data as $product) {
                        echo "<tr>";
                        echo "<td>" . $product["intelektualno_vlasnistvo_id"] . "</td>";
                        echo "<td>" . $product["naziv_intelektualno_vlasnistvo"] . "</td>";
                        echo "<td>" . $product["naziv_tip_intelektualno_vlasnistvo"] . "</td>";
                        echo "<td>" . $product["opis_intelektualno_vlasnistvo"] . "</td>";
                        echo "<td>" . "<img src=\"../multimedia/{$product["slika"]}\" alt='{$product["slika"]}' width=50px>" . "</td>";
                        echo "<td>" . $product["cijena_koristenja"] . "$</td>";
                        echo "<td>" . $product["korisnicko_ime"] . "</td>";
                        if ($product["naziv_status"] == "Prihvaceno") {
                            echo "<td><button class='btn' name='{$product["intelektualno_vlasnistvo_id"]}' value='{$product["cijena_koristenja"]}'>Plati</button></td>";
                        } else if ($product["naziv_status"] == "Provjera") {
                            echo "<td>Vlasništvo u provjeri</td>";
                        } else if ($product["naziv_status"] == "Odbijeno") {
                            echo "<td>Vlasnistvo odbijeno</td>";
                        } else {
                            echo "<td>Placeno</td>";
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
            var allButtons = document.querySelectorAll(".btn");
            for (i = 0; i < allButtons.length; i++) {
                allButtons[i].addEventListener("click", plati(allButtons[i].name, allButtons[i].value));
            }
            function plati(property_id, property_value) {
                return function () {
                    $.ajax({
                        type: "GET",
                        url: "../php/payment.php",
                        data: {property_id: property_id, value: property_value},
                        success: function (result) {
                            console.log(result);
                            $("[name='" + property_id + "']").remove();
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