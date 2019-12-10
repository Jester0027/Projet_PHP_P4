<?php

namespace BlogApp\src\controller;

use BlogApp\config\Parameter;
use BlogApp\src\mailer\Mail;

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
            $result = $this->userDAO->login($post);
            if($result && $result['isPasswordValid']) {
                if (!$result['result']['is_verified']) {
                    $this->session->set('error_login', 'Votre compte n\'est pas validé');
                    return $this->view->render('login', [
                        'post' => $post
                    ]);
                }
                $this->session->set('login', 'content de vous revoir');
                $this->session->set('id', $result['result']['id']);
                $this->session->set('role', $result['result']['name']);
                $this->session->set('username', $post->get('username'));
                header('Location: index.php');
            } else {
                $this->session->set('error_login', 'Le pseudo ou le mot de passe sont incorrects');
                return $this->view->render('login', [
                    'post' => $post
                ]);
            }
        }
        return $this->view->render('login');
    }

    public function register(Parameter $post)
    {
        if ($this->reqMethod === 'POST') {
            $errors = $this->validation->validate($post, 'User');
            if ($this->userDAO->checkUser($post)) {
                $errors['username'] = $this->userDAO->checkUser($post);
            }
            if ($this->userDAO->checkUserEmail($post)) {
                $errors['email'] = $this->userDAO->checkUserEmail($post);
            }
            if ($post->get('password') !== $post->get('cPassword')) {
                $errors['password'] = '<p class="red-text">Les mots de passe ne sont pas identiques</p>';
            }
            if (!$errors) {
                $token = 'qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM1234567890*';
                $token = str_shuffle($token);
                $this->userDAO->register($post, $token);
                $link = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REDIRECT_URL'] . "?route=confirm&token=" . $token . "&email=" . $post->get('email');
                $mail = new Mail();
                $mail->sendConfirmation($post, $link);
                $this->session->set('register', 'Un email de confirmation vous a été envoyé');
                return header('Location: index.php');
            }
            return $this->view->render('register', [
                'post' => $post,
                'errors' => $errors
            ]);
        }
        return $this->view->render('register');
    }
}
