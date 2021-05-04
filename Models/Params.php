<?php

class Params {
    private $globalVersion = 2.0;
    private $localVersion = 1.0;
    private $allowRegister = False;
    private $allowRecoveryPassword = True;
    private $salt = "BqhSqk3YxP9QqTG8";


    private $menuItems = Array(
        Array("Accueils", "Home", "fa-cogs"),
        Array("Chart", "Chart", "fas fa-chart-bar"),
        Array("Table", "Table", "fas fa-table"),
        Array("NiceTumbnail", "NiceTumbnail", "fas fa-table"),
        Array("CircleChart", "CircleChart", "fas fa-table"),
        Array("Card", "Card", "fas fa-table"),
        Array("Progress Bar", "ProgressBar", "fas fa-bars")
    );

    public function getGlobalVersion() {
        /*──────────────────────────────────────────────────────────────────┐
        │   Numéro de version: 1.0                                          │
        │   - Début du projet en suivant la méthode MVC                     │
        │                                                                   │
        │   Numéro de version: 2.0                                          │
        │   - Ajout de Models (chart, LineChart, NiceTumbnail, Card)        │
        │   - Ajout de la gestion de session (login, logour, register)      │
        │   - remise en forme du code pour le rendre plus propre            │
        └──────────────────────────────────────────────────────────────────*/
        return $this->globalVersion;
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
}