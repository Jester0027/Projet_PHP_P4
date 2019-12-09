<?php

namespace BlogApp\src\controller;

use BlogApp\config\Parameter;

class BackController extends Controller
{
    public function addArticle(Parameter $post)
    {
        if($post->get('submit')) {
            
        }
        return $this->view->render('add_article');
    }

    public function confirm(Parameter $get)
    {
        if($get->get('token') && $get->get('email')) {
            $this->userDAO->confirm($get);
        }
        header('Location: index.php');
    }
}