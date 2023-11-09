<?php
namespace Models;

// Files that we will need
require_once 'Models/ArticleData.php';

// Namespaces that we will need
use PDO;
use PDOException;
use Models\ArticleData;

class ArticleManipulator {
    /**
     * @var PDO
     */
    private $pdo;
    private ArticleData $articleData;

    /**
     * ArticleManipulator constructor.
     * @param $pdo
     */
    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Static constructor / factory
     * @param $pdo
     * @return ArticleManipulator
     */
    public static function create(PDO $pdo) {
        return new static($pdo);
    }

    /**
     * @return array
     */
    public function all() {
        $articles = array();
        $stmt = $this->pdo->prepare('SELECT * FROM articles');
        $stmt->execute();
        $articlesFetch = $stmt->fetchAll();
        foreach ($articlesFetch as $articleFetch) {
            $article = [
                'id' => $articleFetch['id'],
                'title' => $articleFetch['title'],
                'content' => $articleFetch['content'],
                'created_at' => $articleFetch['created_at'],
                'updated_at' => $articleFetch['updated_at']
            ];
            $articles[] = $article;
        }
        return $articles;
    }

    /**
     * @param $id
     * @return Article|null
     */
    public function whereId($id) {
        $stmt = $this->pdo->prepare('SELECT * FROM articles WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $articleFetch = $stmt->fetch();
        if($articleFetch) {
            $this->articleData = ArticleData::create()
                                ->setId($articleFetch['id'])
                                ->setTitle($articleFetch['title'])
                                ->setContent($articleFetch['content'])
                                ->setCreatedAt($articleFetch['created_at'])
                                ->setUpdatedAt($articleFetch['updated_at']);
        } else {
            $this->articleData = NULL;
        }
        return $this;
    }

    /**
     * @param Article $article
     */
    public function createArticle($articleArray) {
        $this->articleData = ArticleData::create()
                                ->setTitle($articleArray['title'])
                                ->setContent($articleArray['content']);

        $stmt = $this->pdo->prepare('INSERT INTO articles (title, content) VALUES (:title, :content)');
        $stmt->execute([
            'title' => $this->articleData->getTitle(),
            'content' => $this->articleData->getContent()
        ]);
        return $this;
    }

    /**
     * @param Article $article
     */
    public function updateArticle($articleArray) {
        $this->articleData = ArticleData::create()
                                ->setId($articleArray['id'])
                                ->setTitle($articleArray['title'])
                                ->setContent($articleArray['content']);

        $stmt = $this->pdo->prepare('UPDATE articles SET title = :title, content = :content WHERE id = :id');
        $stmt->execute([
            'title' => $this->articleData->getTitle(),
            'content' => $this->articleData->getContent(),
            'id' => $this->articleData->getId()
        ]);
        return $this;
    }

    /**
     * @param $id
     */
    public function deleteArticle($id) {
        $stmt = $this->pdo->prepare('DELETE FROM articles WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return NULL;
    }

    /**
     * @return ArticleData
     */
    public function getArticleData() {
        return $this->articleData;
    }

    /**
     * @param ArticleData $articleData
     * @return ArticleManipulator
     */
    public function setArticleData(ArticleData $articleData) {
        $this->articleData = $articleData;
        return $this;
    }

    /**
     * @return array
     */
    public function toArray() {
        return [
            'id' => $this->articleData->getId(),
            'title' => $this->articleData->getTitle(),
            'content' => $this->articleData->getContent(),
            'created_at' => $this->articleData->getCreatedAt(),
            'updated_at' => $this->articleData->getUpdatedAt()
        ];
    }

    public function validate($articleArray) {
        if (empty($articleArray['title'])) {
            return false;
        }
        if (empty($articleArray['content'])) {
            return false;
        }
        return true;
    }

    public function articleDataValid() {
        if(empty($this->articleData)) {
            return false;
        }
        return true;
    }
}