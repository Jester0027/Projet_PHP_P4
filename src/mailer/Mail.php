<?php

namespace BlogApp\src\mailer;

use BlogApp\config\IMail;
use BlogApp\config\Parameter;
use BlogApp\src\model\User;

class Mail extends Mailer implements IMail
{
    public function sendConfirmation(Parameter $post, $link)
    {
        $from = self::ADDRESS;
        $to = $post->get('email');
        $subject = "Vérification d'authentification";
        $content = $this->render('confirm', [
            'post' => $post,
            'link' => $link
        ]);

        return $this->sendEmail($from, $to, $subject, $content, self::NAME);
    }

    public function sendPasswordRecovery(Parameter $post, $link)
    {
        $from = self::ADDRESS;
        $to = $post->get('email');
        $subject = "Récupération de mot de passe";
        $content = $this->render('password_recovery', [
            'post' => $post,
            'link' => $link
        ]);

        return $this->sendEmail($from, $to, $subject, $content, self::NAME);
    }

    public function sendEmailChange(parameter $post, $link, User $user)
    {
        $from = self::ADDRESS;
        $to = $post->get('newEmail');
        $subject = "Changement d'adresse Email";
        $content = $this->render('email_change', [
            'post' => $post,
            'link' => $link,
            'user' => $user
        ]);

        return $this->sendEmail($from, $to, $subject, $content, self::NAME);
    }
}