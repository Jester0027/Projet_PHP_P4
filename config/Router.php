<?php

namespace BlogApp\config;

use Exception;
use BlogApp\src\controller\FrontController;
use BlogApp\src\controller\ErrorController;
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
        $this->errorController = new ErrorController();
        $this->backController = new BackController();
    }

    public function run()
    {
        $route = $this->request->getGet()->get('route');
        try {
            if (isset($route)) {
                if ($route === 'article') {
                    $this->frontController->getArticle($this->request->getGet()->get('articleId'));
                } else if($route === 'addComment') {
                    $this->frontController->addComment($this->request->getSession(), $this->request->getPost(), $this->request->getGet()->get('articleId'));
                } else if ($route === 'addArticle') {
                    $this->backController->addArticle($this->request->getPost(), $this->request->getSession());
                } else if ($route === 'login') {
                    $this->frontController->login($this->request->getPost());
                } else if ($route === 'register') {
                    $this->frontController->register($this->request->getPost());
                } else if ($route === 'logout') {
                    $this->backController->logout();
                } else if ($route === 'confirm') {
                    $this->backController->confirm($this->request->getGet());
                } else if ($route === 'admin') {
                    $this->backController->admin();
                } else if($route === 'deleteUser') {
                    $this->backController->deleteUser($this->request->getGet()->get('userId'));
                } else if($route === 'banUser') {
                    $this->backController->banUser($this->request->getGet()->get('userId'));
                } else if($route === 'unbanUser') {
                    $this->backController->unbanUser($this->request->getGet()->get('userId'));
                } else if($route === 'editArticle') {
                    $this->backController->editArticle($this->request->getPost(), $this->request->getGet()->get('articleId'), $this->request->getSession());
                } else if($route === 'deleteComment') {
                    $this->backController->deleteComment();
                } else if($route === 'reportComment') {
                    $this->frontController->reportComment();
                } else if($route === 'pardonComment') {
                    $this->backController->pardonComment();
                } else if($route === 'lostPassword') {
                    $this->frontController->lostPassword($this->request->getPost());
                } else if($route === 'passwordRecovery') {
                    $this->backController->passwordRecovery($this->request->getGet());
                } else if($route === 'changePassword') {
                    $this->backController->changePassword($this->request->getPost());
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
