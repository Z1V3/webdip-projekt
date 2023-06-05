<?php

require "functions.php";

$veza = new Baza();
$veza->spojiDB();

if (isset($_GET["value"]) && $_GET["value"] == "vazece") {
    $upit = "UPDATE intelektualno_vlasnistvo SET status_id = 5 WHERE intelektualno_vlasnistvo_id = {$_GET["id"]}";
    $veza->selectDB($upit);
    echo "1";
} else if (isset($_GET["value"]) && $_GET["value"] == "odbijeno") {
    $upit = "UPDATE intelektualno_vlasnistvo SET status_id = 2 WHERE intelektualno_vlasnistvo_id = {$_GET["id"]}";
    $veza->selectDB($upit);
    echo "0";
}

if (isset($_GET["id_obrisi"])) {
    $upit = "DELETE FROM tip_intelektualnog_vlasnistva WHERE tip_intelektualnog_vlasnistva_id = {$_GET["id_obrisi"]}";
    if ($veza->selectDB($upit)) {
        echo "1";
    } else {
        echo "0";
    }
}

if (isset($_GET["username"])){
    $upit = "SELECT * FROM korisnik WHERE korisnicko_ime = '{$_GET["username"]}'";
    $rezultat = $veza->selectDB($upit);
    if ($rezultat->num_rows > 0) {
        echo "1";
    }else{
        echo "0";
    }
}

$veza->zatvoriDB();
