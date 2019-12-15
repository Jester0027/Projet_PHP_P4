<?php

namespace BlogApp\src\DAO;

use BlogApp\config\Parameter;
use BlogApp\config\Session;
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
        $article->setCaption($row['caption']);
        $article->setCreatedAt($row['created_at']);
        return $article;
    }

    public function getArticles()
    {
        $sql = 'SELECT article.id, article.title, article.content, article.caption, user.username, article.created_at FROM article INNER JOIN user ON article.user_id = user.id ORDER BY article.created_at DESC';
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

    public function addArticle(Parameter $post, Session $session)
    {
        $sql = 'INSERT INTO article(title, user_id, content, caption, created_at) VALUE(?, ?, ?, ?, NOW())';
        $this->createQuery($sql, [
            $post->get('title'),
            $session->get('id'),
            $post->get('content'),
            $post->get('caption')
        ]);
    }

    public function editArticle()
    {
        
    }

    public function deleteArticle($articleId)
    {

    }

    public function updateArticle($articleId)
    {
        
    }
}
