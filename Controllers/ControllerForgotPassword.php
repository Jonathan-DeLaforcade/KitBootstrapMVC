<?php

$JS = "";

$auth = new Auth;
$params = new Params;


if (($auth->getRole() > 0) || !($params->getAllowPassRecovery())) {
    header('Location: ../index.php?url=Home');
}

if ((isset($_POST['userMail'])) && (is_string($_POST['userMail']))) {
    $icon = "error";
    $Title = "Erreur !";
    $Message = "";
    if ($_POST['userMail'] == "") {
        $Message = "Veuillez renseigner votre mail";
    } else {
        if ($auth->accountExist($_POST['userMail'])) {
            $ID = $auth->getIdWithMail($_POST['userMail']);
            if ($ID != 0) {
                $key = $auth->ForgotPasswordGetKey($_POST['userMail']);
                $lien = "http://localhost:3000/index.php?url=ForgotPassword&ID=".$ID."&key=".$key;
                $icon = "success";
                $Title = "Récuperation mot de passe";
                $Message = "Lien de reinitialisation de mot de passe envoyé:  ";
                $Message .= $lien;
            } else { $Message = "Erreur ID"; }
        } else { $Title = "Email incorrecte";}
    }

    ob_start();
    ?>
        <script>
            Swal.fire({
                position: 'top-end',
                icon: '<?=$icon?>',
                title: '<?=$Title?>',
                text: '<?=$Message?>',
                showConfirmButton: false,
                timer: 5000
            })
        </script> 
    <?php
    $JS .= ob_get_clean();
}

echo $auth->ForgotPasswordVerifKeyAndID($_GET["ID"],$_GET["key"]);

if ((isset($_GET["key"])) && ($auth->ForgotPasswordVerifKeyAndID($_GET["ID"],$_GET["key"]))) {
    $icon = "error";
    $alert = false;
    $alertMessage = "";
    
    if ((isset($_POST["NewPass1"])) && (is_string($_POST["NewPass1"])) && ($_POST["NewPass1"] != "")) {
        if ((isset($_POST["NewPass2"])) && (is_string($_POST["NewPass2"])) && ($_POST["NewPass2"] != "")) {
            if (($_POST["NewPass1"]) == ($_POST["NewPass2"])) {
                if ($auth->changePasswordWithoutOld($_GET["ID"],$_POST["NewPass1"])) {
                    $icon = "success";
                    $alert = true; $alertMessage = "Changement du mot de passe effectué";
                    $auth->ForgotPasswordCleanKey();
                } else {$alert = true; $alertMessage = "Erreur lors du changement du mot de passe";}
            } else {$alert = true; $alertMessage = "confirmation de mot de passe éronné";}
        } else {$alert = true; $alertMessage = "veuillez confirmer votre nouveau mot de passe";}
    }

    if ($alert) {
        ob_start();
        ?>
            <script>
                Swal.fire({
                    <?php if ($icon != "success") {echo "position: 'top-end',";}?>
                    icon: '<?=$icon?>',
                    title: '<?=$alertMessage?>',
                    showConfirmButton: '<?php if ($icon != "success") {echo "false";} else {echo "true";}?>',
                    timer: 3000<?php if ($icon == "success") {
                    echo ",\n";
                    echo "willClose: () => {window.location.replace(\"index.php?url=Login\");}";
                }?>
                })
            </script> 
        <?php
        $JS .= ob_get_clean();
    }
    $form = new Form("./index.php?url=ForgotPassword&ID=".$_GET["ID"]."&key=".$_GET["key"]);
    $form->createInput('NewPass1','password','Entrez votre nouveau mot de passe');
    $form->createInput('NewPass2','password','Confirmez votre nouveau mot de passe');
    $form->createSubmit('Changer mon mot de passe');
    $JS .= $form->generateJS();
} else {
    $form = new Form("./index.php?url=ForgotPassword");
    $form->createInput('userMail','email','Entrez votre mail');
    $form->createSubmit('Récuperer mon mot de passe');
    $JS .= $form->generateJS();
}


$ForgotPassword = new Controller(false,0) ;
$ForgotPassword->pageName = "ForgotPassword";
$ForgotPassword->scriptPerso = $JS;
$ForgotPassword->customVars["form"] = $form->generateHTML();
$ForgotPassword->generate() ;