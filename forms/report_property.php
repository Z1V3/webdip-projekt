<?php
$putanja = dirname(dirname($_SERVER['REQUEST_URI']));

require "../php/functions.php";

if (isset($_POST["submit"])) {
    $veza = new Baza();
    $veza->spojiDB();

    if (isset($_POST["id"]) && isset($_POST["description"]) && isset($_POST["name"]) && is_numeric($_POST["id"]) && strlen($_POST["description"]) < 300 && strlen($_POST["name"]) < 45) {
        $upit = "SELECT * FROM korisnik WHERE korisnicko_ime = '{$_SESSION["korisnik"]}'";
        $rezultat = $veza->selectDB($upit);
        $user_id;
        while ($red = mysqli_fetch_array($rezultat)) {
            if ($red) {
                $user_id = $red["korisnik_id"];
            }
        }

        $user_id = intval($user_id);
        
        $upit = "INSERT INTO prijava (naslov, razlog, intelektualno_vlasnistvo_id, korisnik_id) VALUES ('{$_POST["name"]}', '{$_POST["description"]}', '{$_POST["id"]}', '{$user_id}')";
        if ($veza->selectDB($upit)) {
            $message = "Prijava uspjesno poslana!";
            zapisiDnevnik(6, $user_id, $_POST["id"]);
            $veza->zatvoriDB();
            header("Location: ../index.php?message=report_uspjeh");
            exit();
        } else {
            $message = "Greska kod slanja prijave!";
            $veza->zatvoriDB();
        }
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
        <link href="https://fonts.cdnfonts.com/css/bahnschrift" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
        <script src="../js/ajax.js"></script>
        <style>
            html,body,h1,h2,h3,h4 {
                font-family:"Bahnschrift";
            }
            html{
                background: #1e202b;
            }

            .panel{
                position: absolute;
                top: 10%;
                left: 37%;
            }

            h3,p,span {
                color: black;
            }
            h3,span {
                font-size: 30px;
            }

            .background{
                position: fixed;
                z-index: -1;
                width: 1080px;
                left: 0%;
                top: 0%;
            }

            .form {
                position: absolute;
                top: 27%;
                left: 35%;
                z-index: 1;
                background-color: white;
                box-shadow: 20px 20px #525E6C;
                border-radius: 25px;
                box-sizing: border-box;
                height: 800px;
                padding: 20px;
                width: 920px;
            }

            .title {
                color: black;
                font-size: 36px;
                font-weight: 600;
                margin-top: 10px;
            }

            .subtitle {
                color: black;
                font-size: 16px;
                font-weight: 600;
                margin-top: 10px;
            }

            .input-container {
                height: 50px;
                position: relative;
                width: 100%;
            }

            .inpu1 {
                margin-top: 40px;
                margin-bottom: 40px;
            }

            .input3 {
                margin-top: 40px;
                margin-bottom: 180px;
            }

            .input {
                background-color: lightgray;
                border-radius: 12px;
                border: 0;
                box-sizing: border-box;
                color: black;
                font-size: 18px;
                height: 100%;
                outline: 0;
                padding: 4px 20px 0;
                width: 100%;
            }

            .cut {
                background-color: white;
                border-radius: 10px;
                height: 20px;
                left: 20px;
                position: absolute;
                top: -20px;
                transform: translateY(0);
                transition: transform 200ms;
                width: 76px;
            }


            .input:focus ~ .cut,
            .input:not(:placeholder-shown) ~ .cut {
                transform: translateY(8px);
            }
            .textarea:focus ~ .cut,
            .textarea:not(:placeholder-shown) ~ .cut {
                transform: translateY(8px);
            }

            .placeholder {
                color: #65657b;
                left: 20px;
                line-height: 14px;
                pointer-events: none;
                position: absolute;
                transform-origin: 0 50%;
                transition: transform 200ms, color 200ms;
                top: 20px;
            }

            .input:focus ~ .placeholder,
            .input:not(:placeholder-shown) ~ .placeholder {
                transform: translateY(-30px) translateX(10px) scale(0.75);
            }
            .textarea:focus ~ .placeholder,
            .textarea:not(:placeholder-shown) ~ .placeholder {
                transform: translateY(-30px) translateX(10px) scale(0.75);
            }

            .submit {
                background-color: #E94555;
                border-radius: 12px;
                border: 0;
                box-sizing: border-box;
                color: #eee;
                cursor: pointer;
                font-size: 18px;
                height: 50px;
                margin-top: 38px;
                text-align: center;
                width: 20%;
            }

            .submit:hover {
                background-color: #f58792;
            }

            .textarea{
                background-color: lightgray;
                border-radius: 12px;
                border: 0;
                box-sizing: border-box;
                color: #eee;
                font-size: 18px;
                height: 200px;
                outline: 0;
                padding: 4px 20px 0;
                width: 100%;
            }

        </style>
    </head>
    <body>

        <!-- Menu -->
        <?php
        include "../php/meni.php";
        ?>

        <img src="../multimedia/abstract.jpg" class="background">
        <!-- Content -->
        <div class="content" style="max-width:1100px;margin-top:80px;margin-bottom:80px">

            <div class="panel">
                <h1><b>Intelektualna vlasništva</b></h1>
            </div>

            <form class="form" novalidate method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>" onsubmit="provjeri()">
                <div class="title">Kreiranje prijave</div>
                <div class="subtitle">Ovdje upišite podatke</div>
                <div class="input-container inpu1">
                    <input id="property_id" class="input" type="text" name="id" placeholder=" " value="<?php echo $_GET["id"]; ?>" onkeyup="postoji()"/>
                    <div class="cut"></div>
                    <label for="firstname" class="placeholder">ID</label>
                    <label id="error_label"></label>
                </div>

                <div class="input-container input2">
                    <input id="name" class="input" type="text" name="name" placeholder=" " />
                    <div class="cut"></div>
                    <label for="firstname" class="placeholder">Naziv</label>
                </div>

                <div class="input-container input3">
                    <textarea id="description" class="textarea" name="description" type="text" placeholder=" "></textarea>
                    <div class="cut"></div>
                    <label for="lastname" class="placeholder">Opis prijave</label>
                </div>
                <div class="input-container input4">

                </div>
                <?php echo "<div style='float: right; margin-top: 20px; margin-right: 20px; font-size: 20px;'>" . $message . "</div>"; ?>
                <button type="text" id="submit_button" class="submit" name="submit">Posalji prijavu</button>
            </form>


        </div>

        <script>
            function provjeri() {
                var property_id = document.getElementById("property_id").value;
                if (isNaN(property_id)) {
                    alert("Broj vlasnistva mora biti numericki znak!");
                    event.preventDefault();
                    return;
                }
            }

            function postoji() {
                var property_id = document.getElementById("property_id").value;
                if (isNaN(property_id)) {
                    document.getElementById("error_label").innerHTML = "Broj vlasnistva mora biti numericki znak!";
                    document.getElementById("property_id").value="";
                    return;
                }else if(property_id === null || property_id === 'undefined' || property_id.indexOf(" ") >= 0 || property_id === ''){
                    document.getElementById("error_label").innerHTML = "Broj vlasnistva ne smije biti prazan ili sadrzavati razmak!";
                    return;
                } else {
                    $.ajax({
                        type: "GET",
                        url: "../php/report.php",
                        data: {property_id: property_id},
                        success: function (result) {
                            console.log(typeof result + " " + result);
                            if(result === "0"){
                                document.getElementById("error_label").innerHTML="ID ne postoji!";
                            }else{
                                document.getElementById("error_label").innerHTML="";
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error('Error:', error);
                        }
                    });
                }
            }
        </script>
    </body>
</html>