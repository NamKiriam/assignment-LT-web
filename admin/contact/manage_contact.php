<?php
session_start();
require_once '../../include/config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../auth/login.php");
    exit();
}

// Xử lý cập nhật trạng thái
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['contact_ids']) && is_array($_POST['contact_ids'])) {
    $ids = $_POST['contact_ids'];
    $action = $_POST['action'] ?? '';

    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $types = str_repeat('i', count($ids));

    if ($action === 'delete') {
        $stmt = $connection->prepare("DELETE FROM contacts WHERE id IN ($placeholders)");
    } elseif (in_array($action, ['unread', 'read', 'replied'])) {
        $stmt = $connection->prepare("UPDATE contacts SET status = ? WHERE id IN ($placeholders)");
        $types = 's' . $types;
        array_unshift($ids, $action);
    }

    if ($stmt) {
        $stmt->bind_param($types, ...$ids);
        $stmt->execute();
        $stmt->close();
        $success = "Thao tác thành công.";
    }
}

// Lấy dữ liệu liên hệ
$result = $connection->query("
    SELECT c.id, u.Username, u.email, c.message, c.status, c.created_at
    FROM contacts c
    JOIN user u ON c.user_id = u.ID_user
    ORDER BY c.created_at DESC
");
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Quản lý liên hệ</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <style>
    body { background: #f8f9fa; }
    .badge-status { text-transform: capitalize; }
  </style>
</head>
<body>

<div class="container py-5">
  <h2 class="mb-4 fw-bold text-primary">Quản lý liên hệ từ khách hàng</h2>

  <?php if (!empty($success)): ?>
    <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
  <?php endif; ?>

  <form method="POST">
    <table class="table table-bordered bg-white shadow-sm align-middle">
      <thead class="table-light">
        <tr>
          <th><input type="checkbox" id="checkAll"></th>
          <th>#</th>
          <th>Họ tên</th>
          <th>Email</th>
          <th>Nội dung</th>
          <th>Thời gian</th>
          <th>Trạng thái</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result->num_rows > 0): $i = 1; ?>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr class="<?= $row['status'] === 'unread' ? 'table-warning' : '' ?>">
              <td><input type="checkbox" name="contact_ids[]" value="<?= $row['id'] ?>"></td>
              <td><?= $i++ ?></td>
              <td><?= htmlspecialchars($row['Username']) ?></td>
              <td><?= htmlspecialchars($row['email']) ?></td>
              <td><?= nl2br(htmlspecialchars($row['message'])) ?></td>
              <td><?= $row['created_at'] ?></td>
              <td>
                <span class="badge bg-<?= $row['status'] === 'unread' ? 'danger' : ($row['status'] === 'read' ? 'secondary' : 'success') ?> badge-status">
                  <?= $row['status'] ?>
                </span>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr><td colspan="7" class="text-center text-muted">Không có liên hệ nào.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>

    <div class="mt-3">
      <button type="submit" name="action" value="read" class="btn btn-outline-primary">Đánh dấu đã đọc</button>
      <button type="submit" name="action" value="unread" class="btn btn-outline-primary">Đánh dấu chưa đọc</button>
      <button type="submit" name="action" value="replied" class="btn btn-outline-success">Đánh dấu đã phản hồi</button>
      <button type="submit" name="action" value="delete" class="btn btn-outline-danger" onclick="return confirm('Xoá các liên hệ đã chọn?')">Xoá liên hệ</button>
    </div>
  </form>
</div>

<script>
  document.getElementById('checkAll').addEventListener('click', function () {
    const checkboxes = document.querySelectorAll('input[name="contact_ids[]"]');
    checkboxes.forEach(cb => cb.checked = this.checked);
  });
</script>

</body>
</html>
