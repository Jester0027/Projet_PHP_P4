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

    public function getUser($userId)
    {
        $sql = 'SELECT COUNT(id) FROM user WHERE id = ? AND is_verified = 1';
        $result = $this->createQuery($sql, [$userId]);
        $userExists = $result->fetchColumn();
        if (!$userExists) return false;
        $sql = 'SELECT user.id, user.username, role.name AS role, user.status, user.email FROM user INNER JOIN role ON user.role_id = role.id WHERE user.is_verified = 1 AND user.id = ?';
        $result = $this->createQuery($sql, [$userId]);
        $user = $result->fetch();
        $result->closeCursor();
        return $this->buildObject($user);
    }

    public function getUserFromEmail($email)
    {
        $sql = 'SELECT COUNT(email) FROM user WHERE email = ? AND is_verified = 1';
        $result = $this->createQuery($sql, [$email]);
        $userExists = $result->fetchColumn();
        if (!$userExists) return false;
        $sql = 'SELECT user.id, user.username, role.name AS role, user.status, user.email FROM user INNER JOIN role ON user.role_id = role.id WHERE user.is_verified = 1 AND user.email = ?';
        $result = $this->createQuery($sql, [$email]);
        $user = $result->fetch();
        $result->closeCursor();
        return $this->buildObject($user);
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

    public function checkPassword($id, $password)
    {
        $sql = 'SELECT password FROM user WHERE id = ?';
        $data = $this->createQuery($sql, [$id]);
        $result = $data->fetch();
        $isPasswordValid = password_verify($password, $result['password']);
        return $isPasswordValid;
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

    public function checkStatus($userId)
    {
        $sql = 'SELECT is_verified FROM user WHERE id = ?';
        $this->createQuery($sql, [$userId]);
    }

    public function register(Parameter $post, $token, $createdAt)
    {
        $sql = 'INSERT INTO user(username, password, role_id, status, email, token, created_at) VALUES(?, ?, 1, 1, ?, ?, ?)';
        // INSERT INTO user(username, password, role_id, status, email, token, created_at) VALUES(:username,...)
        $this->createQuery($sql, [
            $post->get('username'),
            password_hash($post->get('password'), PASSWORD_BCRYPT),
            $post->get('email'),
            $token,
            $createdAt
        ]);
    }

    public function addToken($userId, $token)
    {
        $sql = 'UPDATE user SET token = ? WHERE id = ?';
        $this->createQuery($sql, [
            $token,
            $userId
        ]);
    }

    public function resetToken($userId)
    {
        $sql = 'UPDATE user SET token = NULL WHERE id = ?';
        $this->createQuery($sql, [$userId]);
    }

    public function checkTokenAndEmail($token, $email)
    {
        $sql = 'SELECT COUNT(id) FROM user WHERE token = ? AND email = ?';
        $result = $this->createQuery($sql, [
            $token,
            $email
        ]);
        $validTokenAndEmail = $result->fetchColumn();
        if (!$validTokenAndEmail) {
            return false;
        } else {
            return true;
        }
    }

    public function login(Parameter $post)
    {
        $sql = 'SELECT user.id, user.role_id, user.password, user.status, user.is_verified, role.name FROM user INNER JOIN role ON role.id = user.role_id WHERE username = ?';
        $data = $this->createQuery($sql, [$post->get('username')]);
        $result = $data->fetch();
        $isPasswordValid = password_verify($post->get('password'), $result['password']);
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

        if (!$userExists) {
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

    public function changePassword($id, $password)
    {
        $sql = 'UPDATE user SET password = ? WHERE id = ?';
        $this->createQuery($sql, [
            password_hash($password, PASSWORD_BCRYPT),
            $id
        ]);
    }

    public function changeEmail($id, $email)
    {
        $sql = 'UPDATE user SET email = ? WHERE id = ?';
        $this->createQuery($sql, [
            $email,
            $id
        ]);
    }

    public function deleteUser($userId)
    {
        $sql = 'DELETE FROM user WHERE id = ?';
        $this->createQuery($sql, [$userId]);
        $sql = 'DELETE FROM comment WHERE user_id = ?';
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
