<?php

namespace BlogApp\src\constraint;

class Constraint
{
    public function notBlank($name, $value)
    {
        if (empty($value)) {
            return '<p class="red-text">Le champ ' . $name . ' saisi est vide</p>';
        }
    }

    public function minLength($name, $value, $minSize)
    {
        if (strlen($value) < $minSize) {
            return '<p class="red-text">Le champ ' . $name . ' doit contenir au moins ' . $minSize . ' caractères</p>';
        }
    }

    public function maxLength($name, $value, $maxSize)
    {
        if (strlen($value) > $maxSize) {
            return '<p class="red-text">Le champ ' . $name . ' doit contenir au maximum ' . $maxSize . ' caractères</p>';
        }
    }

    public function hasChars($name, $value, $regex, $message = '')
    {
        if(preg_match($regex, $value)) {
            return '<p class="red-text">Le champ ' . $name . ' doit contenir des caractères spéciaux : <span>' . $message === '' ? $regex : $message . '</span></p>';
            // /^.*[!@#$%^&*()<>?:"|,.\/;'\\\[\]{}]+.*$/
        }
    }
}
