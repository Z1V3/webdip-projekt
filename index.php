<?php
$putanja = dirname($_SERVER['REQUEST_URI']);

if ($putanja == "/azivko") {
    $putanja = "/azivko/webdip_projekt";
}
require "php/functions.php";

$veza = new Baza();
$veza->spojiDB();

$upit = "SELECT iv.intelektualno_vlasnistvo_id, iv.naziv_intelektualno_vlasnistvo, iv.opis, iv.slika, iv.cijena_koristenja, k.korisnicko_ime, tiv.naziv_tip_intelektualno_vlasnistvo, s.naziv_status FROM intelektualno_vlasnistvo AS iv JOIN korisnik  AS k ON iv.korisnik_id = k.korisnik_id JOIN tip_intelektualnog_vlasnistva AS tiv ON iv.tip_intelektualnog_vlasnistva_id = tiv.tip_intelektualnog_vlasnistva_id JOIN status AS s ON iv.status_id = s.status_id WHERE iv.status_id = 1 OR iv.status_id = 5 ORDER BY k.korisnicko_ime;";
if (isset($_POST["search"]) && isset($_POST["submit"])) {
    $upit = "SELECT iv.intelektualno_vlasnistvo_id, iv.naziv_intelektualno_vlasnistvo, iv.opis, iv.slika, iv.cijena_koristenja, k.korisnicko_ime, tiv.naziv_tip_intelektualno_vlasnistvo, s.naziv_status FROM intelektualno_vlasnistvo AS iv JOIN korisnik  AS k ON iv.korisnik_id = k.korisnik_id JOIN tip_intelektualnog_vlasnistva AS tiv ON iv.tip_intelektualnog_vlasnistva_id = tiv.tip_intelektualnog_vlasnistva_id JOIN status AS s ON iv.status_id = s.status_id WHERE (iv.naziv_intelektualno_vlasnistvo LIKE '%{$_POST["search"]}%') AND (iv.status_id = 1 OR iv.status_id = 5) ORDER BY k.korisnicko_ime;";
}
$rezultat = $veza->selectDB($upit);

if ($rezultat->num_rows > 0) {
    $data = array();
    while ($row = $rezultat->fetch_assoc()) {
        $data[] = $row;
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Intelektualno vlasnistvo</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/content.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
        <script src="js/ajax.js"></script>
        <style>
            html,body,h1,h2,h3,h4 {
                font-family:"Lato", sans-serif
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
                height: 550px;
                width: 350px;
                background-color: #494F52;
            }

            .product:nth-child(-n+5) {
                margin-top: 400px;
            }


            .product img {
                margin-top: 15px;
                width: 200px;
                height: 200px;
                object-fit: cover;
            }

            .product h3 {
                margin-top: 10px;
            }

            .product p {
                margin: 10px 0;
            }

            .product .price {
                font-weight: bold;
            }

            h3,p,span {
                color: white;
            }
            h3,span {
                font-size: 30px;
            }

            .intellectual_property:hover{
                color:#000!important;
                background-color:black !important
            }

            .search{
                background-color: inherit;
                position: absolute;
                top: 23%;
                left: 70%;
                color: white;
            }
        </style>
    </head>
    <body>

        <!-- Menu -->
        <?php
        include "php/meni.php";
        ?>

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
                    echo "<div class='product intellectual_property'>";
                    echo "<a href='forms/intellectual_property.php?=property_id=$product[intelektualno_vlasnistvo_id]'>";
                    echo "<img src='multimedia/$product[slika]' alt='$product[slika]' style='height: 200px; width: 200px; background-color: white;'>";
                    echo "<h3>$product[naziv_intelektualno_vlasnistvo]</h3>";
                    echo "<p style='text-align: justify; margin-left: 15px; margin-right: 15px;'>Opis: $product[opis]</p>";
                    echo "<p style='font-size: 20px;'>Tip: $product[naziv_tip_intelektualno_vlasnistvo]</p>";
                    echo "<p style='font-size: 20px;'>Vlasnik: $product[korisnicko_ime]</p>";
                    echo "<p style='font-size: 20px;'>Status: $product[naziv_status]</p>";
                    echo "<span class='price'>Cijena koristenja:<br>$" . $product['cijena_koristenja'] . "</span>";
                    echo "</a>";
                    echo "</div>";
                }
            } else {
                echo "No data found.";
            }
            ?>
        </div>
    </body>
</html>