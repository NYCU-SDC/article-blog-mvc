<?php
namespace Models;

class Article {
    private $id;
    private $title;
    private $content;
    private $created_at;
    private $updated_at;

    public function setId($id) {
        $this->$id = $id;
    }

    public function setTitle($title) {
        $this->$title = $title;
    }

    public function setContent($content) {
        $this->$content = $content;
    }

    public function setCreatedAt($created_at) {
        $this->$created_at = $created_at;
    }

    public function setUpdatedAt($updated_at) {
        $this->$updated_at = $updated_at;
    }

    public function getId() {
        return $this->$id;
    }

    public function getTitle() {
        return $this->$title;
    }

    public function getContent() {
        return $this->$content;
    }

    public function getCreatedAt() {
        return $this->$created_at;
    }

    public function getUpdatedAt() {
        return $this->$updated_at;
    }

    public function isValid() {
        return !empty($this->title) && !empty($this->content);
    }
}