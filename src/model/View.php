<?php

namespace BlogApp\src\model;

use BlogApp\config\Request;

class View
{
    private $file;
    private $title;
    private $description;
    private $request;
    private $session;
    private $get;

    public function __construct()
    {
        $this->request = new Request();
        $this->session = $this->request->getSession();
        $this->get = $this->request->getGet();
        $this->description = "Blog officiel de Jean Forteroche";
    }
    
    public function render($template, $data = [], $scriptFiles = [], $cdn = [])
    {
        $this->file = '../templates/' . $template . '.php';
        $header = $this->renderFile('../templates/header.php', [
            'get' => $this->get,
            'session' => $this->session
        ]);
        $content = $this->renderFile($this->file, $data);
        $footer = $this->renderFile('../templates/footer.php', []);
        $view = $this->renderFile('../templates/base.php', [
            'title' => $this->title,
            'description' => $this->description,
            'header' => $header,
            'content' => $content,
            'footer' => $footer,
            'session' => $this->session,
            'scriptFiles' => $scriptFiles,
            'cdn' => $cdn
        ]);
        echo $view;
    }

    public function renderTemplate($template, $data = [])
    {
        $file = '../templates/templates/' . $template . '.php';
        $content = $this->renderFile($file, $data);
        echo $content;
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