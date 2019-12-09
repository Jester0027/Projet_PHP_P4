<?php

namespace BlogApp\src\controller;

use BlogApp\config\Parameter;

class FrontController extends Controller
{
    public function getHome()
    {
        $articles = $this->articleDAO->getArticles();
        return $this->view->render('home', [
            'articles' => $articles
        ]);
    }

    public function getArticle($articleId)
    {
        $article = $this->articleDAO->getArticle($articleId);
        $comments = $this->commentDAO->getCommentsFromArticleId($articleId);
        return $this->view->render('article', [
            'article' => $article,
            'comments' => $comments
        ]);
    }

    public function login(Parameter $post)
    {
        if ($this->reqMethod === 'POST') {
            $this->UserDAO->login();
            return header('Location: index.php');
        }
        return $this->view->render('login');
    }

    public function register(Parameter $post)
    {
        if ($this->reqMethod === 'POST') {
            $username = $post->get('username');
            $email = $post->get('email');
            if ($post->get('password') !== $post->get('cPassword')) {
                $this->session->set('pw_no_match', 'Les mots de passe ne sont pas identiques');
                return $this->view->render('register', [
                    'username' => $username,
                    'email' => $email
                ]);
            }
            $token = 'qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM1234567890*';
            $token = str_shuffle($token);
            $this->userDAO->register($post, $token);
            $link = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REDIRECT_URL'] . "?route=confirm&token=" . $token . "&email=" . $email;
            return header('Location: index.php');
        }
        return $this->view->render('register');
    }
}
