<?php
$putanja = dirname(dirname($_SERVER['REQUEST_URI']));

if ($putanja == "/azivko") {
    $putanja = "/azivko/webdip_projekt";
}
require "../php/functions.php";

$veza = new Baza();
$veza->spojiDB();

$upit = "SELECT * FROM prijava";
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
            .btn_v{
                border-radius: 10px;

                font-family:"Bahnschrift";
                width: 100px;
                height: 30px;
                background-color: lightgreen;
                font-weight: bold;
                margin-bottom: 5px;
            }

            .btn_o{
                border-radius: 10px;
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
                    echo "<th>Naslov</th>";
                    echo "<th>Razlog</th>";
                    echo "<th>Intelektualno vlasnistvo</th>";
                    echo "<th>Korisnik</th>";
                    echo "<th>Odluka</th>";
                    echo "<tbody>";
                    foreach ($data as $product) {
                        echo "<tr>";
                        echo "<td>" . $product["prijava_id"] . "</td>";
                        echo "<td>" . $product["naslov"] . "</td>";
                        echo "<td>" . $product["razlog"] . "</td>";
                        echo "<td>" . $product["intelektualno_vlasnistvo_id"] . "</td>";
                        echo "<td>" . $product["korisnik_id"] . "</td>";
                        echo "<td><button class='btn_v' name='{$product["intelektualno_vlasnistvo_id"]}' value='vazece'>Vazece</button>"
                        . "<button class='btn_o' id='{$product["intelektualno_vlasnistvo_id"]}' name='{$product["intelektualno_vlasnistvo_id"]}' value='odbijeno'>Odbij</button></td>";
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
            var allButtons = document.querySelectorAll(".btn_v ,.btn_o");
            for (i = 0; i < allButtons.length; i++) {
                allButtons[i].addEventListener("click", prihvati_odbij(allButtons[i].name, allButtons[i].value));
            }
            function prihvati_odbij(button_id, button_value) {
                return function () {
                    $.ajax({
                        type: "GET",
                        url: "../php/resolve_report.php",
                        data: {id: button_id, value: button_value},
                        success: function (result) {
                            if (result === "1") {
                                alert("Vlasnistvo prihvaceno!");
                                var row = document.getElementById(button_id).parentNode.parentNode;
                                row.parentNode.removeChild(row);
                            } else if (result === "0") {
                                alert("Vlasnistvo odbijeno!");
                                var row = document.getElementById(button_id).parentNode.parentNode;
                                row.parentNode.removeChild(row);
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