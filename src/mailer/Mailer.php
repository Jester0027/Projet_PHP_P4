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

    protected function render($template, $data = [])
    {
        $this->file = '../templates/mails/' . $template . '.php';
        $content = $this->renderFile($this->file, $data);
        return $content;
    }

    private function renderFile($file, $data)
    {
        if (file_exists($file)) {
            extract($data);
            ob_start();
            require $file;
            return ob_get_clean();
        }
        header('Location: index.php?route=notFound');
    }
}