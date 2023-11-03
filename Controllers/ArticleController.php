<?php
namespace Controllers;

use Models\Article;
use Mappers\ArticleMapper;

class ArticleController {
    private $articleMapper;

    /**
     * ArticleController constructor.
     * @param $articleMapper
     * @internal param $articleMapper
     */
    public function __construct(ArticleMapper $articleMapper) {
        $this->articleMapper = $articleMapper;
    }

    /**
     * @return json string
     */
    public function index() {
        $articlesArray = array();
        $articles = $this->articleMapper->getArticles();
        header('Content-Type: application/json');
        foreach ($articles as $article) {
            $articlesArray[] = $article->toArray();
        }
        return json_encode($articlesArray);
    }

    /**
     * @param $id
     * @return json string
     */
    public function show($id) {
        $article = $this->articleMapper->getArticleById($id);
        header('Content-Type: application/json');
        if ($article) {
            return $article->toJson();
        } else {
            http_response_code(404);
            return json_encode(["error" => "Article not found"]);
        }
    }

    /**
     * @return json string
     */
    public function create($postData) {
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $article = new Article();
            $article->setTitle($postData['title']);
            $article->setContent($postData['content']);

            if ($article->isValid()) {
                $this->articleMapper->createArticle($article);
                http_response_code(201); // Created
                return $article->toJson();
            } else {
                http_response_code(400); // Bad request
                return json_encode(["error" => "Please ensure both title and content are filled out."]);
            }
        } else {
            http_response_code(405); // Method not allowed
            return json_encode(["error" => "Method not allowed"]);
        }
    }

    /**
     * @param $id
     * @return json string
     */
    public function update($id, $postData) {
        header('Content-Type: application/json');
        $article = $this->articleMapper->getArticleById($id);

        if (!$article) {
            http_response_code(404); // Not found
            return json_encode(["error" => "Article not found"]);
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $article->setTitle($postData['title']);
            $article->setContent($postData['content']);

            if ($article->isValid()) {
                $this->articleMapper->updateArticle($article);
                return $article->toJson();
            } else {
                http_response_code(400); // Bad request
                return json_encode(["error" => "Please ensure both title and content are filled out."]);
            }
        } else {
            http_response_code(405); // Method not allowed
            return json_encode(["error" => "Method not allowed"]);
        }
    }

    /**
     * @param $id
     * @return json string
     */
    public function delete($id) {
        header('Content-Type: application/json');
        $article = $this->articleMapper->getArticleById($id);

        if (!$article) {
            http_response_code(404); // Not Found
            return json_encode(["error" => "Article not found"]);
        }

        $this->articleMapper->deleteArticle($id);
        http_response_code(204); // No content
        return json_encode(["message" => "Article deleted successfully"]);
    }
}