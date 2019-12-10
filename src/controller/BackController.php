<?php

namespace BlogApp\src\controller;

use BlogApp\config\Parameter;

class BackController extends Controller
{
    public function admin()
    {
        if($this->isAdmin()) {
            $articles = $this->articleDAO->getArticles();
            $users = $this->userDAO->getUsers();
            return $this->view->render('admin', [
                'articles' => $articles,
                'users' => $users
            ]);
        } else {
            $this->session->set('admin_access', 'Vous devez disposer d\'un acces administrateur');
            header('Location: index.php');
        }
    }

    public function addArticle(Parameter $post)
    {
        if($this->isAdmin()) {
            if($this->reqMethod === 'POST') {
                $this->articleDAO->addArticle($post);
                return header('Location: index.php?route=admin');
            }
            return $this->view->render('add_article');
        } else {
            $this->session->set('admin_access', 'Vous devez disposer d\'un acces administrateur');
            header('Location: index.php');
        }
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
        if($this->isLoggedIn()) {
            $this->session->stop();
            $this->session->start();
            $this->session->set('logout', 'A bientot');
        }
        header('Location: index.php');
    }
}