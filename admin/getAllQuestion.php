<?php
require_once '../include/config.php';
header('Content-Type: application/json');

$response = ['success' => false, 'questions' => []];

$stmt = $connection->prepare("SELECT q.ID_question, q.Content, q.Created_at, q.answered, q.answer, u.username
                              FROM question q
                              JOIN user u ON q.ID_user = u.ID_user
                              ORDER BY q.Created_at DESC");

if ($stmt->execute()) {
    $result = $stmt->get_result();
    $questions = [];

    while ($row = $result->fetch_assoc()) {
        $questions[] = [
            'id' => $row['ID_question'],
            'name' => $row['username'],
            'text' => $row['Content'],
            'date' => date('M d, H:i', strtotime($row['Created_at'])),
            'answered' => (bool)$row['answered'],
            'answer' => $row['answer']
        ];
    }

    $response['success'] = true;
    $response['questions'] = $questions;
}

$stmt->close();
$connection->close();

echo json_encode($response);
?>
