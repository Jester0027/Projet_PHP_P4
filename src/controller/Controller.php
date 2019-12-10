<?php

namespace BlogApp\src\controller;

use BlogApp\config\Request;
use BlogApp\src\constraint\Validation;
use BlogApp\src\model\View;
use BlogApp\src\DAO\ArticleDAO;
use BlogApp\src\DAO\CommentDAO;
use BlogApp\src\DAO\UserDAO;

abstract class Controller
{
    protected $articleDAO;
    protected $commentDAO;
    protected $userDAO;
    protected $view;
    private $request;
    protected $get;
    protected $post;
    protected $session;
    protected $validation;
    protected $reqMethod;

    public function __construct()
    {
        $this->articleDAO = new ArticleDAO();
        $this->commentDAO = new CommentDAO();
        $this->userDAO = new UserDAO();
        $this->view = new View();
        $this->request = new Request();
        $this->get = $this->request->getGet();
        $this->post = $this->request->getPost();
        $this->session = $this->request->getSession();
        $this->validation = new Validation();
        $this->reqMethod = $_SERVER['REQUEST_METHOD'];
    }

    protected function isLoggedIn()
    {
        return $this->session->get('username') ? true : false;
    }

    protected function isAdmin()
    {
        return $this->session->get('role') === 'admin' ? true : false;
    }
}