<?php

require_once 'Configuration.class.php';

/******************************
* Class Model                 *  
*******************************/

abstract class Model {

    private $bdd;

    protected function executeRequest($sql, $params = null)
	{
        if ($params == null) 
		{
            $result = $this->getBdd()->query($sql);
		}
        else 
		{
            $result = $this->getBdd()->prepare($sql);
            $result->execute($params);
		}
		
        return $result;
	}

    private function getBdd()
	{
        if ($this->bdd == null) 
		{
			$dbHost=Configuration::get("dbHost");
			$dbName=Configuration::get("dbName");
			$dbUser=Configuration::get("dbUser");
			$dbPwd=Configuration::get("dbPwd");
			
            $this->bdd = new PDO('mysql:host='.$dbHost.';dbname='.$dbName.';charset=utf8', $dbUser, $dbPwd, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		}
		
        return $this->bdd;
	}
}