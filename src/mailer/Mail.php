<?php

namespace BlogApp\src\mailer;

use BlogApp\config\Parameter;

class Mail extends Mailer
{
    public function sendConfirmation(Parameter $post, $email)
    {
        $from = "jean.forteroche@blog.com";
        $to = $post->get('email');
        $subject = "Vérification d'authentification";
        $content = "
            <h1>Bonjour " . $post->get('username') . "</h1>

            <p>Il ne vous reste plus qu'une étape pour valider votre inscription</p>
            <a href=\"" . $email . "\">Confirmer mon inscription</a>
        ";

        $this->sendEmail($from, $to, $subject, $content);
    }
}