<?php

namespace BlogApp\src\controller;

use BlogApp\config\Parameter;
use BlogApp\config\Session;
use BlogApp\src\mailer\Mail;

class BackController extends Controller
{
    public function admin()
    {
        if ($this->isAdmin()) {
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
        if ($this->isAdmin()) {
            if ($this->reqMethod === 'POST') {
                $errors = $this->validation->validate($post, 'Article');
                if(!$errors) {
                    $this->articleDAO->addArticle($post, $session);
                    $this->session->set('add_article', 'Votre article a bien été ajouté');
                    return header('Location: index.php?route=admin');
                }
                return $this->view->render('add_article', [
                    'post' => $post,
                    'errors' => $errors
                ]);
            }
            return $this->view->render('add_article');
        } else {
            $this->session->set('admin_access', 'Vous devez disposer d\'un acces administrateur');
            header('Location: index.php');
        }
    }

    public function editArticle(Parameter $post, $articleId, $session)
    {
        if ($this->isAdmin()) {
            $article = $this->articleDAO->getArticle($articleId);
            // if($article->getAuthor() != $session->get('username')) {
            //     $this->session->set('article_access', 'Vous n\'etes pas l\'auteur de cet article');
            //     return header('Location: index.php?route=admin');
            // }
            if ($this->reqMethod === 'POST') {
                $errors = $this->validation->validate($post, 'Article');
                if(!$errors) {
                    $this->articleDAO->editArticle($post, $articleId);
                    $this->session->set('add_article', 'Votre article a bien été modifié');
                    return header('Location: index.php?route=admin');
                }
                return $this->view->render('edit_article', [
                    'post' => $post,
                    'errors' => $errors,
                    'article' => $article,
                    'articleId' => $articleId
                ]);
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
        if ($get->get('token') && $get->get('email')) {
            $result = $this->userDAO->confirm($get);
            if ($result) {
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
        if ($isValid) {
            if ($this->reqMethod === 'POST') {
                $errors = $this->validation->validate($post, 'User');
                if($post->get('password') !== $post->get('cPassword')) {
                    $errors['password'] = '<p class="red-text">Les mots de passe ne sont pas identiques</p>';
                }
                if(!$errors) {
                    $user = $this->userDAO->getUserFromEmail($post->get('email'));
                    $this->userDAO->resetToken($user->getId());
                    $this->userDAO->changePassword($user->getId(), $post->get('password'));
                    $this->session->set('pw_change', 'Votre mot de passe a bien été mis a jour');
                    return header('Location: index.php');
                }
                return $this->view->render('password_recovery', [
                    'error' => $errors['password'],
                    'token' => $get->get('token'),
                    'email' => $get->get('email')
                ]);
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
        if ($this->isLoggedIn()) {
            return $this->view->render('profile', [
                'session' => $session
            ], [
                'profil'
            ]);
        } else {
            header('Location: index.php');
        }
    }

    public function changeEmail(Parameter $post, Session $session, Parameter $get)
    {
        if ($this->isLoggedIn()) {
            $user = $this->userDAO->getUser($session->get('id'));
            if ($this->reqMethod === 'POST') {
                $errors = $this->validation->validate($post, 'User');
                $currentEmail = $post->get('email');
                $password = $post->get('password');
                $newEmail = $post->get('newEmail');
                $userAtNewEmail = $this->userDAO->getUserFromEmail($newEmail);
                $isPasswordValid = $this->userDAO->checkPassword($user->getId(), $password);
                if ($userAtNewEmail) {
                    $errors['newEmail'] = '<p class="red-text">Un compte avec cette adresse Email a déja été créé</p>';
                }
                if(!$isPasswordValid) {
                    $errors['password'] = '<p class="red-text">Le mot de passe est incorrect</p>';
                }
                if($user->getEmail() !== $currentEmail) {
                    $errors['email'] = '<p class="red-text">L\'adresse Email est incorrecte</p>';
                }
                if(!$errors) {
                    $token = 'qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM1234567890*';
                    $token = str_shuffle($token);
                    $link = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REDIRECT_URL'] . "?route=changeEmail&token=" . $token . "&email=" . $currentEmail . "&newEmail=" . $newEmail;
                    $mail = new Mail();
                    $mail->sendEmailChange($post, $link, $user);
                    $this->userDAO->addToken($session->get('id'), $token);
                    $this->session->set('profile_change', 'Un email de confirmation vous a été envoyé');
                    return header('Location: index.php?route=profile');
                }
                return $this->view->render('profile', [
                    'emailErrors' => $errors,
                    'emailPost' => $post,
                    'session' => $session
                ], [
                    'profil'
                ]);
            } else {
                $token = $get->get('token');
                $currentEmail = $get->get('email');
                $newEmail = $get->get('newEmail');

                $userValid = $this->userDAO->checkTokenAndEmail($token, $currentEmail);
                if (!$userValid) {
                    $this->session->set('profile_change', 'Erreur');
                    return header('Location: index.php');
                }

                $this->userDAO->changeEmail($user->getId(), $newEmail);
                $this->userDAO->resetToken($user->getId());
                $this->session->set('profile_change', 'Votre adresse Email a été changée');
                return header('Location: index.php?route=profile');
            }
        } else {
            $this->session->set('profile_change', 'Vous devez vous connecter pour effectuer cette action');
            header('Location: index.php');
        }
    }

    public function changePassword(Parameter $post, Session $session)
    {
        if ($this->isLoggedIn()) {
            $user = $this->userDAO->getUser($session->get('id'));
            if ($this->reqMethod === 'POST') {
                $errors = $this->validation->validate($post, 'User');
                $email = $post->get('email');
                $password = $post->get('password');
                $newPassword = $post->get('newPassword');
                $cNewPassword = $post->get('cNewPassword');
                $isPasswordValid = $this->userDAO->checkPassword($user->getId(), $password);
                if ($user->getEmail() !== $email) {
                    $errors['email'] = '<p class="red-text">L\'adresse Email est incorrecte</p>';
                }
                if (!$isPasswordValid) {
                    $errors['password'] = '<p class="red-text">Le mot de passe est incorrect</p>';
                }
                if ($newPassword !== $cNewPassword) {
                    $errors['newPassword'] = '<p class="red-text">Les mots de passe ne sont pas identiques</p>';
                }
                if(!$errors) {
                    $this->userDAO->changePassword($user->getId(), $newPassword);
                    $this->session->set('profile_change', 'Le mot de passe a bien été changé');
                    return header('Location: index.php?route=profile');
                }
                return $this->view->render('profile', [
                    'pwErrors' => $errors,
                    'pwPost' => $post,
                    'session' => $session
                ], [
                    'profil'
                ]);
            }
            return header('Location: index.php?route=profile');
        } else {
            $this->session->set('profile_change', 'Vous devez vous connecter pour effectuer cette action');
            header('Location: index.php');
        }
    }

    public function deleteAccount(Parameter $post, Session $session)
    {
        if($this->isLoggedIn()) {
            $user = $this->userDAO->getUser($session->get('id'));
            if($this->reqMethod === 'POST') {
                $wrongInputs = '';
                $email = $post->get('email');
                $password = $post->get('password');
                $isPasswordValid = $this->userDAO->checkPassword($user->getId(), $password);
                if ($user->getEmail() !== $email || !$isPasswordValid) {
                    $wrongInputs = '<p class="red-text">L\'adresse Email et/ou le mot de passe est incorrect(e)</p>';
                }
                if(!$wrongInputs) {
                    $this->userDAO->deleteUser($user->getId());
                    $session->stop();
                    $session->start();
                    $this->session->set('profile_change', 'Votre compte a bien été supprimé');
                    return header('Location: index.php');
                }
                return $this->view->render('profile', [
                    'delAccountError' => $wrongInputs,
                    'delAccountPost' => $post,
                    'session' => $session
                ], [
                    'profil'
                ]); 
            }
            return header('Location: index.php');
        } else {
            $this->session->set('profile_change', 'Vous devez vous connecter pour effectuer cette action');
            header('Location: index.php');
        }
    }

    public function logout()
    {
        if ($this->isLoggedIn()) {
            $this->session->stop();
            $this->session->start();
            $this->session->set('logout', 'A bientot');
        }
        header('Location: index.php');
    }

    public function deleteUser($userId)
    {
        if ($this->isAdmin()) {
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
        if ($this->isAdmin()) {
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
        if ($this->isAdmin()) {
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
