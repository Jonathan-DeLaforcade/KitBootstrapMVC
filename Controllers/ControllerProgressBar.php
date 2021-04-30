<?php


$ProgressBar = new ProgressBar;

for($i = 0; $i <= 100; $i+=7) {
    $ProgressBar->addBar("test".$i,$i);
}

$ProgreBarPage = new Controller() ;
$ProgreBarPage->pageName = "ProgressBar";
$ProgreBarPage->scriptPerso = "";
$ProgreBarPage->customVars["progress"] = $ProgressBar->GenerateHTML();
$ProgreBarPage->generate();