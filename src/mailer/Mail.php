<?php

namespace BlogApp\src\mailer;

use BlogApp\config\Parameter;

class Mail extends Mailer
{
    public function sendConfirmation(Parameter $post, $link)
    {
        $from = "jean.forteroche@blog.com";
        $to = $post->get('email');
        $subject = "Vérification d'authentification";
        $content = $this->render('confirm', [
            'post' => $post,
            'link' => $link
        ]);

        return $this->sendEmail($from, $to, $subject, $content, "Jean Forteroche");
    }
}