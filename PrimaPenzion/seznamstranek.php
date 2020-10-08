<?php
class Stranka
{
    protected $id;
    protected $titulek;
    protected $menu;

    function __construct($id, $titulek, $menu)
    {
        $this->id = $id;
        $this->titulek = $titulek;
        $this->menu = $menu;
    }

    function getId()
    {
        return $this->id;
    }

    function getTitulek()
    {
        return $this->titulek;
    }

    function getMenu()
    {
        return $this->menu;
    }

    function getObsah()
    {
        return file_get_contents("$this->id.html");
    }
    
    function ulozObsah($obsah)
    {
        file_put_contents("$this->id.html", $obsah);
    }
}

/*
$seznamStranek = array(
	"domu" => array(
		"titulek" => "PrimaPenzion",
		"menu" => "Domů",
	),
	"kontakt" => array(
		"titulek" => "Jak nás kontaktujete",
		"menu" => "Kontakt",
	),
	"galerie" => array(
		"titulek" => "Fotky pokojů",
		"menu" => "Galerie",
	),
	"rezervace" => array(
		"titulek" => "Objednávka pokojů",
		"menu" => "Rezervace",
    ),
	"404" => array(
		"titulek" => "Stránka neexistuje",
		"menu" => "",
	),
);
*/

$seznamStranek = array(
    "domu" => new Stranka("domu", "PrimaPenzion", "Domů"),
    "kontakt" => new Stranka("kontakt", "Jak nás kontaktujete", "Kontakt"),
    "galerie" => new Stranka("galerie", "Fotky pokojů", "Galerie"),
    "rezervace" => new Stranka("rezervace", "Objednávka pokojů", "Rezervace"),
    "404" => new Stranka("404", "Stránka neexistuje", ""),
);