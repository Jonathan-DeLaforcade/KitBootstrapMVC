<?php


$card1 = new Card("test","lorem lorem lorem lorem lorem lorem lorem lorem lorem","collapse",array("*header:","truc1","-","truc2"));
$card2 = new Card("test","lorem lorem lorem lorem lorem lorem lorem lorem lorem","collapse",array("*header:","truc1","-","truc2"));
$card3 = new Card("test","lorem lorem lorem lorem lorem lorem lorem lorem lorem");

$CardPage = new Controller() ;
$CardPage->pageName = "Card";
//$CardPage->scriptPerso = $Table->GenerateScript();
$CardPage->customVars["card1"] = $card1->GenerateHTML();
$CardPage->customVars["card2"] = $card2->GenerateHTML();
$CardPage->customVars["card3"] = $card3->GenerateHTML();
$CardPage->generate();