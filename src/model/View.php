<?php

namespace BlogApp\src\model;

use BlogApp\config\Request;

class View
{
    private $file;
    private $title;
    private $request;
    private $session;
    private $get;

    public function __construct()
    {
        $this->request = new Request();
        $this->session = $this->request->getSession();
        $this->get = $this->request->getGet();
    }

    public function render($template, $data = [])
    {
        $this->file = './templates/' . $template . '.php';
        $header = $this->renderFile('./templates/header.php', [
            'get' => $this->get,
            'session' => $this->session
        ]);
        $content = $this->renderFile($this->file, $data);
        $footer = $this->renderFile('./templates/footer.php', []);
        $view = $this->renderFile('./templates/base.php', [
            'title' => $this->title,
            'header' => $header,
            'content' => $content,
            'footer' => $footer,
            'session' => $this->session
        ]);
        echo $view;
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