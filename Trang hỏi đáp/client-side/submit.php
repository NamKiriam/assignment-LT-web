<?php
header('Content-Type: application/json');
$conn = new mysqli("localhost", "username", "password", "meal_order");
if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Kết nối CSDL thất bại']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$question = htmlspecialchars($data['question'] ?? '');
$name = htmlspecialchars($data['name'] ?? 'Khách');

if (strlen($question) < 10) {
    echo json_encode(['status' => 'error', 'message' => 'Câu hỏi phải có ít nhất 10 ký tự']);
    exit;
}

$sql = "INSERT INTO question (question, Date_create, name) VALUES (?, CURDATE(), ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $question, $name);
if ($stmt->execute()) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Lỗi khi lưu câu hỏi']);
}
$stmt->close();
$conn->close();
?>