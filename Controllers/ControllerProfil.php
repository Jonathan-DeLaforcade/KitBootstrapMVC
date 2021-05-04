<?php

$ProfilIsUpdated = False;
$updateIsOk = True;
$updateMessage = "";
$auth = new Auth;
$param = new Params;
$JS = "";

if ((isset($_POST["UserName"])) && (is_string($_POST["UserName"])) && ($_POST["UserName"] != "")) {
    $ProfilIsUpdated = True;
    $updateIsOk = $auth->changeUserData("Pseudo", $_POST["UserName"]);
}
if ((isset($_POST["UserMail"])) && (is_string($_POST["UserMail"])) && ($_POST["UserMail"] != "")) {
    $ProfilIsUpdated = True;
    $updateIsOk = $auth->changeUserData("Mail", $_POST["UserMail"]);
}
if ((isset($_POST["UserNewPass1"])) && (is_string($_POST["UserNewPass1"])) && ($_POST["UserNewPass1"] != "")) {
    if ((isset($_POST["UserOldPass"])) && (is_string($_POST["UserOldPass"])) && ($_POST["UserOldPass"] != "")) {
        $ProfilIsUpdated = True;
        if ((isset($_POST["UserNewPass2"]))  && (is_string($_POST["UserNewPass2"])) && ($_POST["UserNewPass2"] != "")){
            if ($_POST["UserNewPass1"] == $_POST["UserNewPass2"]){
                if ($auth->verifPassOkWithID($auth->getId(), $_POST["UserOldPass"])) {
                    $newPass = $_POST["UserNewPass1"];
                    $newpass = $param->getSalt().$_POST["UserNewPass1"];
                    $newPass = hash('sha256',$newpass);
                    $updateIsOk = $auth->changeUserData("Password",$newPass);
                } else {$updateIsOk = False; $updateMessage = "Votre ancien mot de passe est incorrecte";}
            } else {$updateIsOk = False; $updateMessage = "Les deux mot de passe ne sont pas identique";}
        } else {$updateIsOk = False; $updateMessage = "Veuillez confirmer votre nouveau mot de passe";}
    } else {$updateIsOk = False; $updateMessage = "Veuillez entrer votre ancien mot de passe";}
}


if ($ProfilIsUpdated) {
    if ($updateIsOk) {
        ob_start();
        ?>
            <script>
                Swal.fire(
                    'Informations mise à jour!',
                    'Vos informations de profil on été mise à jour<br /><?=$updateMessage?>',
                    'success'
                )
            </script>  
        <?php
        $JS .= ob_get_clean();
    }
    else {
        ob_start();
        ?>
            <script>
                Swal.fire(
                    'Informations non sauvargdé !',
                    'Une erreur a eu lieux dans la sauvegarde de vos informations, merci de les verifier les informations ci-dessous et reesayer:<br /><br /><?=$updateMessage?>',
                    'error'
                )
            </script>  
        <?php
        $JS .= ob_get_clean();
    }
}


$Profil = new Controller() ;
$auth = new Auth();
$Profil->pageName = "Profil";

$userName = $auth->getUsername();
$userMail = $auth->getMail();

$form = new Form("./?url=Profil",true);
$form->createInput('UserName','username','Votre pseudo','',$userName);
$form->createInput('UserMail','email','Votre Mail','',$userMail);
$form->createInput('UserOldPass','password','Votre ancien mot de passe');
$form->createInput('UserNewPass1','password','Votre nouveau mot de passe');
$form->createInput('UserNewPass2','password','Votre nouveau mot de passe (verification)');
$form->createSubmit('Sauvegarder mon profil','ValidationEvent()');

$card = new Card("Profil",$form->generateHTML());
$card = $card->GenerateHTML();

$JS .= $form->generateJS();

$Profil->customVars["card"] = $card;
$Profil->scriptPerso = $JS;
$Profil->generate() ;
