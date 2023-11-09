<?php
require_once 'Models/Database.php';
require_once 'Models/ArticleManipulator.php';
require_once 'Controllers/ArticleController.php';

use Models\Database;
use Models\ArticleManipulator;
use Controllers\ArticleController;

// Inintialize the database connection
$pdo = (new Database('localhost', 'kwei', 'kwei', 'kwei'))->getPdo();
$articleController = new ArticleController(new ArticleManipulator($pdo));
$postData = $_POST;

function handleRequest($requestUri, $requestMethod, $articleController, $postData) {
    if ($requestMethod == 'GET' && $requestUri == '/') {
        $htmlContent = file_get_contents('article_list.html');
        return $htmlContent;
    } else if($requestMethod == 'GET' && $requestUri == '/article') {
        return $articleController->index();
    } else if ($requestMethod == 'GET' && preg_match('/^\/article\/(\d+)$/', $requestUri, $matches)) {
        return $articleController->show($matches[1]);
    } elseif ($requestMethod == 'POST' && $requestUri == '/article/create') {
        return $articleController->create($postData);
    } elseif ($requestMethod == 'POST' && preg_match('/^\/article\/(\d+)\/update$/', $requestUri, $matches)) {
        return $articleController->update($matches[1], $postData);
    } elseif ($requestMethod == 'DELETE' && preg_match('/^\/article\/(\d+)\/delete$/', $requestUri, $matches)) {
        return $articleController->delete($matches[1]);
    } else {
        // if there is no matching route, return 404
        http_response_code(404);
        return json_encode(["error" => "Page not found"]);
    }
}

?>