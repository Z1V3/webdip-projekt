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
            html,body,h1,h2,h3,h4,p {
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
            h1,h3,h2,p,span,ul {
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
                <h1>Informacije o autoru</h1>
                <h2>Motivacija</h2>
                <p class="tekst">
                    Moja motivacija za učenje Web tehnologija potiče od moje zainteresiranosti u području
                    kibernetičke sigurnosti. Znanje o web programiranju i uvid u tehnološke vještine i tehnike 
                    kod izrade web stranica daju mi unutarnje znanje o tome kako stranice funkcioniraju i koje
                    bi mogle biti ranjivosti kod istih. Na taj način kvalitetnije znam kako bi se trebalo zaštiti
                    od raznih pogrešaka koje developeri rade i tako skupljam iskustva i gradim bazu podataka znanja
                    koja mi pomaže u izgradnji moje karijere u području kibernetičkih sigurnosti.
                </p>
                <figure>
                    <img style="margin-top: 10px;" src="multimedia/osobna-slika.jpg" alt="Osobna slika" width="300" height="300">
                    <figcaption>Osobna slika</figcaption>
                </figure>
                <ul style="font-size: 18px;">
                    <li>Ime: Andrija</li>
                    <li>Prezime: Živko</li>
                    <li>E-mail: <a href="mailto:azivko@student.foi.hr">azivko@student.foi.hr</a></li>
                    <li>Broj iksice: 0016143755</li>
                </ul>
            </div>
        </div>
    </body>
</html>