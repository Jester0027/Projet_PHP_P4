<?php

namespace BlogApp\src\controller;

use BlogApp\config\Request;
use BlogApp\src\model\View;

abstract class Controller
{
    protected $view;
    private $request;
    protected $get;
    protected $post;
    protected $session;

    public function __construct()
    {
        $this->view = new View();
        $this->request = new Request();
        $this->get = $this->request->getGet();
        $this->post = $this->request->getPost();
        $this->session = $this->request->getSession();
    }
}