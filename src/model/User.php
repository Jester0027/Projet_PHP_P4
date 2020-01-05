<?php

namespace BlogApp\src\model;

class User
{
    private $id;
    private $username;
    private $password;
    private $role;
    private $status;
    private $email;
    private $isVerified;
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
        
        for($i = 0; $i < 70; $i++) {
            $token .= $tokenStr[rand(0, strlen($tokenStr)-1)];
        }

        $this->token = $token;
    }

    /**
     * @return bool
     */
    public function register()
    {
        /**
         * TODO: 
         *  generer le token
         *  enregistrer l'utilisateur
         *  envoyer l'email
         */
    }

    
    public function checkRegister()
    {
        /**
         * TODO:
         *  Validate User
         *  Vérifier les inputs
         */
    }
}
