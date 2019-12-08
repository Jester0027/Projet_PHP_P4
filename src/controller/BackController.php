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
}