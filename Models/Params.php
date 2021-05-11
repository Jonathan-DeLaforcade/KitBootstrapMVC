<?php

class Params {
    private $globalVersion = 2.1;
    private $localVersion = 1.0;
    private $allowRegister = False;
    private $allowRecoveryPassword = True;
    private $mailAdmin = "admin@kitbootstrap.fr";
    private $mailServeur = "contact@kitbootstrap.fr";
    private $salt = "YourPersonalWebsiteSalt";

    private $bddHost = "127.0.0.1";
    private $bddPort = "3306";
    private $bddLogin = "kitBootstrap";
    private $bddPassword = "kitBootstrap";
    private $bddBase = "kitBootstrap";

    private $menuItems = Array(
        Array("Accueils", "Home", "fa-cogs",false),
        Array("Liste des bornes","ListeBornes", "fas fa-chart-bar",true),
        Array("Liste des sessions","ListeSessions", "fas fa-chart-bar",true)
    );

    public function getGlobalVersion() {
        /*───────────────────────────────────────────────────────────────────────────────────────────┐
        │   Numéro de version: 1.0                                                                   │
        │   - Début du projet en suivant la méthode MVC                                              │
        │                                                                                            │
        │   Numéro de version: 2.0                                                                   │
        │   - Ajout de Models (chart, LineChart, NiceTumbnail, Card)                                 │
        │   - Ajout de la gestion de session (login, logour, register)                               │
        │   - remise en forme du code pour le rendre plus propre                                     │
        │                                                                                            │   
        │   Numéro de version: 2.1                                                                   │
        │   - Ajout de la gestion des mots de passe oublié                                           │
        │   - Sécurisation du login et du token                                                      │
        │   - Ajout du models progressbar                                                            │
        │   - Ajout du dossier Specific pour l'ajout de pages et la modification de pages existante  │
        └───────────────────────────────────────────────────────────────────────────────────────────*/
        return $this->globalVersion;
    }

    public function getParam($paramName) {
        return $this->$paramName;
    }

    public function getLocalVersion() {
        return $this->localVersion;
    }
    public function getAllowRegister() {
        return $this->allowRegister;
    }

    public function getAllowPassRecovery() {
        return $this->allowRecoveryPassword;
    }

    public function getMenuItems() {
        return $this->menuItems;
    }

    public function getSalt() {
        return $this->salt;
    }

    public function getMailServeur() {
        return $this->mailServeur;
    }
}