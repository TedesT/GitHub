<?php

require "seznamstranek.php";
// pokud uzivatel zvolil nejakou stranku tak mu ji zobrazime
// pokud prisel aniz by neco zvolil tak mu zobrazime stranku
// "Domu"
if(array_key_exists("stranka", $_GET))
{
    $stranka = $_GET["stranka"];
}
else
{
    $stranka = "domu";
}
// potrebujeme zkontrolovat zdali vybrana stranka
// existuje. A pokud neexistuje tak misto toho
// zobrazime nahradni stranku
if (!array_key_exists($stranka, $seznamStranek))
{
    $stranka = "404";
    //sdelime vyhledavaci ze stranka neexistuje
    http_response_code(404);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/style.css">
    <link rel="stylesheet" href="./style/content.css">
    <link rel="stylesheet" href="./style/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Krona+One&display=swap" rel="stylesheet">
    <link rel="shortcut icon" type="image/png" href="./img/favicon.png">
    <title><?php echo $seznamStranek[$stranka]->getTitulek() ?></title>
</head>

<body>
    <header>
        <div class="container">
            <div class="contacts">

                <div class="mobile">
                    <a href="tel:+420606123456">+420 606 123 456</a>
                </div>

                <div class="social">
                    <a href="https://www.instagram.com/primakurzy_cz/" target="_blank"><i class="fab fa-instagram"></i></a>
                    <a href="https://www.facebook.com/PrimaKurzy/" target="_blank"><i class="fab fa-facebook-square"></i></a>
                </div>
            </div>

            <div class="logo">
                <a href="./index.html" class="logo_h">
                    <p>Prima</p>
                    <p>Penzion</p>
                </a>
            </div>

            <div class="main_menu">
                <ul>
                    <?php
                    foreach($seznamStranek as $jmenoStranka => $udaje)
                    {
                        if($jmenoStranka !="404")
                        echo "<li><a href='$jmenoStranka'>{$udaje->getMenu()}</a></li>";
                    }
                    ?>
                    <!--
                    <li><a href="?stranka=domu">Domu</a></li>
                    <li><a href="?stranka=kontakt">Kontakt</a></li>
                    <li><a href="?stranka=galerie">Galerie</a></li>
                    <li><a href="?stranka=rezervace">Rezervace</a></li>
                    -->
                </ul>
            </div>
        </div>
    </header>

    <div class="container">
        <section class="showcase_<?php echo $stranka;?>">
        </section>
    </div>

        <?php
            echo $seznamStranek[$stranka]->getObsah();
        ?>

    <div class="container">
        <section class="footer">
            <div class="main_menu">
                <ul>
                    <?php
                    foreach($seznamStranek as $jmenoStranka => $udaje)
                    {
                        if($jmenoStranka !="404")
                        echo "<li><a href='$jmenoStranka'>{$udaje->getMenu()}</a></li>";
                    }
                    ?>
                </ul>
            </div>

            <div class="footer_logo">
                <a href="?stranka=domu" class="logo_h">
                    <p>Prima</p>
                    <p>Penzion</p>
                </a>
            </div>

            <div class="address">
                <i class="fas fa-globe-europe"></i>
                <a href="https://goo.gl/maps/CXV5vPzUhGGJ3XwS8" target="_blank"><strong>PrimaPenzion</strong>, Jablonskeho 640, Praha 7</a>
            </div>

            <div class="call">
                <i class="fas fa-mobile-alt"></i>
                <a href="tel:+420606123456">+420 606 123 456</a>
            </div>

            <div class="email">
                <i class="far fa-paper-plane"></i>
                <a href="#">info@primapenzion.cz</a>
            </div>

            <div class="footer_social">
                <a href="https://www.instagram.com/primakurzy_cz/" target="_blank"><i class="fab fa-instagram"></i></a>
                <a href="https://www.facebook.com/PrimaKurzy/" target="_blank"><i class="fab fa-facebook-square"></i></a>
            </div>
        </section>
    </div>

</body>

</html>