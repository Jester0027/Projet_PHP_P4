<?php

namespace BlogApp\src\DAO;

use BlogApp\config\Parameter;
use BlogApp\config\Session;
use BlogApp\src\helpers\Pagination;
use BlogApp\src\model\Article;
use Exception;

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

    public function countArticles()
    {
        $sql = 'SELECT COUNT(id) FROM article';
        $count = $this->createQuery($sql)->fetchColumn();
        return $count;
    }

    public function getArticles($page = 1, int $limit = null)
    {
        $pagination = '';
        if($limit) {
            $count = $this->countArticles();
            $pagination = Pagination::createPagination($page, $limit, $count);
        }

        $sql = 'SELECT article.id, article.title, article.content, article.caption, user.username, article.created_at FROM article INNER JOIN user ON article.user_id = user.id ORDER BY article.created_at DESC ' . $pagination;
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
        $sql = 'SELECT article.id, article.title, article.content, user.username, article.caption, article.created_at FROM article INNER JOIN user ON article.user_id = user.id WHERE article.id = ?';
        $result = $this->createQuery($sql, [$articleId]);
        $article = $result->fetch();
        $result->closeCursor();
        return $this->buildObject($article);
    }

    public function getIdFromFirstArticle()
    {
        $sql = 'SELECT MIN(id) as id FROM article';
        $result = $this->createQuery($sql);
        $article = $result->fetch();
        $result->closeCursor();
        return $article['id'];
    }

    public function getPrevArticle($id)
    {
        $sql = "SELECT * FROM article WHERE id < :id ORDER BY id DESC LIMIT 0,1";
        $result = $this->createQuery($sql, ['id' => $id]);
        $article = $result->fetch();
        $result->closeCursor();
        $article = $this->buildObject($article);
        if($article->getId()) 
            return $article;
        return false;
    }

    public function getNextArticle($id)
    {
        $sql = "SELECT * FROM article WHERE id > :id LIMIT 0,1";
        $result = $this->createQuery($sql, ['id' => $id]);
        $article = $result->fetch();
        $result->closeCursor();
        $article = $this->buildObject($article);
        if($article->getId()) 
            return $article;
        return false;
    }

    public function addArticle(Parameter $post, Session $session, $createdAt)
    {
        try {
            $sql = 'INSERT INTO article(title, user_id, content, caption, created_at) VALUE(?, ?, ?, ?, ?)';
            $this->createQuery($sql, [
                $post->get('title'),
                $session->get('id'),
                $post->get('content'),
                $post->get('caption'),
                $createdAt
            ]);
            return true;
        } catch(Exception $e) {
            return false;
        }
    }

    public function editArticle(Parameter $post, $articleId)
    {
        $sql = 'UPDATE article SET title = ?, content = ?, caption = ? WHERE id = ?';
        $this->createQuery($sql, [
            $post->get('title'),
            $post->get('content'),
            $post->get('caption'),
            $articleId
        ]);
    }

    public function deleteArticle($articleId)
    {
        $sql = 'DELETE FROM article WHERE id = ?';
        $this->createQuery($sql, [$articleId]);
        $sql = 'DELETE FROM comment WHERE article_id = ?';
        $this->createQuery($sql, [$articleId]);
    }
}
