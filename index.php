<?php
$putanja = dirname($_SERVER['REQUEST_URI']);

if($putanja == "/azivko"){
    $putanja = "/azivko/webdip_projekt";
}
require "php/functions.php";

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Intelektualno vlasnistvo</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/content.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <style>
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
        </style>
    </head>
    <body>

        <!-- Menu -->
        <?php
        include "php/meni.php";
        ?>

        <!-- Content -->
        <div class="content" style="max-width:1100px;margin-top:80px;margin-bottom:80px">

            <div class="panel">
                <h1><b>Intelektualna vlasništva</b></h1>
            </div>

            <table class="tablica-popis">
                <caption>Poruke</caption>
                <thead>
                    <tr>
                        <th>id_poruke</th>
                        <th>id_status</th>
                        <th>kategorije</th>
                        <th>naslov</th>
                        <th>posiljatelj</th>
                        <th>primatelj</th>
                        <th>datum_vrijeme</th>
                        <th>sadrzaj</th>
                        <th>prilog</th>
                    </tr>
                </thead>

                <tbody> 
                    <tr>
                        <td colspan="9">testung</td>
                    </tr>
                    <tr>
                        <td colspan="9">testung</td>
                    </tr>
                    <tr>
                        <td colspan="9">testung</td>
                    </tr>
                    <tr>
                        <td colspan="9">testung</td>
                    </tr>
                    <tr>
                        <td colspan="9">testung</td>
                    </tr>
                    <tr>
                        <td colspan="9">testung</td>
                    </tr>
                </tbody>

                <tfoot>
                </tfoot>

            </table>
        </div>
    </body>
</html>