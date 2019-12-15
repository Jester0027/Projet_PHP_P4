<?php

namespace BlogApp\src\DAO;

use BlogApp\config\Parameter;
use BlogApp\src\model\User;

class UserDAO extends DAO
{
    private function buildObject($row)
    {
        $user = new User();
        $user->setId($row['id']);
        $user->setUsername($row['username']);
        $user->setRole($row['role']);
        $user->setStatus($row['status']);
        $user->setEmail($row['email']);
        return $user;
    }

    public function getUsers()
    {
        $sql = 'SELECT user.id, user.username, role.name AS role, user.status, user.email FROM user INNER JOIN role ON user.role_id = role.id WHERE user.is_verified = 1';
        $result = $this->createQuery($sql);
        $users = [];
        foreach ($result as $row) {
            array_push($users, $this->buildObject($row));
        }
        $result->closeCursor();
        return $users;
    }

    public function checkUser(Parameter $post)
    {
        $sql = 'SELECT COUNT(username) FROM user WHERE username = ?';
        $result = $this->createQuery($sql, [$post->get('username')]);
        $isUsernameUnique = $result->fetchColumn();
        if ($isUsernameUnique) {
            return '<p class="red-text">Ce pseudo existe déjà</p>';
        }
    }

    public function checkUserEmail(Parameter $post)
    {
        $sql = 'SELECT COUNT(email) FROM user WHERE email = ?';
        $result = $this->createQuery($sql, [$post->get('email')]);
        $isEmailUnique = $result->fetchColumn();
        if ($isEmailUnique) {
            return '<p class="red-text">Un compte avec cette addresse E-mail a déja été créé</p>';
        }
    }

    public function register(Parameter $post, $token)
    {
        $sql = 'INSERT INTO user(username, password, role_id, status, email, token) VALUES(?, ?, 1, 1, ?, ?)';
        $this->createQuery($sql, [
            $post->get('username'),
            password_hash($post->get('password'), PASSWORD_BCRYPT),
            $post->get('email'),
            $token
        ]);
    }

    public function login(Parameter $post)
    {
        $sql = 'SELECT user.id, user.role_id, user.password, user.status, user.is_verified, role.name FROM user INNER JOIN role ON role.id = user.role_id WHERE username = ?';
        $data = $this->createQuery($sql, [$post->get('username')]);
        $result = $data->fetch();
        $isPasswordValid = password_verify($post->get('password'), $result['password']);
        /**
         * si is_verified && status -> token = NULL
         * si !status -> return false
         */
        return [
            'result' => $result,
            'isPasswordValid' => $isPasswordValid
        ];
    }

    public function confirm(Parameter $get)
    {
        $token = $get->get('token');
        $email = $get->get('email');

        $sql = 'SELECT username FROM user WHERE token = ? AND email = ?';
        $userExists = $this->createQuery($sql, [
            $token,
            $email
        ]);
        $userExists = $userExists->fetch();

        if(!$userExists) {
            return false;
        }

        $sql = 'UPDATE user SET is_verified = ?, token = ? WHERE token = ? AND email = ?';
        $this->createQuery($sql, [
            1,
            'NULL',
            $token,
            $email
        ]);
        return true;
    }

    public function deleteUser($userId)
    {
        $sql = 'DELETE FROM user WHERE id = ?';
        $this->createQuery($sql, [$userId]);
    }

    public function banUser($userId)
    {
        $this->toggleBan($userId, 0);
    }

    public function unbanUser($userId)
    {
        $this->toggleBan($userId, 1);
    }

    public function toggleBan($userId, $status)
    {
        $sql = 'UPDATE user SET status = ? WHERE id = ?';
        $this->createQuery($sql, [
            $status,
            $userId
        ]);
    }
}
