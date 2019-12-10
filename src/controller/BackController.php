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
            $result = $this->userDAO->confirm($get);
            if($result) {
                $this->session->set('validation', 'Votre compte a bien été validé, vous pouvez vous connecter');
            } else {
                $this->session->set('validation', 'Erreur: l\'utilisateur n\'existe pas ou a déja été validé');
            }
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