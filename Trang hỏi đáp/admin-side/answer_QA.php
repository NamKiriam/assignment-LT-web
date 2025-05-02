<?php
header('Content-Type: application/json');
include '../Trang hỏi đáp/connect.php'; // File kết nối MySQL

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $answer = isset($_POST['answer']) ? trim($_POST['answer']) : '';

    if ($id > 0 && $answer) {
        $sql = "UPDATE question SET answer = ? WHERE ID_question = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('si', $answer, $id);
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Lỗi khi cập nhật câu trả lời']);
        }
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Dữ liệu không hợp lệ']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Yêu cầu không hợp lệ']);
}

$conn->close();
?>