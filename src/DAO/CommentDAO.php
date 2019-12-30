<?php

namespace BlogApp\src\DAO;

use BlogApp\config\Parameter;
use BlogApp\config\Session;
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
        $sql = 'SELECT comment.id, user.username, comment.content, comment.is_reported, comment.created_at FROM comment INNER JOIN user ON comment.user_id = user.id WHERE article_id = ? AND comment.is_reported IN(?, ?) ORDER BY comment.created_at DESC';
        $result = $this->createQuery($sql, [$articleId, 0, 2]);
        $comments = [];
        foreach ($result as $row) {
            array_push($comments, $this->buildObject($row));
        }
        $result->closeCursor();
        return $comments;
    }

    public function addComment(Session $session, Parameter $post, $articleId)
    {
        $sql = 'INSERT INTO comment(user_id, content, is_reported, article_id, created_at) VALUES(?, ?, ?, ?, NOW())';
        $this->createQuery($sql, [
            $session->get('id'),
            $post->get('content'),
            0,
            $articleId,
        ]);
    }

    public function getReportedComments()
    {
        $sql = 'SELECT comment.id, user.username, comment.content, comment.created_at FROM comment INNER JOIN user ON comment.user_id = user.id WHERE comment.is_reported = ?';
        $result = $this->createQuery($sql, ['1']);
        $comments = [];
        foreach ($result as $row) {
            array_push($comments, $this->buildObject($row));
        }
        $result->closeCursor();
        return $comments;
    }

    public function reportComment($commentId)
    {
        $sql = 'UPDATE comment SET is_reported = ? WHERE id = ?';
        $this->createQuery($sql, [1, $commentId]);
    }

    public function isAlreadyReported($commentId)
    {
        $sql = 'SELECT is_reported FROM comment WHERE id = ?';
        $result = $this->createQuery($sql, [$commentId]);
        $isReported = $result->fetchColumn();
        return $isReported === '1' || $isReported === '2' ? true : false;
    }

    public function pardonComment($commentId)
    {
        $sql = 'UPDATE comment SET is_reported = ? WHERE id = ?';
        $this->createQuery($sql, [2, $commentId]);
    }

    public function deleteComment($commentId)
    {
        $sql = 'DELETE FROM comment WHERE id = ?';
        $this->createQuery($sql, [$commentId]);
    }
}
