<?php
session_start();
require_once '../../include/config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../auth/login.php");
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    foreach ($_POST as $section => $content) {
        if ($section === "save") continue;
        $stmt = $connection->prepare("UPDATE site_content SET content = ? WHERE page = 'home' AND section = ?");
        $stmt->bind_param("ss", $content, $section);
        $stmt->execute();
        $stmt->close();
    }
    $message = "Cập nhật thành công!";
}

$content = [];
$result = $connection->query("SELECT section, content FROM site_content WHERE page = 'home'");
while ($row = $result->fetch_assoc()) {
    $content[$row['section']] = $row['content'];
}
$connection->close();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Quản lý nội dung trang chủ</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.js"></script>
  <script src="home.js"></script>
</head>
<body class="bg-light">

<div class="container py-4">
  <h2 class="mb-4">Quản lý nội dung trang chủ</h2>

  <?php if (!empty($message)): ?>
    <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
  <?php endif; ?>

  <form method="POST">
    <?php foreach ($content as $section => $value): ?>
      <div class="mb-4">
        <label class="form-label fw-semibold text-primary"><?= htmlspecialchars($section) ?></label>
        <textarea name="<?= htmlspecialchars($section) ?>" class="form-control summernote"><?= htmlspecialchars($value) ?></textarea>
        <div class="form-text text-danger">
          Không xóa các class như <code>col-md-4</code>, <code>step-circle</code>,... để tránh vỡ layout.
        </div>
      </div>
    <?php endforeach; ?>

    <button type="submit" name="save" class="btn btn-success">Lưu thay đổi</button>
    <button type="button" id="previewBtn" class="btn btn-secondary ms-2">Xem trước</button>
  </form>

  <div class="mt-5">
    <h4>Xem trước nội dung:</h4>
    <div id="previewArea" class="p-3 border bg-white"></div>
  </div>
</div>

</body>
</html>
