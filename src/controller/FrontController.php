<?php

namespace BlogApp\src\controller;

use BlogApp\config\Parameter;
use BlogApp\config\Session;
use BlogApp\src\mailer\Mail;
use BlogApp\src\model\User;
use DateTime;
use DateTimeZone;

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

    public function addComment(Session $session, Parameter $post, $articleId)
    {
        if (!$this->isLoggedIn()) {
            $this->session->set('login', 'Vous devez vous connecter pour effectuer cette action');
            header('Location: index.php?route=login');
            exit();
        }
        $errors = $this->validation->validate($post, 'Comment');
        if (!$errors) {
            $this->commentDAO->addComment($session, $post, $articleId);
            header('Location: index.php?route=article&articleId=' . $articleId);
            exit();
        }
        $article = $this->articleDAO->getArticle($articleId);
        $comments = $this->commentDAO->getCommentsFromArticleId($articleId);
        return $this->view->render('article', [
            'post' => $post,
            'errors' => $errors,
            'article' => $article,
            'comments' => $comments
        ]);
    }

    public function reportComment(Parameter $get)
    {
        if (!$this->isLoggedIn()) {
            $this->session->set('login', 'Vous devez vous connecter pour effectuer cette action');
            header('Location: index.php?route=login');
            exit();
        } else if ($this->commentDAO->isAlreadyReported($get->get('commentId'))) {
            $this->session->set('comment', 'Vous ne pouvez plus signaler ce commentaire');
            header('Location: index.php?route=article&articleId=' . $get->get('articleId'));
            exit();
        }
        $this->commentDAO->reportComment($get->get('commentId'));
        $this->session->set('comment', 'Le commentaire a bien été signalé');
        header('Location: index.php?route=article&articleId=' . $get->get('articleId'));
    }

    public function login(Parameter $post)
    {
        if ($this->isLoggedIn()) {
            header('location: index.php');
            exit();
        }
        if ($this->reqMethod === 'POST') {
            $result = $this->userDAO->login($post);
            if ($result && $result['isPasswordValid']) {
                if (!$result['result']['is_verified']) {
                    $this->session->set('error_login', 'Votre compte n\'est pas validé');
                    return $this->view->render('login', ['post' => $post]);
                }
                if ($result['result']['status'] === '0') {
                    $this->session->set('error_login', 'Votre compte a été banni');
                    return $this->view->render('login', ['post' => $post]);
                }
                $this->session->set('login_message', 'Content de vous revoir');
                $this->session->set('id', $result['result']['id']);
                $this->session->set('role', $result['result']['name']);
                $this->session->set('username', $post->get('username'));
                $this->userDAO->resetToken($result['result']['id']);

                if ($result['result']['name'] === 'admin') {
                    header('location: index.php?route=admin');
                    exit();
                }
                header('Location: index.php');
                exit();
            }
            $this->session->set('error_login', 'Le pseudo ou le mot de passe est incorrect');
            return $this->view->render('login', [
                'post' => $post
            ]);
        }
        return $this->view->render('login');
    }

    public function register(Parameter $post)
    {
        if ($this->isLoggedIn()) {
            header('Location: index.php');
            exit();
        }
        if ($this->reqMethod === 'POST') {
            $user = new User();
            $errors = $user->checkRegister($post, $this->userDAO, $this->validation);
            if (!$errors) {
                if ($user->register($post, $this->userDAO)) {
                    $this->session->set('register', 'Un email de confirmation vous a été envoyé');
                } else {
                    $this->session->set('register', 'Une erreur est survenue, veuillez réessayer plus tard');
                }
                header('Location: index.php');
                exit();
            }
            return $this->view->render('register', [
                'post' => $post,
                'errors' => $errors
            ]);
        }
        return $this->view->render('register');
    }

    public function lostPassword(Parameter $post)
    {
        if ($this->isLoggedIn()) {
            header('Location: index.php');
            exit();
        }
        if ($this->reqMethod === 'POST') {
            $user = $this->userDAO->getUserFromEmail($post->get('email'));
            if ($user) {
                $token = $user->generateToken();
                $this->userDAO->addToken($user->getId(), $token);
                $link = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REDIRECT_URL'] . "?route=passwordRecovery&token=" . $token . "&email=" . $post->get('email');
                $mail = new Mail();
                $mail->sendPasswordRecovery($post, $link);
            }
            $this->session->set('password_recovery', 'Un email a été envoyé a l\'adresse indiquée');
            header('Location: index.php');
            exit();
        }
        return $this->view->render('lost_password');
    }
}
