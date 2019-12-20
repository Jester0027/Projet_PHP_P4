<?php

namespace BlogApp\src\constraint;

use BlogApp\config\Parameter;

class ArticleValidation
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
        if ($name === 'title') {
            $error = $this->checkTitle($name, $value);
            $this->addError($name, $error);
        } else if ($name === 'content') {
            $error = $this->checkContent($name, $value);
            $this->addError($name, $error);
        } else if ($name === 'caption') {
            $error = $this->checkCaption($name, $value);
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

    private function checkTitle($name, $value)
    {
        if ($this->constraint->notBlank($name, $value)) {
            return $this->constraint->notBlank('titre', $value);
        }
        if ($this->constraint->minLength($name, $value, 2)) {
            return $this->constraint->minLength('titre', $value, 2);
        }
        if ($this->constraint->maxLength($name, $value, 70)) {
            return $this->constraint->maxLength('titre', $value, 70);
        }
    }

    private function checkContent($name, $value)
    {
        if ($this->constraint->notBlank($name, $value)) {
            return $this->constraint->notBlank('contenu', $value);
        }
        if ($this->constraint->minLength($name, $value, 2)) {
            return $this->constraint->minLength('contenu', $value, 2);
        }
    }

    private function checkCaption($name, $value)
    { 
        if ($this->constraint->notBlank($name, $value)) {
            return $this->constraint->notBlank('description', $value);
        }
        if ($this->constraint->minLength($name, $value, 2)) {
            return $this->constraint->minLength('description', $value, 2);
        }
        if ($this->constraint->maxLength($name, $value, 70)) {
            return $this->constraint->maxLength('description', $value, 255);
        }
    }
}
