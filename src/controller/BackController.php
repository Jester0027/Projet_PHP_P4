<?php

namespace BlogApp\src\controller;

use BlogApp\config\Parameter;
use BlogApp\config\Session;

class BackController extends Controller
{
    public function admin()
    {
        if($this->isAdmin()) {
            $articles = $this->articleDAO->getArticles();
            $users = $this->userDAO->getUsers();
            $reportedComments = $this->commentDAO->getReportedComments();
            return $this->view->render('admin', [
                'articles' => $articles,
                'users' => $users,
                'reportedComments' => $reportedComments
            ]);
        } else {
            $this->session->set('admin_access', 'Vous devez disposer d\'un acces administrateur');
            header('Location: index.php');
        }
    }

    public function addArticle(Parameter $post, Session $session)
    {
        if($this->isAdmin()) {
            if($this->reqMethod === 'POST') {
                $this->articleDAO->addArticle($post, $session);
                $this->session->set('add_article', 'Votre article a bien été ajouté');
                return header('Location: index.php?route=admin');
            }
            return $this->view->render('add_article');
        } else {
            $this->session->set('admin_access', 'Vous devez disposer d\'un acces administrateur');
            header('Location: index.php');
        }
    }

    public function editArticle(Parameter $post, $articleId, $session)
    {
        if($this->isAdmin()) {
            $article = $this->articleDAO->getArticle($articleId);
            // if($article->getAuthor() != $session->get('username')) {
            //     $this->session->set('article_access', 'Vous n\'etes pas l\'auteur de cet article');
            //     return header('Location: index.php?route=admin');
            // }
            if($this->reqMethod === 'POST') {
                $result = $this->articleDAO->editArticle($post, $articleId);
                $this->session->set('add_article', 'Votre article a bien été modifié');
                return header('Location: index.php?route=admin');
            }
            return $this->view->render('edit_article', [
                'post' => $post,
                'article' => $article,
                'articleId' => $articleId
            ]);
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

    public function passwordRecovery(Parameter $post, Parameter $get)
    {
        $isValid = $this->userDAO->checkTokenAndEmail($get->get('token'), $get->get('email'));
        if($isValid) {
            if($this->reqMethod === 'POST') {
                $user = $this->userDAO->getUserFromEmail($post->get('email'));
                $this->userDAO->resetToken($user->getId());
                $this->userDAO->changePassword($user->getId(), $post);
                $this->session->set('pw_change', 'Votre mot de passe a bien été mis a jour');
                return header('Location: index.php');
            }
            return $this->view->render('password_recovery', [
                'token' => $get->get('token'),
                'email' => $get->get('email')
            ]);
        }
        return header('Location: index.php');
    }

    public function profile(Session $session)
    {
        if($this->isLoggedIn()) {
            return $this->view->render('profile', [
                'session' => $session
            ], [
                'profil'
            ]);
        } else {
            header('Location: index.php');
        }
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

    public function deleteUser($userId)
    {
        if($this->isAdmin()) {
            $this->userDAO->deleteUser($userId);
            $this->session->set('user_action', 'L\'utilisateur a bien été supprimé');
            return header('Location: index.php?route=admin');
        } else {
            $this->session->set('admin_access', 'Vous devez disposer d\'un acces administrateur');
            header('Location: index.php');
        }
    }

    public function banUser($userId)
    {
        if($this->isAdmin()) {
            $this->userDAO->banUser($userId);
            $this->session->set('user_action', 'L\'utilisateur a bien été banni');
            return header('Location: index.php?route=admin');
        } else {
            $this->session->set('admin_access', 'Vous devez disposer d\'un acces administrateur');
            header('Location: index.php');
        }
    }

    public function unbanUser($userId)
    {
        if($this->isAdmin()) {
            $this->userDAO->unbanUser($userId);
            $this->session->set('user_action', 'L\'utilisateur a bien été débanni');
            return header('Location: index.php?route=admin');
        } else {
            $this->session->set('admin_access', 'Vous devez disposer d\'un acces administrateur');
            header('Location: index.php');
        }
    }

    public function deleteComment()
    {

    }

    public function pardonComment()
    {

    }

}