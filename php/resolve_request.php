<?php

require "functions.php";

$veza = new Baza();
$veza->spojiDB();

if ($_GET["value"] == "prihvati") {
    $upit = "SELECT * from zahtjev WHERE zahtjev_id = {$_GET["id"]}";
    $rezultat = $veza->selectDB($upit);
    $opis;
    while ($red = mysqli_fetch_array($rezultat)) {
        if ($red) {
            $opis = $red["opis"];
        }
    }
    $opis_podijeljeni = explode(":_:", $opis);

    $upit = "INSERT INTO intelektualno_vlasnistvo (naziv_intelektualno_vlasnistvo, opis_intelektualno_vlasnistvo, slika, cijena_koristenja, tip_intelektualnog_vlasnistva_id, korisnik_id, status_id) VALUES ('{$opis_podijeljeni[0]}','{$opis_podijeljeni[1]}','{$opis_podijeljeni[2]}','{$opis_podijeljeni[3]}','{$opis_podijeljeni[4]}','{$opis_podijeljeni[5]}','1')";
    $veza->selectDB($upit);

    $upit = "UPDATE zahtjev SET status_id = 1 WHERE zahtjev_id = {$_GET["id"]}";
    $veza->selectDB($upit);
    echo "1";
} else if ($_GET["value"] == "odbij") {
    $upit = "UPDATE zahtjev SET status_id = 2 WHERE zahtjev_id = {$_GET["id"]}";
    $veza->selectDB($upit);
    echo "0";
}
$veza->zatvoriDB();