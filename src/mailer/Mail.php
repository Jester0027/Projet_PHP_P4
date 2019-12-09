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
            <h1>Bonjour " . $post->get('username') . ",</h1>

            <p>Vous avez demandé une inscription sur mon blog avec les identifiants suivants:</p>
            <ul>
                <li>Pseudo: " . $post->get('username') . "</li>
                <li>Adresse E-mail: " . $post->get('email') . "</li>
            </ul>

            <p>Il ne vous reste plus qu'une étape pour valider votre inscription</p>
            <a href=\"" . $email . "\">Valider mon inscription</a>
        ";

        $this->sendEmail($from, $to, $subject, $content, "Jean Forteroche");
    }
}