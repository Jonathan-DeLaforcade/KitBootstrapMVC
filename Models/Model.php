<?php

abstract class Model extends Bdd {

    protected function getAll($table, $obj) 
    {
        $result_data = [];
        $bdd = $this->getBdd();
        $sql = "Select * from ".$table;
        $result = $bdd->query($sql);
		while ($row = $result->fetch_assoc()) {
			$result_data[] = new $obj($row);
        }
        return $result_data;
        
    }

    protected function getTableLigneNumber($table)
    {
        $number = 0;
        $bdd = $this->getBdd();
        $sql = "select count(*) as Number from ".$table;
        $result = $bdd->query($sql);
        $number = $result->fetch_assoc();
        $number = $number['Number'];
        return $number;
    }

    protected function getNumberTotal($table,$colonne)
    {
        $number = 0;
        $bdd = $this->getBdd();
        $sql = "select ".$colonne." from ".$table;
        $result = $bdd->query($sql);
        
        while ($row = $result->fetch_assoc()) {
			$number += $row["NbFlashs"];
        }
        
        
        return $number;
    }
}   



