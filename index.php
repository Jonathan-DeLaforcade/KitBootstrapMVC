<?php
require_once("./Controllers/Router.php"); //Requirement du .php definissant la class router
$router = new Router(); //Initialisation de la classe router
$router->routerReq(); //Appel de la methode routeReq qui permet de gerer le routage vers les pages