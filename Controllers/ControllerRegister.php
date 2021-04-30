<?php

$JS = "";

$auth = new Auth;
$params = new Params;

if (($auth->getRole() > 0) || !($params->getAllowRegister())) {
    header('Location: ../index.php?url=Home');
}

if ((isset($_POST['userName'])) && (isset($_POST['userMail'])) && (isset($_POST['PassWord1'])) && (isset($_POST['PassWord2'])) &&
    (is_string($_POST['userName'])) && (is_string($_POST['userMail'])) && (is_string($_POST['PassWord1'])) && (is_string($_POST['PassWord2'])) &&
    ($params->getAllowRegister())
    ) {
    $icon = "error";
    $Title = "Erreur !";
    $Message = "";
    if (($_POST['userName'] == "") || ($_POST['userMail'] == "") || ($_POST['PassWord1'] == "") || ($_POST['PassWord2'] == "")){
        $Message = "Veuillez remplir le formulaire";
    } else {
        if ($_POST['PassWord1'] == $_POST['PassWord2']) {
            $result = $auth->registerNew($_POST['userName'],$_POST['userMail'],$_POST['PassWord1']);
            if ($result) {
                $icon = "success";
                $Title = "Compte enregistré !";
                $Message = "Vous pouvez retourner vous login";
            } else {
                $Message = "Erreur lors de la création du compte";
            }
        } else {
            $Title = "Mot de passe invalide !";
            $Message = "veuillez saisir le meme mot de passe";
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

$form = new Form("./?url=Register");
$form->createInput('userName','username','Entrez votre nom');
$form->createInput('userMail','email','Entrez votre mail');
$form->createInput('PassWord1','password','Entrez votre mot de passe');
$form->createInput('PassWord2','password','Confirmer votre mot de passe');
$form->createSubmit('Enregistrer');
$JS .= $form->generateJS();

$Register = new Controller(false,0) ;
$Register->pageName = "Register";
$Register->scriptPerso = $JS;
$Register->customVars["form"] = $form->generateHTML();
$Register->generate() ;