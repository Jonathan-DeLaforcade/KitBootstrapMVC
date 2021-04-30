<?php

class View 
{
    private $_file;
    private $_t;
    private $_auth;
    private $_menuItems;
    public function __construct($specificPage,$action,$auth)
    {
        if ($specificPage) {
            $this->_file = 'Specific/Views/View'.$action.".php";
        } else {
            $this->_file = 'Views/View'.$action.".php";
        }
        $this->_t = $action;
        $this->_auth = $auth;

        $this->_menuItems = (new Params)->getMenuItems();
        
    }

    public function generatePage($scriptPerso,$data)
    {
        if (!is_array($data)) { $data = Array(); }
        if (!isset($scriptPerso)) { $scriptPerso = ""; }
        if (file_exists($this->_file)) {
            $content = $this->generateFile($this->_file,$data);
        } else {
            throw new Exception("Page Introuvable");
        }
        $topbar = $this->generateFile("Templates/TemplateTopbar.php",array("t" => $this->_t,"UserName" => $this->_auth->getUsername()));
        
        // If $this->_auth->getRole() == ...
        // call templatesidebar with a different Array
        
        $sidebar = $this->generateFile("Templates/TemplateSidebar.php",array("menuItems" => $this->_menuItems));

        // Page content and elements:
        
        $pageContent = Array(
            'scriptPerso' => $scriptPerso, 
            "t" => $this->_t, 
            "topbar" =>$topbar,
            "sidebar" => $sidebar,
            "content" => $content
        );
        
        // Role management
        if ($this->_auth->getRole() == 0 ) { // Not logged
            $view = $this->generateFile("Templates/TemplateNotLogin.php", $pageContent);
        } elseif ($this->_auth->getRole() > 0 ) { // Logged as xxx
            $view = $this->generateFile("Templates/TemplateLogin.php", $pageContent);
        } else { // Default case, no role : error
            $view = $this->generateError($data);
        }
        
        echo $view;
    }

    public function generateError($data)
    {
        $content = $this->generateFile($this->_file, $data);
        $topbar = $this->generateFile("Views/TemplateTopbar.php",array("t" => $this->_t));
        $sidebar = $this->generateFile("Views/TemplateSidebar.php",array("role" => '0'));
        $view = $this->generateFile("Views/TemplateError.php",array("t" => $this->_t, "topbar" =>$topbar,"sidebar" => $sidebar,"content" => $content));

        echo $view;
    }

    private function generateFile($file, $pageContent)
    {
        if (file_exists($file))
        {
            extract($pageContent);
            ob_start();
            require($file);
            return ob_get_clean();
        } else {
            throw new Exception("Fichier ".$file." Introuvable");
        }
    }
}