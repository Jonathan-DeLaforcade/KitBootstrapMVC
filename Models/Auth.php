<?php
class Auth extends Session {

    private $session;
    private $bdd;

    public function __construct(){
        $this->session = new Session;
        $this->bdd = $this->getBdd();
    }

    public function connect($user){
        $this->session->write('auth', $user);
        $this->session->write('time', time());
    }

    public function login($mail, $pass){
        $DbInfos = $this->bdd->query('SELECT Id,Pseudo,Mail,Role FROM users WHERE Mail="'.$mail.'" AND PASSWORD="'.$pass.'" LIMIT 1')->fetch_assoc();
        if (!is_null($DbInfos)) {
            $this->connect($DbInfos);
            return true;
        }else{
            return false;
        }
    }

    public function accountExist($mail) {
        $return = false;
        $DbInfos = $this->bdd->query('SELECT Id FROM users WHERE Mail="'.$mail.'" LIMIT 1')->fetch_assoc();
        if (!is_null($DbInfos)) {
            $return = true;
        }
        return $return;
    }

    public function registerNew($pseudo,$mail,$pass) {
        $return = false;
        $DbInfos = $this->bdd->query('SELECT Id FROM users WHERE Mail="'.$mail.'" LIMIT 1')->fetch_assoc();
        if (is_null($DbInfos)) {
            $request = 'INSERT INTO users (Pseudo,Mail,Password) VALUES ("'.$_POST['userName'].'","'.$_POST['userMail'].'","'.$_POST['PassWord1'].'");';
            $this->bdd->query($request);
            $DbInfos = $this->bdd->query('SELECT Id FROM users WHERE Mail="'.$mail.'" LIMIT 1')->fetch_assoc();
            if (!is_null($DbInfos)) {
                $return = true;
            }
        }
        return $return;
    }

    public function verifPassOkWithMail($mail,$pass){
        $DbInfos = $this->bdd->query('SELECT Id,Pseudo,Mail,Password,Role FROM users WHERE Mail="'.$mail.'" AND PASSWORD="'.$pass.'" LIMIT 1')->fetch_assoc();
        if (!is_null($DbInfos)) {
            return true;
        } else {
            return false;
        }
    }

    public function verifPassOkWithID($ID,$pass){
        $Request = 'SELECT Id FROM users WHERE Id="'.$ID.'" AND PASSWORD="'.$pass.'" LIMIT 1';
        $DbInfos = $this->bdd->query($Request)->fetch_assoc();
        if (!is_null($DbInfos)) {
            return true;
        } else {
            return false;
        }
    }

    public function changeUserData($userField, $newUserData) {
        $ID = $this->getId();
        $user = ($this->session->read('auth'));
        $user[$userField] = $newUserData;
        $this->session->write('auth', $user);
        
        $tmpReq = "UPDATE users SET $userField=\"$newUserData\" WHERE ID=$ID LIMIT 1;" ;
        $this->bdd->query($tmpReq);
        
        $testReq = "SELECT $userField FROM users WHERE ID=$ID LIMIT 1;" ;
        $testUpdate = $this->bdd->query($testReq)->fetch_assoc();
        
        return ($testUpdate[$userField] == $newUserData);
    }

    public function changeUsername($newUsername) {
        $ID = $this->getId();
        $user = ($this->session->read('auth'));
        $user["Pseudo"] = $newUsername;
        $this->session->write('auth', $user);
        
        $tmpReq = 'UPDATE users SET Pseudo="'.$newUsername.'" WHERE ID='.$ID.' LIMIT 1;' ;
        $this->bdd->query($tmpReq);
        
        $testReq = 'SELECT Pseudo FROM users WHERE ID='.$ID.' LIMIT 1;' ;
        $testUpdate = $this->bdd->query($testReq)->fetch_assoc();

        return ($testUpdate['Pseudo'] == $newUsername);
    }

    public function changeMail($newMail){
        $ID = $this->getId();
        $user = ($this->session->read('auth'));
        $user["Mail"] = $newMail;
        $this->session->write('auth', $user);
        $this->bdd->query('UPDATE users SET Mail = "'.$newMail.'" WHERE ID ='.$ID);

        $testReq = 'SELECT Mail FROM users WHERE ID='.$ID.' LIMIT 1;' ;
        $testUpdate = $this->bdd->query($testReq)->fetch_assoc();

        return ($testUpdate['Mail'] == $newMail);
    }

    public function changePassword($oldPass,$newPass){
        $ID = $this->getId();
        echo "changepass AUTH </br>";
        if ($this->verifPassOkWithID($ID,$oldPass)) {
            $this->bdd->query('UPDATE users SET Password = "'.$newPass.'" WHERE ID ='.$ID);
        }
        $testReq = 'SELECT Password FROM users WHERE ID='.$ID.' LIMIT 1;' ;
        $testUpdate = $this->bdd->query($testReq)->fetch_assoc();

        return ($testUpdate['Password'] == $newPass);
    }

    public function logout(){
        session_destroy();
    }
    public function restrict(){
        $sessionIsOk = (!$this->session->read('auth'));
        $sessionIsOk &= (intval($this->session->read('time')) < ( time()-15*60)) ;
        
        if($sessionIsOk){
            $this->session->setFlash('danger', "Vous n'avez pas le droit d'accéder à cette page");
            header('Location: index.php?url=Login');
            exit();
        }
    }

    public function restrictRole($role = 0){

        if(!$this->session->read('auth')){
            $this->session->setFlash('danger', "Vous n'avez pas le droit d'accéder à cette page");
            header('Location: index.php?url=Login');
            exit();
        } else {
            if ((($this->session->read('auth'))["Role"]) < $role) {
                header('Location: index.php?url=Home');
            }
        }
    }

    public function haveRole($role = 0){

        if(!$this->session->read('auth')){
            $this->session->setFlash('danger', "Vous n'avez pas le droit d'accéder à cette page");
            header('Location: index.php?url=Login');
            exit();
        } else {
            if ((($this->session->read('auth'))["Role"]) >= $role) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function getId(){
        if(!$this->session->read('auth')){
            $this->session->setFlash('danger', "Vous n'avez pas le droit d'accéder à cette page");
            header('Location: index.php?url=Login');
            exit();
        } else {
            return (($this->session->read('auth'))["Id"]);
        }
    }

    public function getRole(){
        if(!$this->session->read('auth')){
            return 0;
        } else {
            return (($this->session->read('auth'))["Role"]);
        }
    }

    public function getUsername(){
        if(!$this->session->read('auth')){
            return "";
        } else {
            return (($this->session->read('auth'))["Pseudo"]);
        }
    }
    public function getMail(){
        if(!$this->session->read('auth')){
            return "";
        } else {
            return (($this->session->read('auth'))["Mail"]);
        }
    }
}