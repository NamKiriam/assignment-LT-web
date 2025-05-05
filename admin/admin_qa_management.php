<?php
require_once '../include/config.php'; // Đảm bảo kết nối database

// Khởi tạo mảng câu hỏi
$questions = [];
$error = '';

try {
    // Truy vấn trực tiếp từ database
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
    .edit-mode { display: none; }
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

    function submitAnswer(id) {
      const input = document.getElementById('answer-' + id);
      const answer = input.value.trim();
      if (!answer) return alert("Vui lòng nhập câu trả lời.");

      const formData = new FormData();
      formData.append('question_id', id);
      formData.append('question_text', answer);
      formData.append('action', 'update_answer'); // Thêm action để gọi đúng updateQuestion.php

      fetch('../Trang_hoi_dap/updateQuestion.php', {
        method: 'POST',
        body: formData
      })
      .then(res => res.json())
      .then(data => {
        alert(data.message);
        if (data.success) location.reload();
      });
    }

    function editAnswer(id) {
      const input = document.getElementById('answer-' + id);
      const editBtn = document.getElementById('edit-btn-' + id);
      const submitBtn = document.getElementById('submit-btn-' + id);

      // Hiển thị input và nút gửi, ẩn nút chỉnh sửa
      input.classList.remove('edit-mode');
      editBtn.classList.add('edit-mode');
      submitBtn.classList.remove('edit-mode');

      // Điền giá trị hiện tại vào input
      fetch('../Trang_hoi_dap/getQuestion.php?id=' + id)
        .then(res => res.json())
        .then(data => {
          if (data.success && data.answer) {
            input.value = data.answer;
          }
        });
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
                  <th>Trạng thái</th>
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
                      <?= $q['answered'] ? '✅ Đã trả lời' : '❌ Chưa trả lời' ?>
                      <?php if ($q['answered'] && $q['answer']): ?>
                        <br><small>💬 <?= htmlspecialchars($q['answer']) ?></small>
                      <?php endif; ?>
                    </td>
                    <td>
                      <button class="btn btn-sm btn-danger mb-1" onclick="deleteQuestion(<?= $q['id'] ?>)">Xóa</button>
                      <?php if (!$q['answered']): ?>
                        <div class="input-group input-group-sm mt-2">
                          <input type="text" class="form-control" id="answer-<?= $q['id'] ?>" placeholder="Trả lời...">
                          <button class="btn btn-success" id="submit-btn-<?= $q['id'] ?>" onclick="submitAnswer(<?= $q['id'] ?>)">Gửi</button>
                        </div>
                      <?php else: ?>
                        <div class="input-group input-group-sm mt-2">
                          <input type="text" class="form-control edit-mode" id="answer-<?= $q['id'] ?>" placeholder="Chỉnh sửa...">
                          <button class="btn btn-warning edit-mode" id="submit-btn-<?= $q['id'] ?>" onclick="submitAnswer(<?= $q['id'] ?>)">Lưu</button>
                          <button class="btn btn-info" id="edit-btn-<?= $q['id'] ?>" onclick="editAnswer(<?= $q['id'] ?>)">Chỉnh sửa</button>
                        </div>
                      <?php endif; ?>
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