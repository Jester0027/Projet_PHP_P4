<?php

namespace BlogApp\src\DAO;

use BlogApp\config\Parameter;

class UserDAO extends DAO
{
    public function register(Parameter $post, $token)
    {
        $sql = 'INSERT INTO User(username, password, role, status, email, token) VALUES(?, ?, 0, 0, ?, ?)';
        $this->createQuery($sql, [
            $post->get('username'),
            password_hash($post->get('password'), PASSWORD_BCRYPT),
            $post->get('email'),
            $token
        ]);
    }

    public function login(Parameter $post)
    {
        
    }

    public function confirm(Parameter $get)
    {
        $token = $get->get('token');
        $email = $get->get('email');
        $sql = 'UPDATE user SET is_verified = ?, token = ? WHERE token = ? AND email = ?';
        $this->createQuery($sql, [
            1,
            '',
            $token,
            $email
        ]);
    }
}