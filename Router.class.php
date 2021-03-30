<?php

require_once 'Controller.class.php';
require_once 'Request.class.php';
require_once 'View.class.php';

/***************************************
* Class Router.                        *  
***************************************/

class Router {

    public function routerRequest() 
	{
		try 
		{
            $request = new Request(array_merge($_GET, $_POST));

            $lang = $this->createLanguage($request);
            $controller = $this->createController($request);
            $action = $this->createAction($request);
            $error = null;

            $controller->executeAction($action, $lang, $error);
		}
        catch (Exception $e) 
		{
            $this->Error($e);
		}
	}

    private function createLanguage(Request $request)
    {
        $lang = "fr";

        if($request->existParameter('lang'))
        {
            $lang = $request->getParameter('lang');
        }

        return $lang;
    }

    private function createController(Request $request) 
	{
        $controller = "Home";
		
        if ($request->existParameter('controller')) 
		{
            $controller = $request->getParameter('controller');
            $controller = ucfirst(strtolower($controller));
		}

        $classController = $controller."Controller";
        $fileController = "Controllers/".$classController.".class.php";
		
        if (file_exists($fileController)) 
		{
            require($fileController);
            $controller = new $classController();
            $controller->setRequest($request);
            return $controller;
		}
        else 
		{
            throw new Exception("Fichier '$fileController' introuvable");
		}
	}

    private function createAction(Request $request) 
	{
        $action = "Index";
		
        if ($request->existParameter('action'))
		{
            $action = $request->getParameter('action');
            $action = ucfirst(strtolower($action));
		}
		
        return $action;
	}

    private function Error(Exception $e)
	{
        $view = new View('Error');
        $view->generate("",array('msgError' => $e->getMessage()));
	}
}