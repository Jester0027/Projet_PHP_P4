<?php

namespace BlogApp\src\controller;

class FrontController extends Controller
{
    public function home()
    {
        $this->view->render('home');
    }
}