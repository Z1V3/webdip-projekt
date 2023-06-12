<?php

require 'baza.class.php';
require 'sesija.class.php';

$tekst = basename($_SERVER['PHP_SELF']);

if (isset($_COOKIE)) {
    if (isset($_GET['obrisi']) && $_GET['obrisi'] == "kolacic") {
        unset($_COOKIE['autenticiran']);
    }
}

Sesija::kreirajSesiju();

if (isset($_GET["odjava"])) {
    Sesija::obrisiSesiju();
}

function zapisiDnevnik($tip_zapisa, $korisnik_id, $username) {
    $veza = new Baza();
    $veza->spojiDB();
    $testtime = date("Y-m-d H:i:s");
    $opis;
    switch ($tip_zapisa) {
        case '3':
            $opis = "Prijava u racun s korisnickim imenom: " . $username;
            break;
        case '4':
            $opis = "Registracija u racun s korisnickim imenom: " . $username;
            break;
        case '5':
            $opis = "Aktivacija racuna s korisnickim imenom: " . $username;
            break;
        case '6':
            $opis = "Prijava intelektualnog vlasnistva pod brojem: " . $username;
            break;
        case '7':
            $opis = "Generiranje nove lozinke racunu: " . $username;
            break;
        case '8':
            $opis = "Zahtjev za kreiranje novog vlasnistva za racun: " . $username;
            break;
        case '9':
            $opis = "Moderiranje korisnika: " . $username;
            break;
        case '10':
            $opis = "Blokiranje korisnika: " . $username;
            break;
        case '11':
            $opis = "Deblokiranje korisnika: " . $username;
            break;
    }
    if (isset($opis)) {
        $upit = "INSERT INTO dnevnik (opis, datum_vrijeme_zapisa, tip_zapisa_id, korisnik_id) VALUES ('{$opis}','{$testtime}',{$tip_zapisa},{$korisnik_id})";
        $veza->selectDB($upit);
    }
    $veza->zatvoriDB();
}
