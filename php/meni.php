<?php
if($_SESSION["uloga"] > 3){
$meni = "<a href=\"$putanja/other_pages/logs.php\"><img src='$putanja/multimedia/book.png' alt='logs' class='logs'></a>"
        . "<a href=\"$putanja/dokumentacija.php\"><img src='$putanja/multimedia/document.png' alt='documentation' class='documentation'></a>";
}else{
    $meni = "";
}
$meni .= "<div class=\"top\">
            <div class=\"row large light-grey\">
                <div class=\"col s3\">
                    <a href=\"$putanja/index.php\" class=\"button block\">Popis zahtjeva</a>
                </div>
                <div class=\"col s3\">
                    <a href=\"$putanja/other_pages/all_users.php\" class=\"button block\">Popis vlasnika</a>
                </div>
                <div class=\"col s3\">
                    <a href=\"$putanja/o_autoru.php\" class=\"button block\">O autoru</a>
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
if ($_SESSION["uloga"] == "2") {
    $meni .= "<div class=\"col s3\">
                    <a href=\"$putanja/forms/create-request.php\" class=\"button block\">Kreiraj zahtjev</a>
                </div>
                <div class=\"col s3\">
                    <a href=\"$putanja/other_pages/my_property.php\" class=\"button block\">Moja vlasništva</a>
                </div>
                <div class=\"col s3\">
                    <a href=\"$putanja/forms/report_property.php\" class=\"button block\">Prijavi vlasništvo</a>
                </div>
                ";
}

if ($_SESSION["uloga"] > "2") {
    $meni .= "<div class=\"col s3\">
                    <a href=\"$putanja/other_pages/all_requests.php\" class=\"button block\">Pregled zahtjeva</a>
                </div>
                <div class=\"col s3\">
                   <a href=\"$putanja/other_pages/all_reports.php\" class=\"button block\">Prijave</a>
                </div>
                <div class = \"col s3\">
                    <a href=\"#contact\" class=\"button block\">Statistika</a>
                </div>";
}

if ($_SESSION["uloga"] > "3") {
    $meni .= "<div class=\"col s3\">
                   <a href=\"$putanja/other_pages/all_types.php\" class=\"button block\">Vrste vlasnistva</a>
                </div>
                ";
}

$meni .= " </div>
        </div>
        ";

echo $meni;
