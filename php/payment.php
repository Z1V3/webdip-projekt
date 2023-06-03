<?php
require "functions.php";

$veza = new Baza();
$veza->spojiDB();

$property_id = $_GET["property_id"];

$upit = "SELECT * FROM korisnik WHERE korisnicko_ime = '{$_SESSION["korisnik"]}'";
$rezultat = $veza->selectDB($upit);
$user_id;
while ($red = mysqli_fetch_array($rezultat)) {
    if ($red) {
        $user_id = $red["korisnik_id"];
    }
}

$upit = "SELECT * FROM intelektualno_vlasnistvo WHERE intelektualno_vlasnistvo_id = {$property_id}";
$rezultat = $veza->selectDB($upit);
$vlasnik_id;
while ($red = mysqli_fetch_array($rezultat)) {
    if ($red) {
        $vlasnik_id = $red["korisnik_id"];
    }
}

$time_now = date("Y-m-d H:i:s");

$moje_vlasnistvo = 0;

if($vlasnik_id == $user_id){
    $moje_vlasnistvo = 1;
}

if($moje_vlasnistvo == 1){
    $upit = "UPDATE intelektualno_vlasnistvo SET status_id = 5 WHERE intelektualno_vlasnistvo_id = {$property_id}";
    $veza->selectDB($upit);
}

$upit = "INSERT INTO placanje (iznos, datum_vrijeme_placanja, opis, moje_vlasnistvo, korisnik_id, intelektualno_vlasnistvo_id) VALUES ('{$_GET["value"]}', '{$time_now}', 'Opis', '{$moje_vlasnistvo}', '{$user_id}', '{$property_id}')";
if($veza->selectDB($upit)){
    $veza->zatvoriDB();
    echo "1";
}else{
    $veza->zatvoriDB();
    echo "0";
}