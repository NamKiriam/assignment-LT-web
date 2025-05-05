<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../db.php';

$method = $_SERVER['REQUEST_METHOD'];
$path = isset($_GET['path']) ? explode('/', trim($_GET['path'], '/')) : [];

if ($method === 'POST' && $path[0] === 'articles' && isset($path[1]) && in_array($path[2], ['like', 'dislike'])) {
    $articleId = $path[1];
    $action = $path[2];

    // Cột trong CSDL tên là 'like' hoặc 'dislike'
    $column = $action === 'like' ? '`like`' : '`dislike`'; // Gói trong backtick để tránh từ khóa SQL

    $sql = "UPDATE article SET $column = $column + 1 WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $articleId);

    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(["message" => ucfirst($action) . " count increased"]);
    } else {
        http_response_code(500);
        echo json_encode(["error" => "Database update failed"]);
    }

    mysqli_stmt_close($stmt);
} else {
    http_response_code(400);
    echo json_encode(["error" => "Invalid request"]);
}

mysqli_close($conn);
?>
