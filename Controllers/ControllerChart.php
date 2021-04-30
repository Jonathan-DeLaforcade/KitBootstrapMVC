<?php


$Chart = new LineChart("lineChart1",array("sep","oct","nov","dec","jan","feb"));
$Chart->AddLine("test1",array(1,2,3,4,5,6),'rgba(255, 0, 0, 0.2)');
$Chart->AddLine("test2",array(5,6,7,8,9,10),'rgba(0, 255, 0, 0.2)');
$Chart->AddLine("test3",array(5,2,6,5,8,4),'rgba(0, 0, 255, 0.2)');
$Chart->AddLine("test4",array(8,6,2,10,15,1));

$ChartPage = new Controller() ;
$ChartPage->pageName = "Chart";
$ChartPage->scriptPerso = $Chart->Generate();
//$ChartPage->customVars["stats"] = array("Modules" => 0, "Praticiens" => 0, "Flash" => 0);
$ChartPage->generate();