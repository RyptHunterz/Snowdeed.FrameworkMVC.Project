<?php

/******************************************************
* Class Configuration                                 *  
******************************************************/

class Configuration 
{
	private static $parameters;
	
	public static function get($name, $defaultValue = null) 
	{
		if (isset(self::getParameters()[$name]))
		{
			$value = self::getParameters()[$name];
		}
		else 
		{
			$value = $defaultValue;
		}
		
		return $value;
	}
	
	private static function getParameters() 
	{
		if (self::$parameters == null)
		{
			$file = "Config/prod.ini";
			
			if (!file_exists($file)) 
			{
				$file = "Config/dev.ini";
			}
			
			if (!file_exists($file)) 
			{
				throw new Exception("No configuration file found");
			}
			else 
			{
				self::$parameters = parse_ini_file($file);
			}
		}
		
		return self::$parameters;
	}
}