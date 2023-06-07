<?php
$putanja = dirname(dirname($_SERVER['REQUEST_URI']));

include "../php/functions.php";

if (isset($_SESSION["uloga"])) {
    header("Location: ../index.php");
    exit();
}

if (isset($_POST["submit"])) {
    $error = "";
    $username = $_POST["username"];
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirm_password"];

    $regex = "/^[^!@#$%^&*()_+\-=\[\]{};\'\":\\|,.<>\/?]+[\w.]+[\w]+@+[^!@#$%^&*()_+\-=\[\]{};\'\":\\|,.<>\/?]+[\w.]+$/";
    if (!preg_match($regex, $email)) {
        $error = "Email polje nije pravilno popunjeno!";
    }

    $regex = '^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,25}$/';
    if (!preg_match($regex, $password)) {
        $error = "Lozinka mora sadržavati barem jedan broj, jedno veliko i jedno malo slovo te specijalan znak i u rangu je od 8 do 25 znakova!";
    }

    $veza = new Baza();
    $veza->spojiDB();

    $query = "SELECT * FROM korisnik WHERE korisnicko_ime = '{$username}'";
    $rezultat = $veza->selectDB($query);
    if ($rezultat->num_rows > 0) {
        $error = "Korisnik postoji";
    }
    
    $query = "SELECT * FROM korisnik WHERE email = '{$email}'";
    $rezultat = $veza->selectDB($query);
    if ($rezultat->num_rows > 0) {
        $error = "Korisnik postoji";
    }
    
    $veza->zatvoriDB();
    if (empty($error)) {

        $veza = new Baza();
        $veza->spojiDB();

        $password_sha256 = hash("sha256", $password);

        $query = "INSERT INTO korisnik (korisnicko_ime, ime, prezime, email, lozinka, lozinka_sha256, uvjeti, broj_neuspjesnih_prijava, blokiran, aktiviran, tip_korisnika_id) VALUES ('{$username}','{$firstname}','{$lastname}','{$email}','{$password}','{$password_sha256}','0','0','0','0','2')";

        $result = $veza->selectDB($query);

        $veza->zatvoriDB();

        header("Location: account-activation.php?username={$username}");
        exit();
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Intelektualno vlasnistvo</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../css/content.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
        <style media="screen">
            html,body,h1,h2,h3,h4 {
                font-family:"Lato", sans-serif
            }
            .mySlides {
                display:none
            }
            .tag, .fa {
                cursor:pointer
            }
            .tag {
                height:15px;
                width:15px;
                padding:0;
                margin-top:6px
            }

            *:after{
                padding: 0;
                margin: 0;
                box-sizing: border-box;
            }
            body{
                background-color: #080710;
            }

            html{
                background: #1e202b;
            }

            .background{
                width: 430px;
                height: 520px;
                position: absolute;
                transform: translate(-50%,-50%);
                left: 50%;
                top: 50%;
            }
            .background .shape{
                height: 200px;
                width: 200px;
                position: absolute;
                border-radius: 50%;
            }
            .shape:first-child{
                background: linear-gradient(
                    #1845ad,
                    #23a2f6
                    );
                left: -200px;
                top: -100px;
            }
            .shape:last-child{
                background: linear-gradient(
                    to right,
                    #ff512f,
                    #f09819
                    );
                right: -130px;
                bottom: -500px;
            }
            form{
                height: 1170px;
                width: 600px;
                background-color: rgba(255,255,255,0.13);
                position: absolute;
                transform: translate(-50%,-50%);
                top: 66%;
                left: 50%;
                border-radius: 10px;
                border: 2px solid rgba(255,255,255,0.1);
                box-shadow: 0 0 40px rgba(8,7,16,0.6);
                padding: 50px 35px;
            }
            form *{
                font-family: 'Poppins',sans-serif;
                color: #ffffff;
                letter-spacing: 0.5px;
                outline: none;
                border: none;
            }
            form h3{
                font-size: 32px;
                font-weight: 500;
                line-height: 42px;
                text-align: center;
            }

            label{
                display: block;
                margin-top: 30px;
                font-size: 16px;
                font-weight: 500;
            }
            input{
                display: block;
                height: 50px;
                width: 100%;
                background-color: darkgray;
                border-radius: 3px;
                padding: 0 10px;
                margin-top: 8px;
                font-size: 14px;
                font-weight: 300;
            }
            ::placeholder{
                color: white;
                font-weight: bold;
            }
            button{
                margin-top: 50px;
                width: 100%;
                background-color: #ffffff;
                color: #080710;
                padding: 15px 0;
                font-size: 18px;
                font-weight: 600;
                border-radius: 5px;
                cursor: pointer;
            }


        </style>
    </head>
    <body>

        <!-- Menu -->
        <?php
        include "../php/meni.php";
        ?>

        <!-- Content -->
        <div class="content" style="max-width:1100px;margin-top:80px;margin-bottom:80px">

            <div class="panel">
                <h1><b>Intelektualna vlasništva</b></h1>

                <div class="background">
                    <div class="shape"></div>
                    <div class="shape"></div>
                </div>
                <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>" novalidate onsubmit="provjeri()">
                    <h3>Registracija</h3>

                    <label for="username">Username</label>
                    <input type="text" placeholder="Email or Phone" id="username" name="username" onkeyup="postoji()">
                    <label id="warning" style="display: none;">Korisnicko ime postoji!</label>

                    <label for="firstname">Firstname</label>
                    <input type="text" placeholder="Firstname" id="firstname" name="firstname">
                    <label id="warning2" style="display: none;">Ime mora biti u rangu od 4 do 25 znaka i ne smije sadrzavati brojke/specijalne znakove!</label>

                    <label for="lastname">Lastname</label>
                    <input type="text" placeholder="Lastname" id="lastname" name="lastname">
                    <label id="warning3" style="display: none;">Prezime mora biti u rangu od 4 do 25 znaka i ne smije sadrzavati brojke/specijalne znakove!</label>

                    <label for="email">Email</label>
                    <input type="email" placeholder="Email" id="email" name="email">
                    <label id="warning4" style="display: none;">Nepravilan email!</label>

                    <label for="password">Password</label>
                    <input type="password" placeholder="Password" id="password" name="password">
                    <label id="warning5" style="display: none;">Lozinka mora sadrzavati sadrzavati: 1 malo slovo, 1 veliko slovo, 1 specijalan znak, 1 broj i u rangu je 8 do 25 znakova!</label>

                    <label for="confirm_password">Confirm password</label>
                    <input type="password" placeholder="Confirm password" id="confirm_password" name="confirm_password">
                    <label id="warning6" style="display: none;">Lozinke se moraju podudarati!</label>

                    <button name="submit" id="button_register">Registriraj se</button><br><br>

                    <a href="authentication-login.php">Logiraj se</a>
                </form>

            </div>

            <script>

                function provjeri() {
                    var greska = false;
                    const regexFirstname = new RegExp("\b[A-Za-z]{3,25}\b");
                    var ok = true;
                    ok = regexFirstname.test(document.getElementById("firstname").value);
                    if (!ok) {
                        greska = true;
                        document.getElementById("warning2").style.display = "initial";
                    } else {
                        document.getElementById("warning2").style.display = "none";
                    }
                    ok = true;
                    ok = regexFirstname.test(document.getElementById("lastname").value);
                    if (!ok) {
                        greska = true;
                        document.getElementById("warning3").style.display = "initial";
                    } else {
                        document.getElementById("warning3").style.display = "none";
                    }
                    ok = true;
                    const regexEmail = /^[^!@#$%^&*()_+\-=\[\]{};\'\":\\|,.<>\/?]+[\w.]+[\w]+@+[^!@#$%^&*()_+\-=\[\]{};\'\":\\|,.<>\/?]+[\w.]+$/;
                    ok = regexEmail.test(document.getElementById("email"));
                    if (!ok) {
                        greska = true;
                        document.getElementById("warning4").style.display = "initial";
                    } else {
                        document.getElementById("warning4").style.display = "none";
                    }
                    ok = true;
                    const regexPass = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,25}$");
                    ok = regexPass.test(document.getElementById("password"));
                    if (!ok) {
                        greska = true;
                        document.getElementById("warning5").style.display = "initial";
                    } else {
                        document.getElementById("warning5").style.display = "none";
                    }
                    if (document.getElementById("password").value !== document.getElementById("confirm_password")) {
                        greska = true;
                        document.getElementById("warning6").style.display = "initial";
                    } else {
                        document.getElementById("warning6").style.display = "none";
                    }
                    if (greska) {
                        event.preventDefault();
                    }
                }

                function postoji() {
                    var username = document.getElementById("username").value;
                    $.ajax({
                        type: "GET",
                        url: "../php/resolve_report.php",
                        data: {username: username},
                        async: false,
                        success: function (result) {
                            if (result === "1") {
                                document.getElementById("button_register").disabled = true;
                                document.getElementById("warning").style.display = "initial";

                            } else {
                                document.getElementById("button_register").disabled = false;
                                document.getElementById("warning").style.display = "none";
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error('Error:', error);
                        }
                    });
                }
            </script>

        </div>
    </body>
</html>