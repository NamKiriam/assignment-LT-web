<?php
session_start();
require_once '../include/config.php';

header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

if (!isset($_SESSION['user_id'])) {
    $response['message'] = 'Vui lòng đăng nhập để chỉnh sửa câu hỏi!';
    echo json_encode($response);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['question_id']) && isset($_POST['question_text'])) {
    $question_id = intval($_POST['question_id']);
    $content = trim($_POST['question_text']);
    $id_user = $_SESSION['user_id'];

    if (!empty($content) && $question_id > 0) {
        // Kiểm tra xem câu hỏi có thuộc về người dùng không
        $stmt = $connection->prepare("SELECT ID_user FROM question WHERE ID_question = ?");
        $stmt->bind_param("i", $question_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            if ($row['ID_user'] !== $id_user) {
                $response['message'] = 'Bạn không có quyền chỉnh sửa câu hỏi này!';
                echo json_encode($response);
                exit();
            }

            // Cập nhật câu hỏi
            $stmt = $connection->prepare("UPDATE question SET Content = ? WHERE ID_question = ?");
            $stmt->bind_param("si", $content, $question_id);

            if ($stmt->execute()) {
                $response['success'] = true;
                $response['message'] = 'Câu hỏi đã được cập nhật thành công!';
            } else {
                $response['message'] = 'Lỗi khi cập nhật câu hỏi.';
            }
        } else {
            $response['message'] = 'Câu hỏi không tồn tại.';
        }
        $stmt->close();
    } else {
        $response['message'] = 'Dữ liệu không hợp lệ!';
    }
} else {
    $response['message'] = 'Yêu cầu không hợp lệ!';
}

echo json_encode($response);
$connection->close();
?>