<?php
abstract class Bdd {
    private static $_bdd;

    protected static function setBdd() {
        self::$_bdd = new mysqli('127.0.0.1', 'kitBootstrap', 'kitBootstrap', 'kitBootstrap');
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
