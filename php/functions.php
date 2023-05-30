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