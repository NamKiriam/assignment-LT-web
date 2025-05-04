<?php
session_start();
require_once '../include/config.php';

header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

if (!isset($_SESSION['user_id'])) {
    $response['message'] = 'Vui lòng đăng nhập để gửi câu hỏi!';
    echo json_encode($response);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['question_text'])) {
    $content = trim($_POST['question_text']);
    $id_user = $_SESSION['user_id'];

    if (!empty($content)) {
        $stmt = $connection->prepare("INSERT INTO question (ID_user, Content) VALUES (?, ?)");
        $stmt->bind_param("is", $id_user, $content);

        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = 'Câu hỏi đã được gửi thành công!';
        } else {
            $response['message'] = 'Lỗi khi lưu câu hỏi vào database.';
        }
        $stmt->close();
    } else {
        $response['message'] = 'Câu hỏi không được để trống!';
    }
} else {
    $response['message'] = 'Yêu cầu không hợp lệ!';
}

echo json_encode($response);
$connection->close();
?>