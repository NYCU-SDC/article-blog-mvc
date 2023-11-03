<?php
namespace Controllers;

use Models\Article;
use Mappers\ArticleMapper;

class ArticleController {
    private $articleMapper;
    private $view;

    public function __construct(ArticleMapper $articleMapper) {
        $this->articleMapper = $articleMapper;
    }

    public function index() {
        $articles = $this->articleMapper->getArticles();
        header('Content-Type: application/json');
        return json_encode($articles);
    }

    public function show($id) {
        $article = $this->articleMapper->findById($id);
        header('Content-Type: application/json');
        if ($article) {
            return json_encode($article);
        } else {
            http_response_code(404);
            return json_encode(["error" => "Article not found"]);
        }
    }

    public function create() {
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $article = new Article();
            $article->setTitle($_POST['title']);
            $article->setContent($_POST['content']);

            if ($article->isValid()) {
                $this->articleMapper->createArticle($article);
                http_response_code(201); // Created
                return json_encode($article);
            } else {
                http_response_code(400); // Bad request
                return json_encode(["error" => "Please ensure both title and content are filled out."]);
            }
        } else {
            http_response_code(405); // Method not allowed
            return json_encode(["error" => "Method not allowed"]);
        }
    }

    public function update($id) {
        header('Content-Type: application/json');
        $article = $this->articleMapper->getArticleById($id);

        if (!$article) {
            http_response_code(404); // Not found
            return json_encode(["error" => "Article not found"]);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $article->setTitle($_POST['title']);
            $article->setContent($_POST['content']);

            if ($article->isValid()) {
                $this->articleMapper->updateArticle($article);
                return json_encode($article);
            } else {
                http_response_code(400); // Bad request
                return json_encode(["error" => "Please ensure both title and content are filled out."]);
            }
        } else {
            http_response_code(405); // Method not allowed
            return json_encode(["error" => "Method not allowed"]);
        }
    }

    public function delete($id) {
        header('Content-Type: application/json');
        $article = $this->articleMapper->getArticleById($id);

        if (!$article) {
            http_response_code(404); // Not Found
            return json_encode(["error" => "Article not found"]);
        }

        $this->articleMapper->deleteArticle($article);
        http_response_code(204); // No content
        return json_encode(["message" => "Article deleted successfully"]);
    }
}