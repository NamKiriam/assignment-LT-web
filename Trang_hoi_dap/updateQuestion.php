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
    $answer = trim($_POST['question_text']); // Sử dụng 'question_text' làm câu trả lời
    $id_user = $_SESSION['user_id'];
    $is_admin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin'; // Giả định role

    if (!empty($answer) && $question_id > 0) {
        // Kiểm tra câu hỏi tồn tại
        $stmt = $connection->prepare("SELECT ID_user, answered FROM question WHERE ID_question = ?");
        $stmt->bind_param("i", $question_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            if (!$is_admin && $row['ID_user'] !== $id_user) {
                $response['message'] = 'Bạn không có quyền chỉnh sửa câu hỏi này!';
                echo json_encode($response);
                exit();
            }

            // Cập nhật hoặc chỉnh sửa câu trả lời
            if ($row['answered']) {
                // Chinh sửa câu trả lời đã tồn tại
                $stmt = $connection->prepare("UPDATE question SET answer = ? WHERE ID_question = ?");
                $stmt->bind_param("si", $answer, $question_id);
                $action_message = 'Câu trả lời đã được chỉnh sửa thành công!';
            } else {
                // Trả lời mới
                $stmt = $connection->prepare("UPDATE question SET answer = ?, answered = 1 WHERE ID_question = ?");
                $stmt->bind_param("si", $answer, $question_id);
                $action_message = 'Câu trả lời đã được cập nhật thành công!';
            }

            if ($stmt->execute()) {
                $response['success'] = true;
                $response['message'] = $action_message;
            } else {
                $response['message'] = 'Lỗi khi cập nhật câu hỏi: ' . $stmt->error;
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