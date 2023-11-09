<?php
namespace Models;

class Article {
    private $id;
    private $title;
    private $content;
    private $created_at;
    private $updated_at;

    /**
     * Constructor
     */
    public function __construct() {
        // Do nothing
    }

    /**
     * Static constructor / factory
     * @return Article
     */
    public static function create() {
        return new static();
    }

    /**
     * @param $id
     * @return Article
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * @param $title
     * @return Article
     */
    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    /**
     * @param $content
     * @return Article
     */
    public function setContent($content) {
        $this->content = $content;
        return $this;
    }

    /**
     * @param $created_at
     * @return Article
     */
    public function setCreatedAt($created_at) {
        $this->created_at = $created_at;
        return $this;
    }

    /**
     * @param $updated_at
     * @return Article
     */
    public function setUpdatedAt($updated_at) {
        $this->updated_at = $updated_at;
        return $this;
    }

    public function getId() {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getContent() {
        return $this->content;
    }

    public function getCreatedAt() {
        return $this->created_at;
    }

    public function getUpdatedAt() {
        return $this->updated_at;
    }

    public function isValid() {
        return !empty($this->title) && !empty($this->content);
    }

    /**
     * @return array
     */
    public function toArray() {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}