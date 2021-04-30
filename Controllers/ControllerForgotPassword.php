<?php

$JS = "";

$auth = new Auth;
$params = new Params;


if (($auth->getRole() > 0) || !($params->getAllowRegister())) {
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
            $icon = "success";
            $Title = "Récuperation mot de passe";
            $Message = "Lien de reinitialisation de mot de passe envoyé";
        } else {
            $Title = "Email incorrecte";
        }
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
                timer: 2000
            })
        </script> 
    <?php
    $JS .= ob_get_clean();
}

$form = new Form("./?url=ForgotPassword");
$form->createInput('userMail','email','Entrez votre mail');
$form->createSubmit('Récuperer mon mot de passe');
$JS .= $form->generateJS();

$ForgotPassword = new Controller(false,0) ;
$ForgotPassword->pageName = "ForgotPassword";
$ForgotPassword->scriptPerso = $JS;
$ForgotPassword->customVars["form"] = $form->generateHTML();
$ForgotPassword->generate() ;