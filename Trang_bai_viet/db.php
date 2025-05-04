<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "foodiness_db";

$conn = mysqli_connect($host, $username, $password, $database);
if (!$conn) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed"]);
    exit;
}
mysqli_set_charset($conn, "utf8");
?>
