<?php

namespace BlogApp\src\mailer;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

abstract class Mailer
{
    protected function sendEmail($from, $to, $subject, $content, $name ='')
    {
        $mail = new PHPMailer(true);
        try {
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';
            $mail->setFrom($from, $name);
            $mail->addAddress($to);
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $content;
    
            $mail->send();
        } catch(Exception $e) {
            return $e;
        }
    }
}