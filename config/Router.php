<?php

namespace BlogApp\config;

use Exception;
use BlogApp\src\controller\FrontController;
use BlogApp\src\controller\errorController;
use BlogApp\src\controller\BackController;

class Router
{
    private $request;
    private $frontController;
    private $errorController;
    private $backController;

    public function __construct()
    {
        $this->request = new Request();
        $this->frontController = new FrontController();
        $this->errorController = new errorController();
        $this->backController = new BackController();
    }

    public function run()
    {
        $route = $this->request->getGet()->get('route');
        try {
            if (isset($route)) {
                if ($route === 'article') {
                    $this->frontController->getArticle($this->request->getGet()->get('articleId'));
                } else if ($route === 'addArticle') {
                    $this->backController->addArticle($this->request->getPost());
                } else {
                    $this->errorController->get404();
                }
            } else {
                $this->frontController->getHome();
            }
        } catch (Exception $e) {
            $this->errorController->get500($e);
        }
    }
}
