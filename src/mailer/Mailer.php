<?php

namespace BlogApp\src\mailer;

use PHPMailer\PHPMailer\PHPMailer;

abstract class Mailer
{
    protected function sendEmail($from, $to, $subject, $content, $name ='')
    {
        $mail = new PHPMailer();
        $mail->setFrom($from);
        $mail->addAddress($to, $name);
        $mail->Subject = $subject;
        $mail->isHTML(true);
        $mail->body = $content;

        $mail->send();
    }
}