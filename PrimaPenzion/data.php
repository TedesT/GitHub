<?php
$db = new PDO(
    "mysql:host=localhost;dbname=primapenzion;charset=utf8",
    "root",
    "",
    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
);

class Pages
{
    private $id;
    private $oldId;
    private $title;
    private $menu;

    function __construct($agrId, $agrTitle, $agrMenu)
    {
        $this->id = $agrId;
        $this->title = $agrTitle;
        $this->menu = $agrMenu;
    }

    function getTitle()
    {
        return $this->title;
    }
    function setTitle($newTitle)
    {
        $this->title = $newTitle;
    }

    function getId()
    {
        return $this->id;
    }
    function setId($newId)
    {
        $this->oldId = $this->id;
        $this->id = $newId;
    }

    function getMenu()
    {
        return $this->menu;
    }
    function setMenu($newMenu)
    {
        $this->menu = $newMenu;
    }

    function getContent()
    {
        $query = $GLOBALS["db"]->prepare("SELECT * FROM pages WHERE id=?");
        $query->execute([$this->id]);
        $row = $query->fetch();

        if ($row) {
            return $row["content"];
        } else {
            return "";
        }
    }
    function setContent($pageContent)
    {
        $query = $GLOBALS["db"]->prepare("UPDATE pages SET content=? WHERE id=?");
        $query->execute([$pageContent, $this->id]);
    }

    function updateMetaData()
    {
        if ($this->oldId != null) {
            $query = $GLOBALS["db"]->prepare("UPDATE pages SET id=?, title=?, menu=? WHERE id=?");
            $query->execute([$this->id, $this->title, $this->menu, $this->oldId]);
        } else {
            $query = $GLOBALS["db"]->prepare("SELECT max(ord) AS ord FROM pages");
            $query->execute();
            $row = $query->fetch();

            if ($row) {
                $maxOrd = $row["ord"];
            } else {
                $maxOrd = 0;
            }

            $query = $GLOBALS["db"]->prepare("INSERT pages SET id=?, title=?, menu=?, ord=?");
            $query->execute([$this->id, $this->title, $this->menu, $maxOrd + 1]);
        }
    }

    function deletePage()
    {
        $query = $GLOBALS["db"]->prepare("DELETE FROM pages WHERE id=?");
        $query->execute([$this->id]);
    }
}

//* Getting data from database -> pages instances
$pageList = [];

$query = $db->prepare("SELECT * FROM pages ORDER BY ord ASC");
$query->execute();

$rows = $query->fetchAll();
foreach ($rows as $row) {
    $pageList[$row["id"]] = new Pages($row["id"], $row["title"], $row["menu"]);
}
