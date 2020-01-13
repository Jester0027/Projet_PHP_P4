<?php

namespace BlogApp\src\model;

use BlogApp\src\helpers\Date;

class Comment
{
    private $id;
    private $author;
    private $content;
    private $isReported;
    private $articleId;
    private $createdAt;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function setAuthor($author)
    {
        $this->author = $author;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getIsReported()
    {
        return $this->isReported;
    }

    public function setIsReported($isReported)
    {
        $this->isReported = $isReported;
    }

    public function getArticleId()
    {
        return $this->articleId;
    }

    public function setArticleId($articleId)
    {
        $this->articleId = $articleId;
    }

    public function getCreatedAt()
    {
        return Date::formatDateTimeFR($this->createdAt);
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }
}
