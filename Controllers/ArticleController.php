<?php
namespace Controllers;

use Models\ArticleManipulator;

class ArticleController {
    private $articleManipulatorarticleManipulator;

    /**
     * ArticleController constructor.
     * @param $articleManipulator
     * @internal param $articleManipulator
     */
    public function __construct(ArticleManipulator $articleManipulator) {
        $this->articleManipulator = $articleManipulator;
    }

    /**
     * @return json string
     */
    public function index() {
        $articles = $this->articleManipulator->all();
        header('Content-Type: application/json');
        return json_encode($articles);
    }

    /**
     * @param $id
     * @return json string
     */
    public function show($id) {
        $article = $this->articleManipulator->whereId($id);
        header('Content-Type: application/json');
        if ($article) {
            return json_encode($article->toArray());
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
            if ($this->articleManipulator->validate($postData)) {
                $article = $this->articleManipulator->createArticle($postData);
                http_response_code(201); // Created
                return json_encode($article->toArray());
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
        $article = $this->articleManipulator->whereId($id);

        if (!$article->articleDataValid()) {
            http_response_code(404); // Not found
            return json_encode(["error" => "Article not found"]);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($article->validate($postData)) {
                $postData['id'] = $id;
                $this->articleManipulator->updateArticle($postData);
                return json_encode($article->toArray());
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
        $article = $this->articleManipulator->whereId($id);

        if (!$article->articleDataValid()) {
            http_response_code(404); // Not Found
            return json_encode(["error" => "Article not found"]);
        }

        $this->articleManipulator->deleteArticle($id);
        http_response_code(204); // No content
        return json_encode(["message" => "Article deleted successfully"]);
    }
}