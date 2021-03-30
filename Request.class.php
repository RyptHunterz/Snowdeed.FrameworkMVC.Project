<?php

/**************************
* Class Request           *  
**************************/

class Request {
	
    private $parameters;

    public function __construct($parameters)
	{
        $this->parameters = $parameters;
	}

    public function existParameter($name)
	{
        return (isset($this->parameters[$name]) && $this->parameters[$name] != "");
	}

    public function getParameterRequired($name)
	{
        if ($this->existParameter($name))
		{
            return $this->parameters[$name];
		}
        else
		{
            throw new Exception("Paramètre '$name' absent de la requête");
		}
	}

	public function getParameter($name)
	{
        if ($this->existParameter($name))
		{
            return $this->parameters[$name];
		}
        else
		{
            return "";
		}
	}
}