<?php
require_once '../include/config.php'; // Đảm bảo kết nối database

// Khởi tạo mảng câu hỏi
$questions = [];
$error = '';

try {
    // Truy vấn trực tiếp từ database, bỏ cột answered và answer
    $stmt = $connection->prepare("SELECT q.ID_question, q.Content, q.Created_at, u.Username
                                  FROM question q
                                  JOIN user u ON q.ID_user = u.ID_user
                                  ORDER BY q.Created_at DESC");

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $questions = [];

        while ($row = $result->fetch_assoc()) {
            $questions[] = [
                'id' => $row['ID_question'],
                'name' => $row['Username'],
                'text' => $row['Content'],
                'date' => date('M d, H:i', strtotime($row['Created_at']))
            ];
        }
    } else {
        $error = "Lỗi khi truy vấn dữ liệu: " . $stmt->error;
    }
    $stmt->close();
    $connection->close();
} catch (Exception $e) {
    $error = "Lỗi: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Quản lý Hỏi Đáp - Admin</title>

  <!-- Bootstrap & Icon -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">

  <style>
    td small {
      color: gray;
    }
  </style>

  <script>
    function deleteQuestion(id) {
      if (confirm("Bạn có chắc chắn muốn xóa câu hỏi này không?")) {
        fetch('../Trang_hoi_dap/deleteQuestion.php?id=' + id)
          .then(res => res.json())
          .then(data => {
            alert(data.message);
            if (data.success) location.reload();
          });
      }
    }
  </script>
</head>
<body>
  <div class="d-flex" id="wrapper">
    <!-- Sidebar -->
    <nav id="sidebar" class="sidebar bg-dark text-white position-fixed">
      <div class="sidebar-header text-center py-4 border-bottom">
        <h4 class="text-white">ADMIN</h4>
      </div>
      <ul class="nav flex-column mt-3">
        <li class="nav-item"><a class="nav-link text-white" href="index.php"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="home/manage_home.php"><i class="bi bi-house me-2"></i> Quản lý Trang Chủ</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="contact/manage_contact.php"><i class="bi bi-envelope me-2"></i> Quản lý Liên hệ</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="admin_qa_management.php"><i class="bi bi-question-circle me-2"></i> Quản lý Hỏi/Đáp</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="posts/index.php"><i class="bi bi-newspaper me-2"></i> Quản lý Bài viết</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="../auth/logout.php"><i class="bi bi-box-arrow-right me-2"></i> Đăng xuất</a></li>
      </ul>
    </nav>

    <!-- Page Content -->
    <div id="page-content-wrapper" class="flex-grow-1">
      <!-- Topbar -->
      <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom shadow-sm">
        <div class="container-fluid">
          <button class="btn btn-outline-primary me-2" id="menu-toggle"><i class="bi bi-list"></i></button>
          <span class="navbar-brand mb-0 h4">Quản lý Hỏi/Đáp</span>
        </div>
      </nav>

      <!-- Main Content -->
      <div class="container-fluid px-4 py-4">
        <h4 class="mb-3">Danh sách câu hỏi</h4>

        <?php if ($error): ?>
          <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php elseif (empty($questions)): ?>
          <div class="alert alert-info">Không có câu hỏi nào.</div>
        <?php else: ?>
          <div class="table-responsive">
            <table class="table table-bordered align-middle bg-white shadow-sm">
              <thead class="table-light">
                <tr>
                  <th>Người hỏi</th>
                  <th>Câu hỏi</th>
                  <th>Ngày</th>
                  <th>Hành động</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($questions as $q): ?>
                  <tr>
                    <td><?= htmlspecialchars($q['name']) ?></td>
                    <td><?= nl2br(htmlspecialchars($q['text'])) ?></td>
                    <td><?= htmlspecialchars($q['date']) ?></td>
                    <td>
                      <button class="btn btn-sm btn-danger mb-1" onclick="deleteQuestion(<?= $q['id'] ?>)">Xóa</button>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- Toggle Sidebar JS -->
  <script>
    document.getElementById("menu-toggle").addEventListener("click", function () {
      document.getElementById("sidebar").classList.toggle("collapsed");
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>