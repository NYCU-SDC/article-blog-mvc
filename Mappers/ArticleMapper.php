<?php
namespace Mappers;

require_once 'Models/Article.php';

use PDO;
use PDOException;
use Models\Article;

class ArticleMapper {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getArticleById($id) {
        $stmt = $this->pdo->prepare('SELECT * FROM articles WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $article = $stmt->fetch();
        if($article) {
            $articleModel = new Article();
            $articleModel->setId($article['id']);
            $articleModel->setTitle($article['title']);
            $articleModel->setContent($article['content']);
            $articleModel->setCreatedAt($article['created_at']);
            $articleModel->setUpdatedAt($article['updated_at']);
            return $articleModel;
        }
        return null;
    }

    public function getArticles() {
        $stmt = $this->pdo->prepare('SELECT * FROM articles');
        $stmt->execute();
        $articles = $stmt->fetchAll();
        $articleModels = [];
        foreach ($articles as $article) {
            $articleModel = new Article();
            $articleModel->setId($article['id']);
            $articleModel->setTitle($article['title']);
            $articleModel->setContent($article['content']);
            $articleModel->setCreatedAt($article['created_at']);
            $articleModel->setUpdatedAt($article['updated_at']);
            $articleModels[] = $articleModel;
        }
        return $articleModels;
    }

    public function createArticle(Article $article) {
        $stmt = $this->pdo->prepare('INSERT INTO articles (title, content) VALUES (:title, :content)');
        $stmt->execute([
            'title' => $article->getTitle(),
            'content' => $article->getContent()
        ]);
    }

    public function updateArticle(Article $article) {
        $stmt = $this->pdo->prepare('UPDATE articles SET title = :title, content = :content WHERE id = :id');
        $stmt->execute([
            'title' => $article->getTitle(),
            'content' => $article->getContent(),
            'id' => $article->getId()
        ]);
    }

    public function deleteArticle($id) {
        $stmt = $this->pdo->prepare('DELETE FROM articles WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }
}