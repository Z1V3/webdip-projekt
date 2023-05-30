<?php

$meni = "<div class=\"top\">
            <div class=\"row large light-grey\">
                <div class=\"col s3\">
                    <a href=\"$putanja/index.php\" class=\"button block\">Popis zahtjeva</a>
                </div>
                <div class=\"col s3\">
                    <a href=\"#contact\" class=\"button block\">Popis vlasnika</a>
                </div>
                <div class=\"col s3\">
                    <a href=\"#plans\" class=\"button block\">O autoru</a>
                </div>
                    ";
if (!isset($_SESSION["uloga"])) {
    $meni .= "<div class=\"col s3\">
                    <a href=\"$putanja/forms/authentication-login.php\" class=\"button block\">Prijava / Registracija</a>
                </div>
                ";
} else {
    $meni .= "<div class=\"col s3\">
                    <a href=\"?odjava=da\" class=\"button block\">Odjava</a>
                </div>
                ";
}
if ($_SESSION["uloga"] > "1"){
    $meni .= "<div class=\"col s3\">
                    <a href=\"$putanja/forms/create-request.php\" class=\"button block\">Kreiraj zahtjev</a>
                </div>
                <div class=\"col s3\">
                    <a href=\"#contact\" class=\"button block\">Moja vlasništva</a>
                </div>
                <div class=\"col s3\">
                    <a href=\"#contact\" class=\"button block\">Prijavi vlasništvo</a>
                </div>
                ";
}

if ($_SESSION["uloga"] > "2"){
    $meni .= "<div class=\"col s3\">
                    <a href=\"#contact\" class=\"button block\">Statistika</a>
                </div>
                ";
}

$meni .= " </div>
        </div>
        ";

echo $meni;