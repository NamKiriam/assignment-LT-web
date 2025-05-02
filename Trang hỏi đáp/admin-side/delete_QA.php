<?php
header('Content-Type: application/json');
include '../Trang hỏi đáp/connect.php'; // File kết nối MySQL

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;

    if ($id > 0) {
        $sql = "DELETE FROM question WHERE ID_question = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $id);
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Lỗi khi xóa câu hỏi']);
        }
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'ID không hợp lệ']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Yêu cầu không hợp lệ']);
}

$conn->close();
?>