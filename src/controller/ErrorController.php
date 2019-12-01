<?php

namespace BlogApp\src\controller;

class ErrorController extends Controller
{
    public function get404()
    {
        $this->view->render('404');
        return header("HTTP/1.0 404 Not Found");
    }

    public function get500($e)
    {
        $this->view->render('500', [
            'error' => $e
        ]);
        return header('HTTP/1.1 500 Internal Server Error');
    }
}