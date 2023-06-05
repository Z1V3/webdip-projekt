<?php
$putanja = dirname(dirname($_SERVER['REQUEST_URI']));

if ($putanja == "/azivko") {
    $putanja = "/azivko/webdip_projekt";
}
require "../php/functions.php";

$veza = new Baza();
$veza->spojiDB();

if(isset($_POST["submit_create"])) {
    $upit = "INSERT INTO tip_intelektualnog_vlasnistva (naziv_tip_intelektualno_vlasnistvo) VALUES ('{$_POST["naziv"]}')";
    $veza->selectDB($upit);
}


$upit = "SELECT * FROM tip_intelektualnog_vlasnistva";
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
            .btn_d{
                border-radius: 10px;
                position:absolute;
                left: 65%;
                top: 39%;
                font-family:"Bahnschrift";
                width: 150px;
                height: 50px;
                font-weight: bold;
                background-color: white;
            }
            .btn_z{
                visibility: hidden;
                border-radius: 10px;
                position:absolute;
                left: 70%;
                top: 39%;
                font-family:"Bahnschrift";
                width: 150px;
                height: 50px;
                font-weight: bold;
                background-color: white;
            }
            .btn_o{
                border-radius: 10px;
                float: right;
                font-family:"Bahnschrift";
                width: 100px;
                height: 30px;
                font-weight: bold;
                background-color: white;
            }

            .form {
                visibility: hidden;
                position: absolute;
                top: 27%;
                left: 35%;
                z-index: 1;
                background-color: white;
                box-shadow: 20px 20px #525E6C;
                border-radius: 25px;
                box-sizing: border-box;
                height: 400px;
                padding: 20px;
                width: 920px;
            }

            .title {
                color: black;
                font-size: 36px;
                font-weight: 600;
                margin-top: 10px;
            }

            .subtitle {
                color: black;
                font-size: 16px;
                font-weight: 600;
                margin-top: 10px;
            }

            .input-container {
                height: 50px;
                position: relative;
                width: 100%;
            }

            .inpu1 {
                margin-top: 40px;
                margin-bottom: 40px;
            }

            .input3 {
                margin-top: 40px;
                margin-bottom: 180px;
            }

            .input {
                background-color: lightgray;
                border-radius: 12px;
                border: 0;
                box-sizing: border-box;
                color: #eee;
                font-size: 18px;
                height: 100%;
                outline: 0;
                padding: 4px 20px 0;
                width: 100%;
            }

            .cut {
                background-color: white;
                border-radius: 10px;
                height: 20px;
                left: 20px;
                position: absolute;
                top: -20px;
                transform: translateY(0);
                transition: transform 200ms;
                width: 76px;
            }


            .input:focus ~ .cut,
            .input:not(:placeholder-shown) ~ .cut {
                transform: translateY(8px);
            }
            .textarea:focus ~ .cut,
            .textarea:not(:placeholder-shown) ~ .cut {
                transform: translateY(8px);
            }

            .placeholder {
                color: #65657b;
                left: 20px;
                line-height: 14px;
                pointer-events: none;
                position: absolute;
                transform-origin: 0 50%;
                transition: transform 200ms, color 200ms;
                top: 20px;
            }

            .input:focus ~ .placeholder,
            .input:not(:placeholder-shown) ~ .placeholder {
                transform: translateY(-30px) translateX(10px) scale(0.75);
            }
            .textarea:focus ~ .placeholder,
            .textarea:not(:placeholder-shown) ~ .placeholder {
                transform: translateY(-30px) translateX(10px) scale(0.75);
            }

            .submit {
                background-color: #E94555;
                border-radius: 12px;
                border: 0;
                box-sizing: border-box;
                color: #eee;
                cursor: pointer;
                font-size: 18px;
                height: 50px;
                margin-top: 38px;
                text-align: center;
                width: 20%;
            }

            .submit:hover {
                background-color: #f58792;
            }

            .textarea{
                background-color: lightgray;
                border-radius: 12px;
                border: 0;
                box-sizing: border-box;
                color: #eee;
                font-size: 18px;
                height: 200px;
                outline: 0;
                padding: 4px 20px 0;
                width: 100%;
            }

            .selectdiv {
                position: relative;
                /*Don't really need this just for demo styling*/

                min-width: 200px;
                margin: 50px 33%;
            }

            /* IE11 hide native button (thanks Matt!) */
            select::-ms-expand {
                display: none;
            }

            .selectdiv:after {
                content: '<>';
                font: 17px "Consolas", monospace;
                color: #333;
                -webkit-transform: rotate(90deg);
                -moz-transform: rotate(90deg);
                -ms-transform: rotate(90deg);
                transform: rotate(90deg);
                right: 11px;
                /*Adjust for position however you want*/

                top: 18px;
                padding: 0 0 2px;
                border-bottom: 1px solid #999;
                /*left line */

                position: absolute;
                pointer-events: none;
            }

            .selectdiv select {
                -webkit-appearance: none;
                -moz-appearance: none;
                appearance: none;
                /* Add some styling */

                width: 100%;
                max-width: 320px;
                height: 50px;
                margin: 5px 0px;
                padding: 0px 24px;
                font-size: 16px;
                line-height: 1.75;
                color: #333;
                background-color: #ffffff;
                background-image: none;
                border: 1px solid #cccccc;
                -ms-word-break: normal;
                word-break: normal;
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
                    echo "<th>ID</th>";
                    echo "<th>Naziv</th>";
                    echo "<th></th>";
                    echo "<tbody>";
                    foreach ($data as $product) {
                        echo "<tr>";
                        echo "<td>" . $product["tip_intelektualnog_vlasnistva_id"] . "</td>";
                        echo "<td>" . $product["naziv_tip_intelektualno_vlasnistvo"] . "</td>";
                        echo "<td><button class='btn_o' id='{$product["tip_intelektualnog_vlasnistva_id"]}' onclick='obrisi({$product["tip_intelektualnog_vlasnistva_id"]})'>Obrisi</button></td>";
                        echo "</tr>";
                    }
                    echo "</tbody>";
                    echo "</table>";
                } else {
                    echo "No data found.";
                }
                ?>
            </div>
            <button class="btn_d" onclick="otvori_dodaj_vrstu()">Dodaj novu vrstu</button>
            <button class="btn_z" onclick="zatvori_dodaj_vrstu()">Zatvori</button>
            <form class="form" novalidate method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                <div class="title">Kreiranje tipa vlasnistva</div>
                <div class="subtitle">Ovdje upišite podatke</div>
                <div class="input-container inpu1">
                    <input id="name" class="input" type="text" name="naziv" placeholder=" " />
                    <div class="cut"></div>
                    <label for="firstname" class="placeholder">Naziv</label>
                </div>
                <button type="text" class="submit" name="submit_create">Kreiraj</button>
            </form>

        </div>
        <script>
            function otvori_dodaj_vrstu() {
                document.getElementById("tablica").style.visibility = "hidden";
                document.querySelector(".btn_z").style.visibility = "visible";
                document.querySelector(".btn_d").style.visibility = "hidden";
                document.querySelector(".form").style.visibility = "visible";
            }
            function zatvori_dodaj_vrstu() {
                document.getElementById("tablica").style.visibility = "visible";
                document.querySelector(".btn_z").style.visibility = "hidden";
                document.querySelector(".btn_d").style.visibility = "visible";
                document.querySelector(".form").style.visibility = "hidden";
            }
            function obrisi(button) {
                $.ajax({
                        type: "GET",
                        url: "../php/resolve_report.php",
                        data: {id_obrisi: button},
                        success: function (result) {
                            if (result === "1") {
                                alert("Tip obrisan!");
                                var row = document.getElementById(button).parentNode.parentNode;
                                row.parentNode.removeChild(row);
                            } else if (result === "0") {
                                alert("Greska kod brisanja!");
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error('Error:', error);
                        }
                    });
            }
        </script>
    </body>
</html>