<?php
namespace Mappers;

require_once 'Models/Article.php';

use PDO;
use PDOException;
use Models\Article;

class ArticleMapper {
    /**
     * @var PDO
     */
    private $pdo;

    /**
     * ArticleMapper constructor.
     * @param $pdo
     */
    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    /**
     * @param $id
     * @return null|json string
     */
    public function getArticleById($id) {
        $stmt = $this->pdo->prepare('SELECT * FROM articles WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $article = $stmt->fetch();
        if($article) {
            return json_encode($article);
        }
        return null;
    }
    
    /**
     * @return json string
     */
    public function getArticles() {
        $stmt = $this->pdo->prepare('SELECT * FROM articles');
        $stmt->execute();
        $articles = $stmt->fetchAll();
        return json_encode($articles);
    }

    /**
     * @param Article $article
     */
    public function createArticle(Article $article) {
        $stmt = $this->pdo->prepare('INSERT INTO articles (title, content) VALUES (:title, :content)');
        $stmt->execute([
            'title' => $article->getTitle(),
            'content' => $article->getContent()
        ]);
    }

    /**
     * @param Article $article
     */
    public function updateArticle(Article $article) {
        $stmt = $this->pdo->prepare('UPDATE articles SET title = :title, content = :content WHERE id = :id');
        $stmt->execute([
            'title' => $article->getTitle(),
            'content' => $article->getContent(),
            'id' => $article->getId()
        ]);
    }

    /**
     * @param $id
     */
    public function deleteArticle($id) {
        $stmt = $this->pdo->prepare('DELETE FROM articles WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }
}