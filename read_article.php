<?php
// Import connection file
require_once('connection.php');

// Get id from JS file
$article_id = $_REQUEST['id'];

// Execute SQL command with PDO
$sql = "select * from articles where id=".$article_id.";";
try {
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    // set the resulting array to associative
    $result = $stmt->fetchAll(PDO::FETCH_CLASS);

    echo json_encode($result);
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
    die($e->getMessage());
}
?>
