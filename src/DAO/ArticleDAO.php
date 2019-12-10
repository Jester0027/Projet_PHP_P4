<?php

namespace BlogApp\src\DAO;

use BlogApp\config\Parameter;
use BlogApp\src\model\Article;

class ArticleDAO extends DAO
{
    private function buildObject($row)
    {
        $article = new Article();
        $article->setId($row['id']);
        $article->setTitle($row['title']);
        $article->setAuthor($row['username']);
        $article->setContent($row['content']);
        $article->setCreatedAt($row['created_at']);
        return $article;
    }

    public function getArticles()
    {
        $sql = 'SELECT article.id, article.title, article.content, user.username, article.created_at FROM article INNER JOIN user ON article.user_id = user.id ORDER BY article.created_at DESC';
        $result = $this->createQuery($sql);
        $articles = [];
        foreach ($result as $row) {
            array_push($articles, $this->buildObject($row));
        }
        $result->closeCursor();
        return $articles;
    }

    public function getArticle($articleId)
    {
        $sql = 'SELECT article.id, article.title, article.content, user.username, article.created_at FROM article INNER JOIN user ON article.user_id = user.id WHERE article.id = ?';
        $result = $this->createQuery($sql, [$articleId]);
        $article = $result->fetch();
        $result->closeCursor();
        return $this->buildObject($article);
    }

    public function addArticle(Parameter $post)
    {
        
    }
}
