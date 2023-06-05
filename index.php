<?php
$putanja = dirname($_SERVER['REQUEST_URI']);

if ($putanja == "/azivko") {
    $putanja = "/azivko/webdip_projekt";
}
require "php/functions.php";

$veza = new Baza();
$veza->spojiDB();

$upit = "SELECT iv.intelektualno_vlasnistvo_id, iv.naziv_intelektualno_vlasnistvo, iv.opis_intelektualno_vlasnistvo, iv.slika, iv.cijena_koristenja, iv.korisnik_id, k.korisnicko_ime, tiv.naziv_tip_intelektualno_vlasnistvo, s.naziv_status FROM intelektualno_vlasnistvo AS iv JOIN korisnik  AS k ON iv.korisnik_id = k.korisnik_id JOIN tip_intelektualnog_vlasnistva AS tiv ON iv.tip_intelektualnog_vlasnistva_id = tiv.tip_intelektualnog_vlasnistva_id JOIN status AS s ON iv.status_id = s.status_id WHERE iv.status_id = 1 OR iv.status_id = 5  ORDER BY k.korisnicko_ime;";
if (isset($_POST["search"]) && isset($_POST["submit"])) {
    $upit = "SELECT iv.intelektualno_vlasnistvo_id, iv.naziv_intelektualno_vlasnistvo, iv.opis_intelektualno_vlasnistvo, iv.slika, iv.cijena_koristenja, k.korisnicko_ime, tiv.naziv_tip_intelektualno_vlasnistvo, s.naziv_status FROM intelektualno_vlasnistvo AS iv JOIN korisnik  AS k ON iv.korisnik_id = k.korisnik_id JOIN tip_intelektualnog_vlasnistva AS tiv ON iv.tip_intelektualnog_vlasnistva_id = tiv.tip_intelektualnog_vlasnistva_id JOIN status AS s ON iv.status_id = s.status_id WHERE (iv.naziv_intelektualno_vlasnistvo LIKE '%{$_POST["search"]}%') AND (iv.status_id = 1 OR iv.status_id = 5) ORDER BY k.korisnicko_ime;";
}

if ($_SESSION["uloga"] > "2") {
    $upit = "SELECT iv.intelektualno_vlasnistvo_id, iv.naziv_intelektualno_vlasnistvo, iv.opis_intelektualno_vlasnistvo, iv.slika, iv.cijena_koristenja, iv.korisnik_id, k.korisnicko_ime, tiv.naziv_tip_intelektualno_vlasnistvo, s.naziv_status FROM intelektualno_vlasnistvo AS iv JOIN korisnik  AS k ON iv.korisnik_id = k.korisnik_id JOIN tip_intelektualnog_vlasnistva AS tiv ON iv.tip_intelektualnog_vlasnistva_id = tiv.tip_intelektualnog_vlasnistva_id JOIN status AS s ON iv.status_id = s.status_id ORDER BY k.korisnicko_ime;";
    if (isset($_POST["search"]) && isset($_POST["submit"])) {
        $upit = "SELECT iv.intelektualno_vlasnistvo_id, iv.naziv_intelektualno_vlasnistvo, iv.opis_intelektualno_vlasnistvo, iv.slika, iv.cijena_koristenja, k.korisnicko_ime, tiv.naziv_tip_intelektualno_vlasnistvo, s.naziv_status FROM intelektualno_vlasnistvo AS iv JOIN korisnik  AS k ON iv.korisnik_id = k.korisnik_id JOIN tip_intelektualnog_vlasnistva AS tiv ON iv.tip_intelektualnog_vlasnistva_id = tiv.tip_intelektualnog_vlasnistva_id JOIN status AS s ON iv.status_id = s.status_id WHERE iv.naziv_intelektualno_vlasnistvo LIKE '%{$_POST["search"]}%' ORDER BY k.korisnicko_ime;";
    }
}

$rezultat = $veza->selectDB($upit);

if ($rezultat->num_rows > 0) {
    $data = array();
    while ($row = $rezultat->fetch_assoc()) {
        $data[] = $row;
    }
}

if (isset($_SESSION["korisnik"])) {
    $upit = "SELECT * FROM korisnik WHERE korisnicko_ime = '{$_SESSION["korisnik"]}'";
    $rezultat = $veza->selectDB($upit);
    $user_id;
    while ($red = mysqli_fetch_array($rezultat)) {
        if ($red) {
            $user_id = $red["korisnik_id"];
        }
    }

    $upit = "SELECT * FROM placanje WHERE korisnik_id = '{$user_id}' AND moje_vlasnistvo = '0'";
    $rezultat = $veza->selectDB($upit);
    if ($rezultat->num_rows > 0) {
        $placeno = array();
        while ($row = $rezultat->fetch_assoc()) {
            $placeno[] = $row;
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
        <link rel="stylesheet" href="css/content.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
        <link href="https://fonts.cdnfonts.com/css/bahnschrift" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
        <script src="js/ajax.js"></script>
        <style>
            html,body,h1,h2,h3,h4 {
                font-family:"Bahnschrift"
            }
            html{
                background: #1e202b;
            }
            ul{
                background-color: darkgray;
                position: absolute;
                top: 30%;
                left: 35%;
                list-style-type: none;
                display: grid;
                grid-template-rows:    repeat(4, 100px);
            }
            .mySlides {
                display:none
            }
            .tag, .fa {
                cursor:pointer
            }
            .tag {
                height:15px;
                width:15px;
                padding:0;
                margin-top:6px
            }

            .panel{
                position: absolute;
                top: 10%;
                left: 37%;
            }

            .product {
                display: inline-block;
                margin-right: 150px;
                margin-top: 150px;
                text-align: center;
                height: 625px;
                width: 350px;
                background-color: white;
                box-shadow: 20px 20px #525E6C;
                border-radius: 25px;
            }

            .product:nth-child(-n+5) {
                margin-top: 400px;
            }

            .product img {
                margin-top: 5px;
                width: 200px;
                height: 200px;
                object-fit: cover;
            }

            .product h3 {
                background-color: #181A25;
                color: white;
                padding: 5px;
                margin-top: 10px;
                border-radius: 0px;
            }

            .product p {
                text-align: left;
                margin: 10px 0;
                margin-left: 10px;
            }

            .product .price {
                border-radius: 0px;
                background-color: #E94555;
                color: white;
                font-weight: bold;
            }

            h3,p,span {
                color: black;
            }
            h3,span {
                font-size: 30px;
            }

            .intellectual_property:hover{
                color:white!important;
                background-color:#f58792!important
            }

            .search{
                background-color: inherit;
                position: absolute;
                top: 23%;
                left: 70%;
                color: white;
            }
            .background{
                position: fixed;
                z-index: -1;
                width: 1080px;
                left: 0%;
                top: 0%;
            }
            .priceBorder{
                border-top: 10px;
                border-bottom: 10px;
                border-left: 0px;
                border-right: 0px;
                border-style: solid;
                border-color: #f58792;
            }
            .btn_kupi{
                width: 150px;
                margin-top: 8px;
                font-size: 19px;
                border-radius: 10px;
                background-color: gray;
                color: white;
            }
            .btn_prijavi{
                width: 150px;
                margin-top: 8px;
                font-size: 19px;
                border-radius: 10px;
                background-color: gray;
                color: white;
            }
        </style>
    </head>
    <body>

        <!-- Menu -->
        <?php
        include "php/meni.php";
        ?>

        <img src="multimedia/abstract.jpg" class="background">
        <!-- Content -->
        <div class="content" style="max-width:1100px;margin-top:80px;margin-bottom:80px">

            <div class="panel">
                <h1><b>Intelektualna vlasništva</b></h1>
            </div>

            <form  class="search" method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>" novalidate>

                <label for="search" style="font-size: 30px;">Pretraživanje: </label>
                <input type="text" placeholder="Pretraži ovdje" id="search" name="search">
                <button name="submit">Pretrazi</button>
            </form>
            <?php
            if (!empty($data)) {
                foreach ($data as $product) {
                    if (strlen($product["naziv_intelektualno_vlasnistvo"]) > 24) {
                        echo "<div class='product intellectual_property' style='height: 660px;'>";
                    } else {
                        echo "<div class='product intellectual_property'>";
                    }
                    echo "<a href='forms/intellectual_property.php?=property_id=$product[intelektualno_vlasnistvo_id]' style='text-decoration: none;'>";
                    echo "<img src='multimedia/$product[slika]' alt='$product[slika]' style='height: 200px; width: 200px; background-color: white;'>";
                    echo "<h3>$product[naziv_intelektualno_vlasnistvo]</h3>";
                    echo "<p >Opis: $product[opis_intelektualno_vlasnistvo]</p>";
                    echo "<p style='font-size: 20px;'>Tip: $product[naziv_tip_intelektualno_vlasnistvo]</p>";
                    echo "<p style='font-size: 20px;'>Vlasnik: $product[korisnicko_ime]</p>";
                    echo "<p style='font-size: 20px;'>Status: $product[naziv_status]</p>";
                    echo "<div class='price priceBorder'>";
                    echo "<span class='price'>Cijena koristenja:<br>" . $product['cijena_koristenja'] . "$</span>";
                    echo "</div>";
                    echo "</a>";
                    $vec_placeno = false;
                    if ($product["naziv_status"] == "Vazece" && isset($_SESSION["korisnik"]) && $product["korisnicko_ime"] != $_SESSION["korisnik"]) {
                        foreach ($placeno as $placanje) {
                            if ($placanje["intelektualno_vlasnistvo_id"] == $product["intelektualno_vlasnistvo_id"]) {
                                $vec_placeno = true;
                            }
                        }
                        if (!$vec_placeno) {
                            echo "<button class='btn_kupi' name='{$product["intelektualno_vlasnistvo_id"]}' value='{$product["cijena_koristenja"]}'>Kupi</button>";
                        }
                    }
                    if (isset($_SESSION["korisnik"]) && $product["korisnicko_ime"] != $_SESSION["korisnik"] && $product["naziv_status"] != "Prihvaceno") {
                        echo "<a href='forms/report_property.php?id={$product["intelektualno_vlasnistvo_id"]}'><button class='btn_prijavi'>Prijavi</button></a>";
                    }
                    echo "</div>";
                }
            } else {
                echo "No data found.";
            }
            ?>
        </div>

        <script>

            $(document).ready(function () {
                var poruka = "<?php
            if (isset($_GET["message"])) {
                echo $_GET["message"];
            } else {
                echo "ne";
            }
            ?>";
                if (poruka !== "ne") {
                    switch (poruka) {
                        case "login_uspjeh":
                            alert("Uspješno ste se prijavili!");
                            break;
                        case "register_uspjeh":
                            alert("Uspješno ste se registrirali!");
                            break;
                        case "report_uspjeh":
                            alert("Uspješno se prijavili vlasništvo!");
                            break;
                        case "kreiranje_uspjeh":
                            alert("Uspješno kreiran zahtjev!");
                            break;
                    }
                }
            });

            var allButtonsKupi = document.querySelectorAll(".btn_kupi");
            for (i = 0; i < allButtonsKupi.length; i++) {
                allButtonsKupi[i].addEventListener("click", plati(allButtonsKupi[i].name, allButtonsKupi[i].value));
            }
            function plati(property_id, property_value) {
                return function () {
                    $.ajax({
                        type: "GET",
                        url: "php/payment.php",
                        data: {property_id: property_id, value: property_value},
                        success: function (result) {
                            if (result === "1") {
                                alert("Placanje uspjesno izvrseno!");
                            } else {
                                alert("Greska kod placanja!");
                            }
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