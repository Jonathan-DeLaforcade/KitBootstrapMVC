<?php

$auth = new Auth;
$userID = $auth->getId();

$Table = new Table("dataTable",array("nom","prenom"),true);



for ($i = 1; $i<=50; $i++) {
    $Table->addLine(array("nom".$i,"prenom".$i));
}

$ListeBornes = new Controller(true,1);
$ListeBornes->pageName = "ListeSessions";
$ListeBornes->scriptPerso = $Table->GenerateScript();
$ListeBornes->customVars["ListeBornes"] = $Table->Generate();
$ListeBornes->generate();
