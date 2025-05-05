<?php
session_start();
require_once '../../include/config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../auth/login.php");
    exit();
}

$sections = ['hero_title', 'hero_intro', 'hero_button', 'why_title', 'why_text', 'why_items', 'steps_title', 'steps_list', 'testimonial'];

$stmt = $connection->prepare("
    INSERT INTO site_content (page, section, content)
    VALUES ('home', ?, ?)
    ON DUPLICATE KEY UPDATE content = VALUES(content), updated_at = CURRENT_TIMESTAMP
");

foreach ($sections as $section) {
    $value = $_POST[$section] ?? '';
    $stmt->bind_param("ss", $section, $value);
    $stmt->execute();
}

$stmt->close();
$connection->close();

header("Location: manage_home.php");
exit();
