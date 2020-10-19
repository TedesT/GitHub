<?php
session_start();

require_once "data.php";
$currentPages = null;

//* Login action
if (array_key_exists("login", $_POST)) {
    if ($_POST["username"] == "admin" && $_POST["password"] == "admin") {
        $_SESSION["userId"] = $_POST["username"];
    } else {
        echo "Access denied!";
    }
}

//* Logout action
if (array_key_exists("logout", $_GET)) {
    unset($_SESSION["userId"]);
    header("location: ?");
}

//* Create new page
if (array_key_exists("new", $_GET)) {
    $currentPages = new Pages("", "", "");
}

//* Edit page
if (array_key_exists("edit", $_GET)) {
    $pageId = $_GET["edit"];
    $currentPages = $pageList[$pageId];
}

//* Update page
if (array_key_exists("update", $_POST)) {
    $newContent = $_POST["page-content"];

    //* Set properties - not saved in database
    $currentPages->setId($_POST["page-id"]);
    $currentPages->setTitle($_POST["page-title"]);
    $currentPages->setMenu($_POST["page-menu"]);
    //* Save to database
    $currentPages->updateMetaData();
    //* Update content
    $currentPages->setContent($newContent);

    header("location: ?edit={$currentPages->id}");
}

//* Delete page
if (array_key_exists("deletePage", $_GET)) {
    $pageIdToDelete = $_GET["deletePage"];
    $pageList[$pageIdToDelete]->deletePage();
    header("location: ?");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/admin.css">
    <title>Admin</title>
</head>

<body>
    <?php
    //* Show if logged in
    if (array_key_exists("userId", $_SESSION)) {
        echo "<button name='logout'><a href='?logout=true'>Log-out</a></button>";

        echo "<table border='1' cellpadding='0' cellspacing='0'>";
        foreach ($pageList as $actualPage) {
            echo "  <tr>
                        <td><a href='?edit={$actualPage->getId()}'>{$actualPage->getId()}</a></td>
                        <td><a href='?delete={$actualPage->getId()}'>Delete</a></td>
                    </tr>";
        }
        echo "</table>";
        echo "<a href='?new=true'>Create new page</a>";

        if ($currentPages != null) {
    ?>
            <form method="POST">
                <label for="id-input">ID</label>
                <input type="text" name="page-id" id="id-input" value="<?php echo $currentPages->getId(); ?>">
                <label for="title-input">Title</label>
                <input type="text" name="page-title" id="title-input" value="<?php echo $currentPages->getTitle(); ?>">
                <label for="menu-input">Menu</label>
                <input type="text" name="page-menu" id="menu-input" value="<?php echo $currentPages->getMenu(); ?>">
                <textarea name="page-content" id="textarea-content" cols="30" rows="40"><?php echo htmlspecialchars($currentPages->getContent()) ?></textarea>
                <input type="submit" name="update" value="Update page">
            </form>

            <script src="./vendor/tinymce/js/tinymce/tinymce.min.js"></script>
            <script>
                //selector: #idtextareay
                tinymce.init({
                    selector: "#textarea-content",
                    plugins: [
                        "advlist autolink link image lists charmap print preview hr anchor pagebreak",
                        "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
                        "table contextmenu directionality emoticons paste textcolor responsivefilemanager code"
                    ],
                    toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
                    toolbar2: "| responsivefilemanager | link unlink anchor | image media | forecolor backcolor  | print preview code ",
                    image_advtab: true,
                    external_filemanager_path: "vendor/responsive_filemanager/filemanager/",
                    external_plugins: {
                        "filemanager": "plugins/responsivefilemanager/plugin.min.js"
                    },
                    filemanager_title: "Responsive Filemanager",
                    entity_encoding: 'raw',
                    verify_html: false,
                    content_css: ["./css/style.css", "./css/content.css"]
                });
            </script>
        <?php
        }
    } else {
        ?>
        <div class="login">
            <table border='0' cellpadding='0' cellspacing='0'>
                <form method="post">
                    <tr>
                        <td>Username:</td>
                        <td><input type="text" name="username"></td>
                    </tr>
                    <tr>
                        <td>Password:</td>
                        <td><input type="password" name="password"></td>
                    </tr>
                    <tr>
                        <td><button name="login">Log-in</button></td>
                    </tr>
                </form>
            </table>
        </div>
    <?php
    }
    ?>
</body>

</html>