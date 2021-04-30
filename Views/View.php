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

        $topbarFile = "Templates/TemplateTopbar.php";
        if (file_exists("Specific/Templates/TemplateTopbar.php")) {
            $topbarFile = "Specific/Templates/TemplateTopbar.php"; 
        }
        $topbar = $this->generateFile($topbarFile,array("t" => $this->_t,"UserName" => $this->_auth->getUsername()));
        
        $sidebarFile = "Templates/TemplateSidebar.php";
        if (file_exists("Specific/Templates/TemplateSidebar.php")) {
            $sidebarFile = "Specific/Templates/TemplateSidebar.php"; 
        }
        $sidebar = $this->generateFile($sidebarFile,array("menuItems" => $this->_menuItems));

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
            $notLoginFile = "Templates/TemplateNotLogin.php";
            if (file_exists("Specific/Templates/TemplateNotLogin.php")) {
                $notLoginFile = "Specific/Templates/TemplateNotLogin.php"; 
            }
            $view = $this->generateFile($notLoginFile, $pageContent);
        } elseif ($this->_auth->getRole() > 0 ) { // Logged as xxx
            $loginFile = "Templates/TemplateLogin.php";
            if (file_exists("Specific/Templates/TemplateLogin.php")) {
                $loginFile = "Specific/Templates/TemplateLogin.php"; 
            }
            $view = $this->generateFile($loginFile, $pageContent);
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