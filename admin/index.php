<?php
session_start();
require_once '../include/config.php';

// Kiểm tra quyền admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

// Lấy dữ liệu thống kê từ database
$userCount = $connection->query("SELECT COUNT(*) AS total FROM user")->fetch_assoc()['total'];
$questionCount = $connection->query("SELECT COUNT(*) AS total FROM question")->fetch_assoc()['total'];
$contactCount = $connection->query("SELECT COUNT(*) AS total FROM contacts")->fetch_assoc()['total'];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Dashboard</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <!-- Custom CSS -->
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <!-- Wrapper -->
  <div class="d-flex" id="wrapper">
    <!-- Sidebar -->
    <nav id="sidebar" class="sidebar bg-dark text-white position-fixed">
      <div class="sidebar-header text-center py-4 border-bottom">
        <h4 class="text-white">ADMIN</h4>
      </div>
      <ul class="nav flex-column mt-3">
        <li class="nav-item"><a class="nav-link text-white" href="#"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="home/manage_home.php"><i class="bi bi-house me-2"></i> Quản lý Trang Chủ</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="contact/manage_contact.php"><i class="bi bi-envelope me-2"></i> Quản lý Liên hệ</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="admin_qa_management.php"><i class="bi bi-question-circle me-2"></i> Quản lý Hỏi/Đáp</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="#"><i class="bi bi-info-circle me-2"></i> Giới thiệu</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="../auth/logout.php"><i class="bi bi-box-arrow-right me-2"></i> Đăng xuất</a></li>
      </ul>
    </nav>

    <!-- Page Content -->
    <div id="page-content-wrapper" class="flex-grow-1">
      <!-- Topbar -->
      <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom shadow-sm">
        <div class="container-fluid">
          <button class="btn btn-outline-primary me-2" id="menu-toggle"><i class="bi bi-list"></i></button>
          <span class="navbar-brand mb-0 h4">Trang quản trị</span>
        </div>
      </nav>

      <!-- Main Content -->
      <div class="container-fluid px-4 py-4">
        <div class="row g-3">
          <div class="col-sm-6 col-lg-4">
            <div class="card p-3">
              <h6>Tổng người dùng</h6>
              <p class="fs-3 text-primary fw-bold"><?= $userCount ?></p>
            </div>
          </div>
          <div class="col-sm-6 col-lg-4">
            <div class="card p-3">
              <h6>Tổng câu hỏi</h6>
              <p class="fs-3 text-success fw-bold"><?= $questionCount ?></p>
            </div>
          </div>
          <div class="col-sm-6 col-lg-4">
            <div class="card p-3">
              <h6>Tổng liên hệ</h6>
              <p class="fs-3 text-danger fw-bold"><?= $contactCount ?></p>
            </div>
          </div>
        </div>

        <!-- Chart -->
        <div class="card mt-4 p-4">
          <h6>Thống kê truy cập</h6>
          <div style="height: 400px;">
            <canvas id="myChart"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>

<!-- Chart.js -->
<script>
  const ctx = document.getElementById('myChart').getContext('2d');
  const myChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: ['Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7', 'CN'],
      datasets: [{
        label: 'Lượt truy cập',
        data: [1200, 1600, 2200, 2800, 2400, 3000, 3600], // Mô phỏng
        borderColor: 'rgba(54, 162, 235, 1)',
        backgroundColor: 'rgba(54, 162, 235, 0.2)',
        borderWidth: 2,
        fill: true,
        tension: 0.4, // Cong đường
        pointRadius: 4,
        pointHoverRadius: 6
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { position: 'top' },
        tooltip: { mode: 'index', intersect: false }
      },
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            stepSize: 1000
          }
        }
      }
    }
  });
</script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
