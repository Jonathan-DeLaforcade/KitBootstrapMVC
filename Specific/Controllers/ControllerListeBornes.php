<?php

$auth = new Auth;
$bdd = new Bdd;
$bdd = $bdd->getBdd();
$userID = $auth->getId();

$Table = new Table("dataTable",array("Nom","Token"),false);

$sql = "SELECT borneName, borneToken FROM borne WHERE ownerID =".$userID;
$result = $bdd->query($sql);

while ($row = $result->fetch_assoc()) {
    $Table->addLine(array($row["borneName"],"<a target=\"blank\" href=\"https://10.75.75.5/hCloud/?token=".$row["borneToken"]."\">".$row["borneToken"]."</a>"));
}

$ListeBornes = new Controller(true,0);
$ListeBornes->pageName = "ListeBornes";
$ListeBornes->scriptPerso = $Table->GenerateScript();
$ListeBornes->customVars["ListeBornes"] = $Table->Generate();
$ListeBornes->generate();
