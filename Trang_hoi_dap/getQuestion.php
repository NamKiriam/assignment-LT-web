<?php
session_start();
require_once '../include/config.php';

header('Content-Type: application/json');

$response = ['success' => false, 'questions' => []];

if (isset($_SESSION['user_id'])) {
    $id_user = $_SESSION['user_id'];
    $stmt = $connection->prepare("SELECT ID_question, Content, Created_at, answered, answer FROM question WHERE ID_user = ? ORDER BY Created_at DESC");
    $stmt->bind_param("i", $id_user);
    $stmt->execute();
    $result = $stmt->get_result();

    $questions = [];
    while ($row = $result->fetch_assoc()) {
        $questions[] = [
            'id' => $row['ID_question'],
            'name' => $_SESSION['user_name'],
            'text' => $row['Content'],
            'date' => date('M d, H:i', strtotime($row['Created_at'])), // Định dạng: "Apr 09, 14:51"
            'answered' => (bool)$row['answered'], // Chuyển thành boolean
            'answer' => $row['answer'] // Câu trả lời (nếu có)
        ];
    }
    $response['success'] = true;
    $response['questions'] = $questions;
    $stmt->close();
} else {
    $response['message'] = 'Vui lòng đăng nhập để xem câu hỏi!';
}

echo json_encode($response);
$connection->close();
?>