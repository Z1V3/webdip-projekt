<?php
$putanja = dirname(dirname($_SERVER['REQUEST_URI']));

if ($putanja == "/azivko") {
    $putanja = "/azivko/webdip_projekt";
}
require "../php/functions.php";

if (isset($_POST["submit"])) {
    $name = $_POST["name"];
    $type = $_POST["type"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $username = $_SESSION["korisnik"];
    if (is_numeric($price) && strlen($description) < 100 && strlen($name) < 45) {
        $veza = new Baza();
        $veza->spojiDB();
        $upit = "SELECT * FROM korisnik WHERE korisnicko_ime = '{$username}'";
        $rezultat = $veza->selectDB($upit);
        $korisnik_id = "";
        while ($red = mysqli_fetch_array($rezultat)) {
            if ($red) {
                $korisnik_id = $red["korisnik_id"];
            }
        }
        $targetDirectory = "../multimedia/"; 
        $targetFile = $targetDirectory . basename($_FILES["image"]["name"]);
        $targetFileName = basename($_FILES["image"]["name"]);
        
        $message = "";
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            $message = "The file has been uploaded successfully.";
        } else {
            $message = "Sorry, there was an error uploading your file.";
        }

        $upit = "INSERT INTO intelektualno_vlasnistvo (naziv_intelektualno_vlasnistvo, opis_intelektualno_vlasnistvo, slika, cijena_koristenja, tip_intelektualnog_vlasnistva_id, korisnik_id, status_id) VALUES ( '{$name}', '{$description}', '{$targetFileName}', '{$price}','{$type}', '{$korisnik_id}', '3')";
        $veza->selectDB($upit);
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
        <link href="https://fonts.cdnfonts.com/css/bahnschrift" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
        <script src="../js/ajax.js"></script>
        <style>
            html,body,h1,h2,h3,h4 {
                font-family:"Bahnschrift"
            }
            .panel{
                position: absolute;
                top: 10%;
                left: 37%;
            }
            .background{
                position: fixed;
                z-index: 0;
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
                color: #eee;
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

            .selectdiv {
                position: relative;
                /*Don't really need this just for demo styling*/

                min-width: 200px;
                margin: 50px 33%;
            }

            /* IE11 hide native button (thanks Matt!) */
            select::-ms-expand {
                display: none;
            }

            .selectdiv:after {
                content: '<>';
                font: 17px "Consolas", monospace;
                color: #333;
                -webkit-transform: rotate(90deg);
                -moz-transform: rotate(90deg);
                -ms-transform: rotate(90deg);
                transform: rotate(90deg);
                right: 11px;
                /*Adjust for position however you want*/

                top: 18px;
                padding: 0 0 2px;
                border-bottom: 1px solid #999;
                /*left line */

                position: absolute;
                pointer-events: none;
            }

            .selectdiv select {
                -webkit-appearance: none;
                -moz-appearance: none;
                appearance: none;
                /* Add some styling */

                width: 100%;
                max-width: 320px;
                height: 50px;
                margin: 5px 0px;
                padding: 0px 24px;
                font-size: 16px;
                line-height: 1.75;
                color: #333;
                background-color: #ffffff;
                background-image: none;
                border: 1px solid #cccccc;
                -ms-word-break: normal;
                word-break: normal;
            }

        </style>
    </head>
    <body>

        <!-- Menu -->
        <?php
        include "../php/meni.php";
        ?>

        <img src="../multimedia/abstract.jpg" class="background" alt="abstract.jpg">
        <!-- Content -->
        <div class="content" style="max-width:1100px;margin-top:80px;margin-bottom:80px">

            <div class="panel">
                <h1><b>Intelektualna vlasništva</b></h1>
            </div>


            <form class="form" novalidate method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>" enctype=multipart/form-data>
                <div class="title">Kreiranje zahtjeva</div>
                <div class="subtitle">Ovdje upišite podatke</div>
                <div class="input-container inpu1">
                    <input id="name" class="input" type="text" name="name" placeholder=" " />
                    <div class="cut"></div>
                    <label for="firstname" class="placeholder">Naziv</label>
                </div>

                <div class="input-container input2 selectdiv">
                    <label>
                        <select name="type" id="type">
                            <option selected value="0">Patent</option>
                            <option value="1">Naziv domene</option>
                            <option value="2">Izum</option>
                            <option value="3">Prava na bazu podataka</option>
                            <option value="4">Robni zig</option>
                        </select>
                    </label>
                </div>

                <div class="input-container input3">
                    <textarea id="description" class="textarea" name="description" type="text" placeholder=" "></textarea>
                    <div class="cut"></div>
                    <label for="lastname" class="placeholder">Opis</label>
                </div>
                <input type="file" name="image" id="image" style="margin-bottom: 40px;">
                <div class="input-container input4">
                    <input id="email" class="input" name="price" type="text" placeholder=" " />
                    <div class="cut "></div>
                    <label for="email" class="placeholder">Cijena</>
                </div>
                <?php echo "<div style='float: right; margin-top: 20px; margin-right: 20px; font-size: 20px;'>" . $message . "</div>";?>
                <button type="text" class="submit" name="submit">Kreiraj</button>
            </form>
        </div>
    </body>
</html>