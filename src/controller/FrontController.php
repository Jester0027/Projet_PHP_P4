<?php

namespace BlogApp\src\controller;

class FrontController extends Controller
{
    public function getHome()
    {
        return $this->view->render('home');
    }

    public function getArticle()
    {
        return $this->view->render('article', [

        ]);
    }
}