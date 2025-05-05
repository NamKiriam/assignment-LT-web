<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

// Kết nối CSDL thông qua file riêng
require_once '../../../Trang_bai_viet/db.php';

// Route
$method = $_SERVER['REQUEST_METHOD'];
$path = isset($_GET['path']) ? explode('/', trim($_GET['path'], '/')) : [];

if ($path[0] === 'articles') {
    switch ($method) {
        case 'GET':
            if (isset($path[1])) {
                // Lấy 1 bài viết theo ID
                $id = $path[1];
                $sql = "SELECT id, title, content, `like`, dislike FROM article WHERE id = ?";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "s", $id);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $article = mysqli_fetch_assoc($result);
                if ($article) {
                    echo json_encode($article);
                } else {
                    http_response_code(404);
                    echo json_encode(["error" => "Article not found"]);
                }
                mysqli_stmt_close($stmt);
            } else {
                // Lấy danh sách tất cả bài viết
                $sql = "SELECT id, title, author, update_date FROM article ORDER BY update_date DESC";
                $result = mysqli_query($conn, $sql);
                $articles = [];
                while ($row = mysqli_fetch_assoc($result)) {
                    $articles[] = $row;
                }
                echo json_encode($articles);
            }
            break;
        

        case 'POST':
            // Tạo mới bài viết
            $data = json_decode(file_get_contents("php://input"), true);
            $errors = validateArticle($data, ['title', 'author', 'content']);
            if (empty($errors)) {
                $id = 'A' . date("YmdHis");
                $sql = "INSERT INTO article (id, title, author, update_date, content) VALUES (?, ?, ?, NOW(), ?)";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "ssss", $id, $data['title'], $data['author'], $data['content']);
                if (mysqli_stmt_execute($stmt)) {
                    http_response_code(201);
                    echo json_encode(["message" => "Article created successfully"]);
                } else {
                    http_response_code(500);
                    echo json_encode(["error" => "Failed to create article"]);
                }
                mysqli_stmt_close($stmt);
            } else {
                http_response_code(400);
                echo json_encode(["errors" => $errors]);
            }
            break;

        case 'PUT':
            // Chỉnh sửa title và author
            if (isset($path[1])) {
                $id = $path[1];
                $data = json_decode(file_get_contents("php://input"), true);
                $errors = validateArticle($data, ['title', 'author']);
                if (empty($errors)) {
                    $sql = "UPDATE article SET title = ?, author = ?, update_date = NOW() WHERE id = ?";
                    $stmt = mysqli_prepare($conn, $sql);
                    mysqli_stmt_bind_param($stmt, "sss", $data['title'], $data['author'], $id);
                    if (mysqli_stmt_execute($stmt)) {
                        echo json_encode(["message" => "Article updated successfully"]);
                    } else {
                        http_response_code(500);
                        echo json_encode(["error" => "Failed to update article"]);
                    }
                    mysqli_stmt_close($stmt);
                } else {
                    http_response_code(400);
                    echo json_encode(["errors" => $errors]);
                }
            } else {
                http_response_code(400);
                echo json_encode(["error" => "Article ID required"]);
            }
            break;

        case 'DELETE':
            // Xóa bài viết
            if (isset($path[1])) {
                $id = $path[1];
                $sql = "DELETE FROM article WHERE id = ?";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "s", $id);
                if (mysqli_stmt_execute($stmt)) {
                    echo json_encode(["message" => "Article deleted successfully"]);
                } else {
                    http_response_code(500);
                    echo json_encode(["error" => "Failed to delete article"]);
                }
                mysqli_stmt_close($stmt);
            } else {
                http_response_code(400);
                echo json_encode(["error" => "Article ID required"]);
            }
            break;

        default:
            http_response_code(405);
            echo json_encode(["error" => "Method not allowed"]);
    }
} else {
    http_response_code(404);
    echo json_encode(["error" => "Endpoint not found"]);
}

mysqli_close($conn);

// Hàm kiểm tra dữ liệu
function validateArticle($data, $fields) {
    $errors = [];
    foreach ($fields as $field) {
        if (!isset($data[$field]) || trim($data[$field]) === '') {
            $errors[] = "$field is required";
        }
    }
    return $errors;
}
?>
