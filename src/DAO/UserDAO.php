<?php

namespace BlogApp\src\DAO;

use BlogApp\config\Parameter;

class UserDAO extends DAO
{
    public function checkUser($post)
    {
        $sql = 'SELECT COUNT(username) FROM user WHERE username = ?';
        $result = $this->createQuery($sql, [$post->get('username')]);
        $isUsernameUnique = $result->fetchColumn();
        if ($isUsernameUnique) {
            return '<p class="red-text">Ce pseudo existe déjà</p>';
        }
    }

    public function checkUserEmail($post)
    {
        $sql = 'SELECT COUNT(email) FROM user WHERE email = ?';
        $result = $this->createQuery($sql, [$post->get('email')]);
        $isEmailUnique = $result->fetchColumn();
        if($isEmailUnique) {
            return '<p class="red-text">Un compte avec cette addresse E-mail a déja été créé</p>';
        }
    }

    public function register(Parameter $post, $token)
    {
        $sql = 'INSERT INTO user(username, password, role_id, status, email, token) VALUES(?, ?, 1, 0, ?, ?)';
        $this->createQuery($sql, [
            $post->get('username'),
            password_hash($post->get('password'), PASSWORD_BCRYPT),
            $post->get('email'),
            $token
        ]);
    }

    public function login(Parameter $post)
    {
        $sql = 'SELECT user.id, user.role_id, user.password, user.is_verified, role.name FROM user INNER JOIN role ON role.id = user.role_id WHERE username = ?';
        $data = $this->createQuery($sql, [$post->get('username')]);
        $result = $data->fetch();
        $isPasswordValid = password_verify($post->get('password'), $result['password']);
        $isVerified = $result['is_verified'];
        return [
            'result' => $result,
            'isPasswordValid' => $isPasswordValid,
            'isVerified' => $isVerified
        ];
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