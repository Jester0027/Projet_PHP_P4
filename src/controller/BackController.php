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
            $this->session->set('validation', 'Votre compte a bien été validé, vous pouvez vous connecter');
        }
        header('Location: index.php');
    }

    public function logout()
    {
        $this->session->stop();
        $this->session->start();
        $this->session->set('logout', 'A bientot');
        header('Location: index.php');
    }
}