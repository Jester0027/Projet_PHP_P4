<?php

namespace BlogApp\src\controller;

use BlogApp\config\Parameter;
use BlogApp\config\Session;
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

    public function addComment(Session $session, Parameter $post, $articleId)
    {
        if($this->isLoggedIn()) {
            $this->commentDAO->addComment($session, $post, $articleId);
            header('Location: index.php?route=article&articleId=' . $articleId);
        } else {
            $this->session->set('login', 'Vous devez vous connecter pour effectuer cette action');
            header('Location: index.php?route=login');
        }
    }

    public function reportComment()
    {

    }

    public function login(Parameter $post)
    {
        if(!$this->isLoggedIn()) {
            if ($this->reqMethod === 'POST') {
                $result = $this->userDAO->login($post);
                if($result && $result['isPasswordValid']) {
                    if (!$result['result']['is_verified']) {
                        $this->session->set('error_login', 'Votre compte n\'est pas validé');
                        return $this->view->render('login', [
                            'post' => $post
                        ]);
                    }
                    if($result['result']['status'] === '0') {
                        $this->session->set('error_login', 'Votre compte a été banni');
                        return $this->view->render('login', [
                            'post' => $post
                        ]);
                    }
                    $this->session->set('login_message', 'content de vous revoir');
                    $this->session->set('id', $result['result']['id']);
                    $this->session->set('role', $result['result']['name']);
                    $this->session->set('username', $post->get('username'));
                    $this->userDAO->resetToken($result['result']['id']);
                    /**
                     * 
                     * TODO
                     * 
                     * Si admin -> header admin
                     * sinon -> header accueil (ou page de profil)
                     */
                    header('Location: index.php');
                } else {
                    $this->session->set('error_login', 'Le pseudo ou le mot de passe est incorrect');
                    return $this->view->render('login', [
                        'post' => $post
                    ]);
                }
            }
            return $this->view->render('login');
        } else {
            header('location: index.php');
        }
        
    }

    public function register(Parameter $post)
    {
        if(!$this->isLoggedIn()) {
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
        } else {
            header('Location: index.php');
        }
    }

    public function lostPassword(Parameter $post)
    {
        if(!$this->isLoggedIn()) {
            if($this->reqMethod === 'POST') {
                $user = $this->userDAO->getUserFromEmail($post->get('email'));
                if(!$user) {
                    $this->session->set('password_recovery', 'Un email a été envoyé a l\'adresse indiquée');
                    return header('Location: index.php');
                };
                $token = 'qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM1234567890*';
                $token = str_shuffle($token);
                $this->userDAO->addToken($user->getId(), $token);
                $link = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REDIRECT_URL'] . "?route=passwordRecovery&token=" . $token . "&email=" . $post->get('email');
                $mail = new Mail();
                $mail->sendPasswordRecovery($post, $link);
                $this->session->set('password_recovery', 'Un email a été envoyé a l\'adresse indiquée');
                return header('Location: index.php');
            }
            return $this->view->render('lost_password');
        } else {
            return header('Location: index.php');
        }
    }
}
