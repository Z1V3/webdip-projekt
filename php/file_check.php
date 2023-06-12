<?php

if (file_exists("../multimedia/" .$_GET["file"])) {
    echo "1";
} else {
    echo "0";
}