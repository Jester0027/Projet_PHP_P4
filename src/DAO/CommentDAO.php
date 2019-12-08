<?php

namespace BlogApp\src\DAO;

use BlogApp\src\model\Comment;

class CommentDAO extends DAO
{
    private function buildObject($row)
    {
        $comment = new Comment();
        $comment->setId($row['id']);
        $comment->setAuthor($row['username']);
        $comment->setContent($row['content']);
        $comment->setCreatedAt($row['created_at']);
        return $comment;
    }

    public function getCommentsFromArticleId($articleId)
    {
        $sql = 'SELECT comment.id, user.username, comment.content, comment.is_reported, comment.created_at FROM comment INNER JOIN user ON comment.user_id = user.id WHERE article_id = ? ORDER BY comment.created_at DESC';
        $result = $this->createQuery($sql, [$articleId]);
        $comments = [];
        foreach($result as $row) {
            $commentId = $row['id'];
            $comments[$commentId] = $this->buildObject($row);
        }
        $result->closeCursor();
        return $comments;
    }
}