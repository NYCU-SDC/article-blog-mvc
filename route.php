<?php
require_once 'Mappers/Database.php';
require_once 'Mappers/ArticleMapper.php';
require_once 'Controllers/ArticleController.php';

use Mappers\ArticleMapper;
use Mappers\Database;
use Controllers\View;
use Controllers\ArticleController;

// Inintialize the database connection
$pdo = (new Database('localhost', 'kwei', 'kwei', 'kwei'))->getPdo();
$articleMapper = new ArticleMapper($pdo);
$articleController = new ArticleController($articleMapper);

function handleRequest($requestUri, $requestMethod, $articleController) {
    if ($requestMethod == 'GET' && $requestUri == '/') {
        return $articleController->index();
    } else if ($requestMethod == 'GET' && preg_match('/^\/article\/(\d+)$/', $requestUri, $matches)) {
        return $articleController->show($matches[1]);
    }
    // Other routes with "else if"

    // if there is no matching route, return 404
    http_response_code(404);
    return json_encode(["error" => "Page not found"]);
}

?>