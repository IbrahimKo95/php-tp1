<?php

namespace App\Controllers;

use App\Core\View;
use App\Core\SQL;

class page
{
    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function home()
    {
        $view = new View("page/home.php");
    }

    public function show(){
        $pageId = $_GET["id"];
        //Me connecter à la bdd
        $sql = new SQL();
        //Faire une requete sql pour récupérer la page avec l'id
        $result = $sql->getOneById("pages", $pageId);
        //Créer une vue et envoyer à la vue toutes les informations provenant
        //de la BDD
        $view = new View("Page/show.php");
        $view->addData("content", $result["content"]);
        $view->addData("title", $result["title"]);
        $view->addData("description", $result["description"]);
        $view->addData("created", $result["date_created"]);

    }
    public function dashboard () {
        require "../Views/Page/dashboard.php";

    }
}