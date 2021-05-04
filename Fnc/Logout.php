<?php
require_once("../Models/Bdd.php");
require_once("../Models/Model.php");
require_once("../Models/Session.php");
require_once("../Models/Params.php");
require_once("../Models/Auth.php");

$auth = new Auth;
$auth->logout();
header('Location: ../index.php?url=Home');