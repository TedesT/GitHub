<?php
session_start();

require "seznamstranek.php";

//zpracovani prihlaseni
$chyba = null;
if (array_key_exists("prihlasit", $_POST)) 
{
    $jmeno = $_POST["jmeno"];
    $heslo = $_POST["heslo"];

    if ($jmeno == "admin" && $heslo == "admin") 
    {
        $_SESSION["prihlasen"] = true;
    } else {
        $chyba = "Nesprávné přihlašovací údaje";
    }
}

// zpracovani prihlaseni
if (array_key_exists("odhlasit", $_POST))
{
    unset($_SESSION["prihlasen"]);
}

// zjistim ktera stranka je vybrana
$vybranaStranka = null;
if (array_key_exists("stranka", $_GET))
{
    $idStranky = $_GET["stranka"];
    $vybranaStranka = $seznamStranek[$idStranky];
}

// Zpracovani ulozeni textarea
if (array_key_exists("ulozit", $_POST))
{
    $obsah = $_POST["obsah"];

    $vybranaStranka->ulozObsah($obsah);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/admin.css">
    <script src="lib/tinymce/js/tinymce/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="js/admin-tinymce.js"></script>
    <title>Admin</title>
</head>

<body>
<?php
	if (!array_key_exists("prihlasen", $_SESSION))
	{
        ?>
        <div class="login">
            <table border='0' cellpadding='0' cellspacing='0'>
                <form method="post">
                    <tr>
                        <td>Jméno:</td>
                        <td><input type="text" name="jmeno"></td>
                    </tr>
                    <tr>
                        <td>Heslo:</td>
                        <td><input type="password" name="heslo"></td>
                    </tr>
                    <tr>
                        <td><button name="prihlasit">Přihlásit</button></td>
                    </tr>
                </form>
            </table>
        </div>
		<?php
		if ($chyba != null)
		{
			echo "<div class='chyba'>$chyba</div>";
		}
		?>
	<?php
    }
    else
    {
        ?>

            <form method="POST">
                <button name="odhlasit">Odhlasit se</button>
            </form>
        <?php
        echo "<ul>";
            foreach ($seznamStranek as $stranka => $udaje)
            {
                echo "<li><a href='?stranka=$stranka'>$stranka</a></li>";
            }
        echo "</ul>";

        if ($vybranaStranka != null)
        { 
        echo "<h2>Editace stranky: {$vybranaStranka->getId()}</h2>";

        ?>
            <form method="POST">
                <textarea name="obsah" rows=20 cols=120><?php echo htmlspecialchars($vybranaStranka->getObsah()); ?></textarea>
                <br>
                <button name="ulozit">Uložit</button>
            </form>
        <?php
        }
    }
	?>
</body>

</html>