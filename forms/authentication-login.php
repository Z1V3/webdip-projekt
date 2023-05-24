<?php
$putanja = dirname(dirname($_SERVER['REQUEST_URI']));

include "../php/functions.php";

if (isset($_SESSION["uloga"])) {
    header("Location: ../index.php");
    exit();
}

if (isset($_POST["submit"])) {
    $error = "";
    $aktiviran;
    $username = $_POST["username"];
    $password = $_POST["password"];
    if (!isset($_POST["username"]) || !isset($_POST["password"])) {
        $error = "Niste unijeli sve podatke!";
    } else {
        $veza = new Baza();
        $veza->spojiDB();

        $upit = "SELECT * FROM `korisnik` WHERE "
                . "`korisnicko_ime`='{$username}' AND "
                . "`lozinka`='{$password}' AND "
                . "`tip_korisnika_id` NOT LIKE '1'";
        $rezultat = $veza->selectDB($upit);

        $autenticiran = false;
        while ($red = mysqli_fetch_array($rezultat)) {
            if ($red) {
                $autenticiran = true;
                $tip = $red["tip_korisnika_id"];
                $email = $red["email"];
                $aktiviran = $red["aktiviran"];
            }
        }

        if ($autenticiran && $aktiviran == "1") {
            $poruka = 'Uspješna prijava!';

            //Create cookie
            setcookie("autenticiran", $username, false, '/', false);

            //Create session
            Sesija::kreirajKorisnika($username, $tip);

            header("Location: ../index.php");
            exit();
        }else if($aktiviran == "0"){
            header("Location: account-activation.php?username={$username}");
        }else {
            $poruka = 'Neuspješna prijava!';
        }

        $veza->zatvoriDB();
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
                left: -80px;
                top: -50px;
            }
            .shape:last-child{
                background: linear-gradient(
                    to right,
                    #ff512f,
                    #f09819
                    );
                right: -80px;
                bottom: -130px;
            }
            form{
                height: 570px;
                width: 400px;
                background-color: rgba(255,255,255,0.13);
                position: absolute;
                transform: translate(-50%,-50%);
                top: 55%;
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
                <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>" novalidate>
                    <h3>Login</h3>

                    <label for="username">Username</label>
                    <input type="text" placeholder="Username" id="username" name="username">

                    <label for="password">Password</label>
                    <input type="password" placeholder="Password" id="password" name="password">

                    <button name="submit">Prijavi se</button><br><br>

                    <p><?php echo $poruka; ?></p>

                    <a href="authentication-register.php">Registriraj se</a>
                </form>

            </div>


        </div>
    </body>
</html>