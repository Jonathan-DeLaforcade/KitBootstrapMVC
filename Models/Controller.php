<?php
class Controller extends Model {
    private $_view;
    private $_auth;
    private $_restrictRole;
    private $_specificPage;
    public $pageName = "" ;
    public $scriptPerso = "";
    public $customVars = Array();

    public function __construct($specificPage = false,$restrictRole = 4)
    {
        $this->_auth = new Auth;
        $this->_restrictRole = $restrictRole;
        $this->_specificPage = $specificPage;
        if ($restrictRole > 0) {
            $this->_auth->restrict();
        };
    }

    public function generate() 
    {
        $this->_view = new View($this->_specificPage,$this->pageName,$this->_auth);
        $this->_view->generatePage($this->scriptPerso,$this->customVars);
    }
}