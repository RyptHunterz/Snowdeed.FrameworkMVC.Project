<?php

require_once 'Request.class.php';
require_once 'View.class.php';

/****************************
* Class Controller         *  
****************************/

abstract class Controller {

    private $action;
	
    protected $request;

    public function setRequest(Request $request)
	{
        $this->request = $request;
	}

    public function executeAction($action, $lang, $error, $data = array()) 
	{
        if (method_exists($this, $action))
		{
            $this->action = $action;
            $this->{$this->action}($lang, $error, $data);
		}
        else
		{
            $classController = get_class($this);
            throw new Exception("Action '$action' non définie dans la classe $classController");
		}
	}

    protected function generateView($dataView = array())
	{
        $classController = get_class($this);
        $controller = str_replace("Controller", "", $classController);
        
        $view = new View($this->action, $controller);
        $view->generate($controller, $dataView);
	}
}