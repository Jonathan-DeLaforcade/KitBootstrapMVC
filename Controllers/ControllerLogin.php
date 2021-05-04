<?php

$auth = new Auth;
$params = new Params;
if ($auth->getRole() > 0){
    header('Location: ../index.php?url=Home');
}

$JS = "";
$registerText = "";
$forgotPassText = "";

if ((isset($_POST['userName'])) && (isset($_POST['PassWord']))) {
    if ((is_string($_POST['userName'])) && (is_string($_POST['PassWord']))) {
        $result = $auth->login($_POST['userName'],$_POST['PassWord']);
        if (!$result) {
            ob_start();
            ?>
                <script>
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Erreur de connexion !',
                        text: 'Les informations que vous avez rentré ne sont pas correcte',
                        showConfirmButton: false,
                        timer: 2000
                    })
                </script>  
            <?php
            $JS .= ob_get_clean();
        } else {
            header('Location: ../index.php?url=Home');
        }
    }
}

$form = new Form("./?url=Login");
$form->createInput('userName','username','Entrez votre mail');
$form->createInput('PassWord','password','Entrez votre mot de passe');
$form->createSubmit('Connexion');
$JS .= $form->generateJS();

$Login = new Controller(false,0) ;
$Login->pageName = "Login";
$Login->scriptPerso = $JS;
$Login->customVars["form"] = $form->generateHTML();
if ($params->getAllowRegister()) {
    $registerText = '<a class="small" href="./index.php?url=Register">Créer un compte</a>';
}
if ($params->getAllowPassRecovery()) {
    $forgotPassText = '<a class="small" href="index.php?url=ForgotPassword">Mot de passe perdu</a>';
}
$Login->customVars["Register"] = $registerText;
$Login->customVars["forgotPass"] = $forgotPassText;
$Login->generate();
