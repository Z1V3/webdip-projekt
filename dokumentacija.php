<?php
$putanja = dirname(dirname($_SERVER['REQUEST_URI']));

require "php/functions.php";

if ($putanja == "/azivko") {
    $putanja = "/azivko/webdip_projekt";
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

            html,
            body {
                height: 100%;
                margin: 0;
                background: #1e202b;
                font-family: sans-serif;

            }

            .panel{
                position: absolute;
                top: 10%;
                left: 37%;
            }
            h2,h3,p,span {
                color: white;
            }
            h3,span {
                font-size: 30px;
            }
            h2{
                font-size: 25px;
            }
            .background{
                position: fixed;
                z-index: 0;
                width: 1080px;
                left: 0%;
                top: 0%;
            }
            .sadrzaj{
                margin: 100px;
                position: absolute;
                top: 20%;
                left: 37%;
            }
            .tekst{
                width: 1000px;
                text-align:justify;
                font-size: 18px;
                border-left: 5px;
                border-top: 0px;
                border-right: 0px;
                border-bottom: 0px;
                padding-left: 15px;
                border-style: solid;
                border-color: #f58792;
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
            <div class="sadrzaj">
                <h2>Opis projektnog zadatka</h2>
                <div class="tekst">
                    <p class="">
                        Tema projektnog zadatka je izrada web stranice koja je bazirana na intelektualna vlasništva. Neregistrirani korisnici mogu pregledavati intelektualno vlasništva i vlasnike.
                        Ukoliko se korisnik registrira tada ima opciju kupnje intelektualnog vlasništva na korištenje, dodavanje svojeg intelektualnog vlasništva putem zahtjeva te prijavu drugih ukoliko je uočena sličnost.
                        Moderator može rješavati zahtjeve određenih tipova intelektualnih vlasništva za koje je zadužen. Admin ima sve povlastice i može povećati autoritet korisnika i upravljati s moderatorima te dodijeliti
                        svakom moderatoru tip intelektualnog vlasništva kojem će upravljati.
                    </p>
                    <h2>Opis projektnog rješenja</h2>
                    <p>
                        Opis projektnog rješenja
                    </p>
                    <h2>ERA</h2>
                    <p>
                        ERA
                    </p>
                    <h2>Navigacijski dijagram</h2>
                    <p>
                        Navigacijski dijagram
                    </p>
                    <h2>Popis i opis korištenih tehnologija i alata</h2>
                    <p>
                        Popis i opis korištenih tehnologija i alata
                    </p>
                    <h2>Popis i opis korištenih skripta</h2>
                    <p>
                        baza.class.php - Klasa sa funkcijama za korištenje baze podataka<br>
                        file_check.php - Skripta za provjeru fajla koji su uploada na server<br>
                        functions.php - Skripta sa svim funkcijama<br>
                        meni.php - Skripta za meni svake stranice, mijenja se ovisno o ulozi korisnika<br>
                        payment.php - Skripta za plaćanje intelektualnog vlasništva<br>
                        report.php - Skripta za prijavljivanje sličnog intelektualnog vlasništva<br>
                        resolve_report.php - Skripta kojom prihvaćamo ili odbijamo prijavu<br>
                        resolve_request.php - Skripta kojom prihvaćamo ili odbijamo zahtjev korisnika<br>
                        sesija.class.php - Klasa sa funkcijama sesije<br>
                    </p>
                </div>
            </div>
        </div>
    </body>
</html>