<?php

require_once("./Views/View.php"); //Integration du fichier contenant la class View necesaire a l'affichage des pages
class Router {
    
    public function routerReq() {
        try {
            $url = "";
            //CHARGEMENT AUTOMATIQUE DES CLASS
            spl_autoload_register(function($class) {
                if ($class != "mysqli"){
                    require_once("./Models/".$class.".php");
                }
            });
            // LE CONTROLLER EST INCLUS SELON L'ACTION DE L'USER

            if (isset($_GET["url"])) {
                $url = explode('/',filter_var($_GET["url"],FILTER_SANITIZE_URL)); //Permet de separer l'url en un tableau
                $controller = ucfirst($url[0]);
                $controllerClass = "Controller".$controller;
                $viewClass = "View".$controller;
                $controllerFile = "./Controllers/".$controllerClass.".php";
                $viewFile = "./Views/".$viewClass.".php";
                if(file_exists($controllerFile) && file_exists($viewFile))
                {
                    require_once($controllerFile);
                }
                else {
                    throw new Exception("Page Introuvable");
                }
            } elseif (isset($_GET["p"])) {
                $url = explode('/',filter_var($_GET["p"],FILTER_SANITIZE_URL)); //Permet de separer l'url en un tableau
                $controller = ucfirst($url[0]);
                $controllerClass = "Controller".$controller;
                $viewClass = "View".$controller;
                $controllerFile = "./Specific/Controllers/".$controllerClass.".php";
                $viewFile = "./Specific/Views/".$viewClass.".php";
                if(file_exists($controllerFile) && file_exists($viewFile))
                {
                    require_once($controllerFile);
                }
                else {
                    throw new Exception("Page Introuvable");
                }
            } else {
                require_once("./Controllers/ControllerHome.php");
            }
        }

        //GESTION DES ERREURS
        catch(Exception $e) {
            $errorMsg = $e->getMessage();
            $error404 = new Controller(false,"404",0);
            $error404->pageName = "404";
            $error404->customVars["errorMsg"] = $errorMsg;
            $error404->generate();
        }
    }
}
