<?php
$putanja = dirname($_SERVER['REQUEST_URI']);

if ($putanja == "/azivko") {
    $putanja = "/azivko/webdip_projekt";
}
require "php/functions.php";

$veza = new Baza();
$veza->spojiDB();

$upit = "SELECT * FROM intelektualno_vlasnistvo";
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
                margin: auto;
                margin-right: 50px;
                margin-top: 400px;
                text-align: center;
                height: 500px;
                width: 350px;
                background-color: #494F52;
            }

            .product img {
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

            <?php
            if (!empty($data)) {
                foreach ($data as $product) {
                    echo "<div class='product intellectual_property'>";
                    echo "<a href='forms/intellectual_property.php?=property_id=$product[intelektualno_vlasnistvo_id]'>";
                    echo "<img src='multimedia/$product[slika]' alt='$product[slika]' style='height: 200px; width: 200px; background-color: white;'>";
                    echo "<h3>$product[naziv]</h3>";
                    echo "<p>$product[opis]</p>";
                    echo "<span class='price'>$" . $product['cijena_koristenja'] . "</span>";
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