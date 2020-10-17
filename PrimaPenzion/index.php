<?php
require_once "data.php";

//* Open desired pages
if (array_key_exists("pages", $_GET)) {
    $pages = $_GET["pages"];
} else {
    $pages = array_keys($pageList)[0];
}

//* Check if pages exist - if not than 404
if (!array_key_exists($pages, $pageList)) {
    $pages = "404";
    http_response_code(404);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Krona+One&display=swap" rel="stylesheet">
    <link rel="shortcut icon" type="image/png" href="upload/thumbs/favicon.png">
    <title><?php echo $pageList[$pages]->getTitle(); ?></title>
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
                <a href="?page=home">
                    <p>Prima</p>
                    <p>Penzion</p>
                </a>
            </div>

            <div class="main_menu">
                <ul>
                    <?php
                    foreach ($pageList as $pageName) {
                        if ($pageName->getId() != "404") {
                            echo "<li><a href='{$pageName->getId()}'>{$pageName->getMenu()}</a></li>";
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>
    </header>

    <div class="container">
        <section class="showcase_<?php echo $pages; ?>"></section>
    </div>

    <?php
    echo $pageList[$pages]->getContent();
    ?>

    <div class="container">
        <section class="footer">
            <div class="main_menu">
                <ul>
                    <?php
                    foreach ($pageList as $pageName) {
                        if ($pageName->getId() != "404") {
                            echo "<li><a href='{$pageName->getId()}'>{$pageName->getMenu()}</a></li>";
                        }
                    }
                    ?>
                </ul>
            </div>

            <div class="footer_logo">
                <a href="?page=home" class="logo_h">
                    <p>Prima</p>
                    <p>Penzion</p>
                </a>
            </div>

            <div class="address">
                <i class="fas fa-globe-europe"></i>
                <a href="https://goo.gl/maps/CXV5vPzUhGGJ3XwS8" target="_blank"><strong>PrimaPenzion</strong>, Jablonského 640, Praha 7</a>
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