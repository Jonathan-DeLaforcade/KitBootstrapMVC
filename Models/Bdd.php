<?php
class Bdd {
    private static $_bdd;

    protected static function setBdd() {
        $params = new Params;
        $bddHost = $params->getParam("bddHost");
        $bddPort = $params->getParam("bddPort");
        $bddLogin = $params->getParam("bddLogin");
        $bddPassword = $params->getParam("bddPassword");
        $bddBase = $params->getParam("bddBase");
        // echo $bddPort."<br />";
        // echo $bddLogin."<br />";
        // echo $bddPassword."<br />";
        // echo $bddBase."<br />";
        //self::$_bdd = new mysqli($bddHost,$bddLogin,$bddPassword,$bddBase);
        self::$_bdd = new mysqli($bddHost,$bddLogin,$bddPassword,$bddBase);
    }

    public function getBdd()
    {
        if(self::$_bdd == null)
        {
            $this->setBdd();
        }
        return self::$_bdd;
    }

}
