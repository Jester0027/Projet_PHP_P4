<?php

namespace BlogApp\src\model;

use BlogApp\config\Parameter;
use BlogApp\src\constraint\Validation;
use BlogApp\src\DAO\UserDAO;
use BlogApp\src\mailer\Mail;
use DateTime;
use DateTimeZone;
use Exception;

class User
{
    private $id;
    private $username;
    private $password;
    private $role;
    private $status;
    private $email;
    private $isVerified;
    private $createdAt;
    private $token;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role)
    {
        $this->role = $role;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getIsVerified()
    {
        return $this->isVerified;
    }

    public function setIsVerified($isVerified)
    {
        $this->isVerified = $isVerified;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function setToken($token)
    {
        $this->token = $token;
    }

    public function generateToken()
    {
        $token = "";
        $tokenStr = 'qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM1234567890-_.~';

        for ($i = 0; $i < 70; $i++) {
            $token .= $tokenStr[rand(0, strlen($tokenStr) - 1)];
        }

        $this->token = $token;
    }


    public function register(Parameter $post, UserDAO $userDAO)
    {
        try {
            $this->generateToken();
            $this->setCreatedAt(new DateTime());
            $this->createdAt->setTimezone(new DateTimeZone('Europe/Paris'));
            $userDAO->register($post, $this->getToken(), $this->getCreatedAt()->format('Y-m-d H:i:s'));
            $link = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REDIRECT_URL'] . "?route=confirm&token=" . $this->getToken() . "&email=" . $post->get('email');
            $mail = new Mail();
            $mail->sendConfirmation($post, $link);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function checkRegister(Parameter $post, UserDAO $userDAO, Validation $validation)
    {
        $errors = $validation->validate($post, 'User');
        if ($userDAO->checkUser($post)) {
            $errors['username'] = $userDAO->checkUser($post);
        }
        if ($userDAO->checkUserEmail($post)) {
            $errors['email'] = $userDAO->checkUserEmail($post);
        }
        if ($post->get('password') !== $post->get('cPassword')) {
            $errors['password'] = 'Les mots de passe ne sont pas identiques';
        }
        return $errors;
    }
}
