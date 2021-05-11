<?php


$tumb1 = new NiceTumbnail("test1",65,"percent","fas fa-exclamation-triangle","danger");
$tumb2 = new NiceTumbnail("test2",2000);
$tumb3 = new NiceTumbnail("test3",3000);
$tumb4 = new NiceTumbnail("test4",4000);

$NiceTumbnail = new Controller() ;
$NiceTumbnail->pageName = "NiceTumbnail";
$NiceTumbnail->scriptPerso = "";
$NiceTumbnail->customVars["tumb1"] = $tumb1->Generate();
$NiceTumbnail->customVars["tumb2"] = $tumb2->Generate();
$NiceTumbnail->customVars["tumb3"] = $tumb3->Generate();
$NiceTumbnail->customVars["tumb4"] = $tumb4->Generate();
$NiceTumbnail->generate() ;
