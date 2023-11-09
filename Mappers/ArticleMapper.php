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
     * @return Article|null
     */
    public function getArticleById($id) {
        $stmt = $this->pdo->prepare('SELECT * FROM articles WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $articleFetch = $stmt->fetch();
        if($articleFetch) {
            $article = Article::create()
                        ->setId($articleFetch['id'])
                        ->setTitle($articleFetch['title'])
                        ->setContent($articleFetch['content'])
                        ->setCreatedAt($articleFetch['created_at'])
                        ->setUpdatedAt($articleFetch['updated_at']);
            return $article;
        }
        return null;
    }
    
    /**
     * @return array
     */
    public function getArticles() {
        $articles = array();
        $stmt = $this->pdo->prepare('SELECT * FROM articles');
        $stmt->execute();
        $articlesFetch = $stmt->fetchAll();
        foreach ($articlesFetch as $articleFetch) {
            $article = Article::create()
                        ->setId($articleFetch['id'])
                        ->setTitle($articleFetch['title'])
                        ->setContent($articleFetch['content'])
                        ->setCreatedAt($articleFetch['created_at'])
                        ->setUpdatedAt($articleFetch['updated_at']);
            $articles[] = $article;
        }
        return $articles;
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