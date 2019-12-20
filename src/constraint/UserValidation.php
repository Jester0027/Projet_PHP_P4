<?php

namespace BlogApp\src\constraint;

use BlogApp\config\Parameter;

class UserValidation
{

    private $errors = [];
    private $constraint;

    public function __construct()
    {
        $this->constraint = new Constraint();
    }

    public function check(Parameter $post)
    {
        foreach ($post->all() as $key => $value) {
            $this->checkField($key, $value);
        }
        return $this->errors;
    }

    private function checkField($name, $value)
    {
        if ($name === 'username') {
            $error = $this->checkUsername($name, $value);
            $this->addError($name, $error);
        } else if ($name === 'password') {
            $error = $this->checkPassword($name, $value);
            $this->addError($name, $error);
        } else if($name === 'email') {
            $error = $this->checkEmail($name, $value);
            $this->addError($name, $error);
        }
    }

    private function addError($name, $error)
    {
        if ($error) {
            $this->errors += [
                $name => $error
            ];
        }
    }

    private function checkUsername($name, $value)
    {
        if ($this->constraint->notBlank($name, $value)) {
            return $this->constraint->notBlank('pseudo', $value);
        }
        if ($this->constraint->minLength($name, $value, 4)) {
            return $this->constraint->minLength('pseudo', $value, 4);
        }
        if ($this->constraint->maxLength($name, $value, 70)) {
            return $this->constraint->maxLength('pseudo', $value, 70);
        }
    }

    private function checkEmail($name, $value)
    {
        if ($this->constraint->notBlank($name, $value)) {
            return $this->constraint->notBlank('E-mail', $value);
        }
        if ($this->constraint->minLength($name, $value, 4)) {
            return $this->constraint->minLength('E-mail', $value, 4);
        }
        if ($this->constraint->maxLength($name, $value, 70)) {
            return $this->constraint->maxLength('E-mail', $value, 70);
        }
    }

    private function checkPassword($name, $value)
    {
        if ($this->constraint->notBlank($name, $value)) {
            return $this->constraint->notBlank('mot de passe', $value);
        }
        if ($this->constraint->minLength($name, $value, 4)) {
            return $this->constraint->minLength('mot de passe', $value, 4);
        }
        if ($this->constraint->maxLength($name, $value, 255)) {
            return $this->constraint->maxLength('mot de passe', $value, 255);
        }
    }

}