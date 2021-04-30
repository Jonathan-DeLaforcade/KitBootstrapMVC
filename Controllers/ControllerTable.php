<?php


$Table = new Table("dataTable",array("nom","prenom"),true);
for ($i = 1; $i<=50; $i++) {
    $Table->addLine(array("nom".$i,"prenom".$i));
}

$TablePage = new Controller() ;
$TablePage->pageName = "Table";
$TablePage->scriptPerso = $Table->GenerateScript();
$TablePage->customVars["table"] = $Table->Generate();
$TablePage->generate();