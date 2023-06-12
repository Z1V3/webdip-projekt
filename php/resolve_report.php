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

if (isset($_GET["username"])) {
    $upit = "SELECT * FROM korisnik WHERE korisnicko_ime = '{$_GET["username"]}'";
    $rezultat = $veza->selectDB($upit);
    if ($rezultat->num_rows > 0) {
        echo "1";
    } else {
        echo "0";
    }
}

if (isset($_GET["username_zl"])) {
    $upit = "SELECT * FROM korisnik WHERE korisnicko_ime = '{$_GET["username_zl"]}'";
    $rezultat = $veza->selectDB($upit);
    if ($rezultat->num_rows > 0) {
        $kod_id;
        while ($red = mysqli_fetch_array($rezultat)) {
            if ($red) {
                $kod_id = $red["korisnik_id"];
            }
        }
        $lowercaseAlphabet = 'abcdefghijklmnopqrstuvwxyz';
        $uppercaseAlphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $numbers = '0123456789';
        $special = '!$%*_=.';
        $pass = array();
        $alphaLength = strlen($lowercaseAlphabet) - 1;
        $numbersLength = strlen($numbers) - 1;
        $specialLength = strlen($special) - 1;
        for ($i = 0; $i < 3; $i++) {
            $a = rand(0, $alphaLength);
            $b = rand(0, $alphaLength);
            $c = rand(0, $numbersLength);
            $d = rand(0, $specialLength);

            $pass[] = $lowercaseAlphabet[$a];
            $pass[] = $uppercaseAlphabet[$b];
            $pass[] = $numbers[$c];
            $pass[] = $special[$d];
        }
        $novaLoz = implode($pass);
        $novaLoz_sha256 = hash("sha256", $novaLoz);

        $upit = "UPDATE korisnik SET lozinka = '{$novaLoz}', lozinka_sha256 = '{$novaLoz_sha256}' WHERE korisnicko_ime ='{$_GET["username_zl"]}'";

        if ($veza->selectDB($upit)) {
            zapisiDnevnik(7, $kod_id, $_SESSION["korisnik"]);
            $mail_to = 'andrijazifko@gmail.com';    //trenutno se salje ovom mailu, ako budem htel drugi mail onda SELECT u bazu $_GET["username"] da se nade o kome je rijec i uzme mu se mail i onda se tom posalje
            $mail_from = "azivko@student.foi.hr";
            $mail_subject = '[WebDiP] Slanje maila: Promjena lozinke';
            $mail_body = "Nova lozinka je: {$novaLoz}";

            mail($mail_to, $mail_subject, $mail_body, $mail_from);
            echo "1";
        } else {
            echo "0";
        }
    } else {
        echo "-1";
    }
}

$veza->zatvoriDB();
