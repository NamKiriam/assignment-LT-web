<?php
session_start();
require_once '../include/config.php';

header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

if (!isset($_SESSION['user_id'])) {
    $response['message'] = 'Vui lòng đăng nhập để xóa câu hỏi!';
    echo json_encode($response);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $question_id = intval($_GET['id']);
    $id_user = $_SESSION['user_id'];

    if ($question_id > 0) {
        // Kiểm tra xem câu hỏi có thuộc về người dùng không
        $stmt = $connection->prepare("SELECT ID_user FROM question WHERE ID_question = ?");
        $stmt->bind_param("i", $question_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            if ($row['ID_user'] !== $id_user) {
                $response['message'] = 'Bạn không có quyền xóa câu hỏi này!';
                echo json_encode($response);
                exit();
            }

            // Xóa câu hỏi
            $stmt = $connection->prepare("DELETE FROM question WHERE ID_question = ?");
            $stmt->bind_param("i", $question_id);

            if ($stmt->execute()) {
                $response['success'] = true;
                $response['message'] = 'Câu hỏi đã được xóa thành công!';
            } else {
                $response['message'] = 'Lỗi khi xóa câu hỏi.';
            }
        } else {
            $response['message'] = 'Câu hỏi không tồn tại.';
        }
        $stmt->close();
    } else {
        $response['message'] = 'ID câu hỏi không hợp lệ!';
    }
} else {
    $response['message'] = 'Yêu cầu không hợp lệ!';
}

echo json_encode($response);
$connection->close();
?>