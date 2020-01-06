<?php

namespace BlogApp\src\controller;

use BlogApp\config\Parameter;
use BlogApp\config\Session;
use BlogApp\src\mailer\Mail;

class BackController extends Controller
{
    public function admin()
    {
        if (!$this->isAdmin()) {
            $this->session->set('admin_access', 'Vous devez disposer d\'un acces administrateur');
            header('Location: index.php');
            exit();
        }
        return $this->view->render('admin', [], ['admin'], ['https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js']);
    }

    public function _adminArticles()
    {
        if (!$this->isAdmin()) {
            echo 'Forbidden Access';
            header("http/1.0 403 forbidden");
            exit();
        }
        $articles = $this->articleDAO->getArticles();
        return $this->view->renderTemplate('adminArticles', [
            'articles' => $articles
        ]);
    }

    public function _adminUsers()
    {
        if (!$this->isAdmin()) {
            echo 'Forbidden Access';
            header("http/1.0 403 forbidden");
            exit();
        }
        $users = $this->userDAO->getUsers();
        return $this->view->renderTemplate('adminUsers', [
            'users' => $users
        ]);
    }

    public function _adminReportedComments()
    {
        if (!$this->isAdmin()) {
            echo 'Forbidden Access';
            header("http/1.0 403 forbidden");
            exit();
        }
        $reportedComments = $this->commentDAO->getReportedComments();
        return $this->view->renderTemplate('adminReports', [
            'reportedComments' => $reportedComments
        ]);
    }

    public function addArticle(Parameter $post, Session $session)
    {
        if (!$this->isAdmin()) {
            $this->session->set('admin_access', 'Vous devez disposer d\'un acces administrateur');
            header('Location: index.php');
            exit();
        }
        if ($this->reqMethod === 'POST') {
            $errors = $this->validation->validate($post, 'Article');
            if (!$errors) {
                $this->articleDAO->addArticle($post, $session);
                $this->session->set('add_article', 'Votre article a bien été ajouté');
                header('Location: index.php?route=admin');
                exit();
            }
        }
        return $this->view->render('add_article', [
            'post' => $post,
            'errors' => $errors
        ]);
    }

    public function editArticle(Parameter $post, $articleId, $session)
    {
        if (!$this->isAdmin()) {
            $this->session->set('admin_access', 'Vous devez disposer d\'un acces administrateur');
            header('Location: index.php');
            exit();
        }
        $article = $this->articleDAO->getArticle($articleId);
        // if($article->getAuthor() != $session->get('username')) {
        //     $this->session->set('article_access', 'Vous n\'etes pas l\'auteur de cet article');
        //     return header('Location: index.php?route=admin');
        // }
        if ($this->reqMethod === 'POST') {
            $errors = $this->validation->validate($post, 'Article');
            if (!$errors) {
                $this->articleDAO->editArticle($post, $articleId);
                $this->session->set('add_article', 'Votre article a bien été modifié');
                header('Location: index.php?route=admin');
                exit();
            }
        }
        return $this->view->render('edit_article', [
            'post' => $post,
            'errors' => $errors,
            'article' => $article,
            'articleId' => $articleId
        ]);
    }

    public function deleteArticle(Parameter $get)
    {
        if (!$this->isAdmin()) {
            $this->session->set('admin_access', 'Vous devez disposer d\'un acces administrateur');
            header('Location: index.php');
            exit();
        }
        $this->articleDAO->deleteArticle($get->get('articleId'));
        $this->session->set('add_article', 'Votre article a bien été supprimé');
        header('Location: index.php?route=admin');
    }

    public function confirm(Parameter $get)
    {
        if ($get->get('token') && $get->get('email')) {
            $result = $this->userDAO->confirm($get);
            if ($result) {
                $this->session->set('validation', 'Votre compte a bien été validé, vous pouvez vous connecter');
            } else {
                $this->session->set('validation', 'Erreur: l\'utilisateur n\'existe pas ou a déja été validé');
            }
        }
        header('Location: index.php');
        exit();
    }

    public function passwordRecovery(Parameter $post, Parameter $get)
    {
        $isValid = $this->userDAO->checkTokenAndEmail($get->get('token'), $get->get('email'));
        if ($isValid) {
            if ($this->reqMethod === 'POST') {
                $errors = $this->validation->validate($post, 'User');
                if ($post->get('password') !== $post->get('cPassword')) {
                    $errors['password'] = 'Les mots de passe ne sont pas identiques';
                }
                if (!$errors) {
                    $user = $this->userDAO->getUserFromEmail($post->get('email'));
                    $this->userDAO->resetToken($user->getId());
                    $this->userDAO->changePassword($user->getId(), $post->get('password'));
                    $this->session->set('pw_change', 'Votre mot de passe a bien été mis a jour');
                    header('Location: index.php');
                    exit();
                }
            }
            return $this->view->render('password_recovery', [
                'error' => $errors['password'],
                'token' => $get->get('token'),
                'email' => $get->get('email')
            ]);
        }
        header('Location: index.php');
        exit();
    }

    public function profile(Session $session)
    {
        if (!$this->isLoggedIn()) {
            header('Location: index.php');
            exit();
        }
        $user = $this->userDAO->getUser($session->get('id'));
        return $this->view->render('profile', ['user' => $user], ['profil']);
    }

    public function changeEmail(Parameter $post, Session $session)
    {
        if (!$this->isLoggedIn()) {
            $this->session->set('profile_change', 'Vous devez vous connecter pour effectuer cette action');
            header('Location: index.php');
            exit();
        }
        if ($this->reqMethod === 'POST') {
            $user = $this->userDAO->getUser($session->get('id'));
            $errors = $this->validation->validate($post, 'User');
            $password = $post->get('password');
            $newEmail = $post->get('newEmail');
            $userAtNewEmail = $this->userDAO->getUserFromEmail($newEmail);
            $isPasswordValid = $this->userDAO->checkPassword($user->getId(), $password);

            /**
             * TODO:
             *  - retirer les balises HTML du controller et les mettre sur les vues
             *  - Generer le lien dans le Mail
             */
            if ($userAtNewEmail) {
                $errors['newEmail'] = 'Un compte avec cette adresse Email a déja été créé';
            }
            if (!$isPasswordValid) {
                $errors['password'] = 'Le mot de passe est incorrect';
            }
            if (!$errors) {
                $user->generateToken();
                $link = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REDIRECT_URL'] . "?route=confirmChangeEmail&token=" . $user->getToken() . "&email=" . $user->getEmail() . "&newEmail=" . $newEmail;
                $mail = new Mail();
                if ($mail->sendEmailChange($post, $link, $user)) {
                    $this->userDAO->addToken($session->get('id'), $user->getToken());
                    $this->session->set('profile_change', 'Un email de confirmation vous a été envoyé');
                } else {
                    $this->session->set('profile_change', 'Un problème est survenu lors de l\'envoi du mail');
                }
                header('Location: index.php?route=profile');
                exit();
            }
        }
        return $this->view->render('profile', [
            'emailErrors' => $errors,
            'emailPost' => $post,
            'user' => $user
        ], ['profil']);
    }

    public function confirmChangeEmail(Parameter $get, Session $session)
    {
        if (!$this->isLoggedIn()) {
            $this->session->set('profile_change', 'Vous devez vous connecter pour effectuer cette action');
            header('Location: index.php');
            exit();
        }
        $token = $get->get('token');
        $currentEmail = $get->get('email');
        $newEmail = $get->get('newEmail');
        $user = $this->userDAO->getUser($session->get('id'));

        $userValid = $this->userDAO->checkTokenAndEmail($token, $currentEmail);
        if (!$userValid) {
            $this->session->set('profile_change', 'Erreur');
            return header('Location: index.php');
            $this->userDAO->changeEmail($user->getId(), $newEmail);
            $this->userDAO->resetToken($user->getId());
            $this->session->set('profile_change', 'Votre adresse Email a été changée');
        }
        header('Location: index.php?route=profile');
        exit();
    }

    public function changePassword(Parameter $post, Session $session)
    {
        if (!$this->isLoggedIn()) {
            $this->session->set('profile_change', 'Vous devez vous connecter pour effectuer cette action');
            header('Location: index.php');
            exit();
        }
        $user = $this->userDAO->getUser($session->get('id'));
        if ($this->reqMethod === 'POST') {
            $errors = $this->validation->validate($post, 'User');
            $password = $post->get('password');
            $newPassword = $post->get('newPassword');
            $cNewPassword = $post->get('cNewPassword');
            $isPasswordValid = $this->userDAO->checkPassword($user->getId(), $password);
            if (!$isPasswordValid) {
                $errors['password'] = 'Le mot de passe est incorrect';
            }
            if ($newPassword !== $cNewPassword) {
                $errors['newPassword'] = 'Les mots de passe ne sont pas identiques';
            }
            if (!$errors) {
                $this->userDAO->changePassword($user->getId(), $newPassword);
                $this->session->set('profile_change', 'Le mot de passe a bien été changé');
                header('Location: index.php?route=profile');
                exit();
            }
        }
        return $this->view->render('profile', [
            'pwErrors' => $errors,
            'pwPost' => $post,
            'user' => $user
        ], ['profil']);
    }

    public function deleteAccount(Parameter $post, Session $session)
    {
        if (!$this->isLoggedIn()) {
            $this->session->set('profile_change', 'Vous devez vous connecter pour effectuer cette action');
            header('Location: index.php');
            exit();
        }
        $user = $this->userDAO->getUser($session->get('id'));
        if ($this->reqMethod === 'POST') {
            $wrongInputs = '';
            $password = $post->get('password');
            $isPasswordValid = $this->userDAO->checkPassword($user->getId(), $password);
            if (!$isPasswordValid) {
                $wrongInputs = 'Le mot de passe est incorrect';
            }
            if (!$wrongInputs) {
                $this->userDAO->deleteUser($user->getId());
                $session->stop();
                $session->start();
                $this->session->set('profile_change', 'Votre compte a bien été supprimé');
                header('Location: index.php');
                exit();
            }
        }
        return $this->view->render('profile', [
            'delAccountError' => $wrongInputs,
            'delAccountPost' => $post,
            'user' => $user
        ], ['profil']);
    }

    public function logout()
    {
        if ($this->isLoggedIn()) {
            $this->session->stop();
            $this->session->start();
            $this->session->set('logout', 'À bientôt');
        }
        header('Location: index.php');
        exit();
    }

    public function deleteUser($userId)
    {
        if (!$this->isAdmin()) {
            $this->session->set('admin_access', 'Vous devez disposer d\'un acces administrateur');
            header('Location: index.php');
            exit();
        }
        $this->userDAO->deleteUser($userId);
        $this->session->set('user_action', 'L\'utilisateur a bien été supprimé');
        header('Location: index.php?route=admin');
        exit();
    }

    public function banUser($userId)
    {
        if (!$this->isAdmin()) {
            $this->session->set('admin_access', 'Vous devez disposer d\'un acces administrateur');
            header('Location: index.php');
            exit();
        }
        $this->userDAO->banUser($userId);
        $this->session->set('user_action', 'L\'utilisateur a bien été banni');
        header('Location: index.php?route=admin');
        exit();
    }

    public function unbanUser($userId)
    {
        if (!$this->isAdmin()) {
            $this->session->set('admin_access', 'Vous devez disposer d\'un acces administrateur');
            header('Location: index.php');
            exit();
        }
        $this->userDAO->unbanUser($userId);
        $this->session->set('user_action', 'L\'utilisateur a bien été débanni');
        header('Location: index.php?route=admin');
        exit();
    }

    public function pardonComment(Parameter $get)
    {
        if (!$this->isAdmin()) {
            $this->session->set('admin_access', 'Vous devez disposer d\'un acces administrateur');
            header('Location: index.php');
            exit();
        }
        $this->commentDAO->pardonComment($get->get('commentId'));
        $this->session->set('comment_action', 'Le commentaire a bien été pardonné');
        header('Location: index.php?route=admin');
    }

    public function deleteComment(Parameter $get)
    {
        if (!$this->isAdmin()) {
            $this->session->set('admin_access', 'Vous devez disposer d\'un acces administrateur');
            header('Location: index.php');
            exit();
        }
        $this->commentDAO->deleteComment($get->get('commentId'));
        $this->session->set('comment_action', 'Le commentaire a bien été supprimé');
        header('Location: index.php?route=admin');
    }
}
