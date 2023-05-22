<?php

class Baza {

    const server = "localhost";
    // unesite Vaše podatke
    const korisnik = "root"; /* phpmyadmin-lokalno: root, phpmyadmin-barka: WebDiP2022xMK*/
    const lozinka = "9WTXx9WEhz23031979!"; /*  phpmyadmin-lokalno: root ili bez lozinke,  phpmyadmin-barka: admin_A1B2C3D4 */
    const baza = "WebDiP2022x056"; /* lokalno: napraviti bazu, barka: WebDiP2022xMK*/

    private $veza = null;
    private $greska = '';

    function spojiDB() {
        $this->veza = new mysqli(self::server, self::korisnik, self::lozinka, self::baza);
        if ($this->veza->connect_errno) {
            echo "Neuspješno spajanje na bazu: " . $this->veza->connect_errno . ", " .
            $this->veza->connect_error;
            $this->greska = $this->veza->connect_error;
        }
        $this->veza->set_charset("utf8");
        if ($this->veza->connect_errno) {
            echo "Neuspješno postavljanje znakova za bazu: " . $this->veza->connect_errno . ", " .
            $this->veza->connect_error;
            $this->greska = $this->veza->connect_error;
        }
        return $this->veza;
    }

    function zatvoriDB() {
        $this->veza->close();
    }

    function selectDB($upit) {
        $rezultat = $this->veza->query($upit);
        if ($this->veza->connect_errno) {
            echo "Greška kod upita: {$upit} - " . $this->veza->connect_errno . ", " .
            $this->veza->connect_error;
            $this->greska = $this->veza->connect_error;
        }
        if (!$rezultat) {
            $rezultat = null;
        }
        return $rezultat;
    }
    
    function updateDB($upit, $skripta = '') {
        $rezultat = $this->veza->query($upit);
        if ($this->veza->connect_errno) {
            echo "Greška kod upita: {$upit} - " . $this->veza->connect_errno . ", " .
            $this->veza->connect_error;
            $this->greska = $this->veza->connect_error;
        } else {
            if ($skripta != '') {
                header("Location: $skripta");
            }
        }

        return $rezultat;
    }

    function pogreskaDB() {
        if ($this->greska != '') {
            return true;
        } else {
            return false;
        }
    }

}

?>