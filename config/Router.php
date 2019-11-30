<?php

namespace BlogApp\config;

use Exception;
use BlogApp\src\controller\FrontController;

class Router
{
    private $request;
    private $frontController;

    public function __construct()
    {
        $this->request = new Request();   
        $this->frontController = new FrontController();
    }

    public function run()
    {
        $route = $this->request->getGet()->get('route');
        try{
            if(isset($route)){
                if($route === 'article'){
                    
                } else {
                    
                }
            } else {
                $this->frontController->home();
            }
        } catch (Exception $e) {

        }
    }
}