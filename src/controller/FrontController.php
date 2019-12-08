<?php

namespace BlogApp\src\controller;

class FrontController extends Controller
{
    public function getHome()
    {
        $articles = $this->articleDAO->getArticles();
        return $this->view->render('home', [
            'articles' => $articles
        ]);
    }

    public function getArticle($articleId)
    {
        $article = $this->articleDAO->getArticle($articleId);
        $comments = $this->commentDAO->getCommentsFromArticleId($articleId);
        return $this->view->render('article', [
            'article' => $article,
            'comments' => $comments
        ]);
    }
}