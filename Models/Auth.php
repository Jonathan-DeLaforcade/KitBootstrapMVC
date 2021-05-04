<?php
class Auth extends Session {

    private $session;
    private $bdd;
    private $params;

    public function __construct(){
        $this->session = new Session;
        $this->bdd = $this->getBdd();
        $this->params = new Params;
    }

    public function connect($user){
        $this->session->write('auth', $user);
        $this->session->write('time', time());
    }

    public function login($mail, $pass){
        $pass = hash('sha256',$this->params->getSalt().$pass);
        $query = "SELECT Id,Pseudo,Mail,Role FROM users WHERE Mail='".$mail."' AND PASSWORD='".$pass."' LIMIT 1";
        echo $query;
        $DbInfos = $this->bdd->query($query)->fetch_assoc();
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
        $pass = hash('sha256',$this->params->getSalt().$pass);

        $DbInfos = $this->bdd->query('SELECT Id FROM users WHERE Mail="'.$mail.'" LIMIT 1')->fetch_assoc();
        if (is_null($DbInfos)) {
            $request = 'INSERT INTO users (Pseudo,Mail,Password) VALUES ("'.$pseudo.'","'.$mail.'","'.$pass.'");';
            $this->bdd->query($request);
            $DbInfos = $this->bdd->query('SELECT Id FROM users WHERE Mail="'.$mail.'" LIMIT 1')->fetch_assoc();
            if (!is_null($DbInfos)) {
                $return = true;
            }
        }
        return $return;
    }

    public function verifPassOkWithMail($mail,$pass){
        $pass = hash('sha256',$this->params->getSalt().$pass);
        $DbInfos = $this->bdd->query('SELECT Id FROM users WHERE Mail="'.$mail.'" AND PASSWORD="'.$pass.'" LIMIT 1')->fetch_assoc();
        if (!is_null($DbInfos)) {
            return true;
        } else {
            return false;
        }
    }

    public function verifPassOkWithID($ID,$pass){
        $pass = hash('sha256',$this->params->getSalt().$pass);
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
        
        $testReq = "SELECT $userField FROM users WHERE ID=$ID LIMIT 1;";
        $testUpdate = $this->bdd->query($testReq)->fetch_assoc();
        
        return ($testUpdate[$userField] == $newUserData);
    }

    public function changePasswordWithoutOld($ID,$newPass) {
        $newPass = hash('sha256',$this->params->getSalt().$newPass);
        $this->bdd->query('UPDATE users SET Password = "'.$newPass.'" WHERE ID ='.$ID);

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

    public function getIdWithMail($mail){
        $Request = 'SELECT Id FROM users WHERE Mail="'.$mail.'" LIMIT 1;';
        $DbInfos = $this->bdd->query($Request)->fetch_assoc();
        if (!is_null($DbInfos)) {
            return $DbInfos["Id"];
        } else {
            return 0;
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

    public function ForgotPasswordGetKey($mail) {
        $key = bin2hex(random_bytes(50));
        $keyCrypt = hash('sha256',$this->params->getSalt().$key);
        $tmpReq = "UPDATE users SET Password=\"$keyCrypt\" WHERE Mail=\"$mail\" LIMIT 1;";
        $this->bdd->query($tmpReq);
        $this->session->write("forgotKey",$key);
        $this->session->write("forgotIDKey",$this->getIdWithMail($mail));
        $this->session->write("forgotKeyCreateTime",time());
        return $key;
    }

    public function ForgotPasswordCleanKey() {
        $this->session->write("forgotKey",null);
        $this->session->write("forgotKeyCreateTime",null);
    }

    public function ForgotPasswordVerifKeyAndID($ID,$key) {
        $return = false;
        if (($this->session->read('forgotKeyCreateTime')+600)> time()) { 
            $keyCrypt = hash('sha256',$this->params->getSalt().$key);
            $Request = 'SELECT Id FROM users WHERE Password="'.$keyCrypt.'" LIMIT 1;';
            $DbInfos = $this->bdd->query($Request)->fetch_assoc();
            if (!is_null($DbInfos)) {
                if (
                    ($this->session->read("forgotKey") == $key) 
                    && ($this->session->read("forgotIDKey") == $ID)
                   ) {
                    $return = true;
                }
            }
        }
        return $return;
    }
}