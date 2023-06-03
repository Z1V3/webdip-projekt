<?php

require "functions.php";

$veza = new Baza();
$veza->spojiDB();

if(isset($_GET["property_id"])){
    $upit = "SELECT * from intelektualno_vlasnistvo WHERE intelektualno_vlasnistvo_id = '{$_GET["property_id"]}'";
    $rezultat = $veza->selectDB($upit);
    $postoji = 0;
    while ($red = mysqli_fetch_array($rezultat)) {
        if ($red) {
            $postoji = 1;
        }
    }
    $veza->zatvoriDB();
    echo $postoji;
}else{
    echo "property_id is not valid";
}
