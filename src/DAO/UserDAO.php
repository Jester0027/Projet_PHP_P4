<?php

namespace BlogApp\src\DAO;

use BlogApp\config\Parameter;

class UserDAO extends DAO
{
    public function register(Parameter $post)
    {
        $sql = 'INSERT INTO User(username, password, role, status) VALUES(?, ?, 0, 0)';
        $this->createQuery($sql, [
            $post->get('username'),
            password_hash($post->get('password'), PASSWORD_BCRYPT)
        ]);
    }

    public function login(Parameter $post)
    {
        
    }
}