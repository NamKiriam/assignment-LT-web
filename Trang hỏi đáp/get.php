<?php
header('Content-Type: application/json');
$conn = new mysqli("localhost", "username", "password", "meal_order");
if ($conn->connect_error) {
    echo json_encode([]);
    exit;
}

$sql = "SELECT q.ID_question, q.question, q.answer, q.Date_create, COALESCE(u.Name, q.name) as name 
        FROM question q 
        LEFT JOIN user u ON q.ID_user = u.ID_user 
        ORDER BY q.Date_create DESC";
$result = $conn->query($sql);
$faqs = [];
while ($row = $result->fetch_assoc()) {
    $faqs[] = $row;
}
$conn->close();
echo json_encode($faqs);
?>