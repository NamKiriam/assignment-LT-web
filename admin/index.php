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
        <li class="nav-item"><a class="nav-link text-white" href="#"><i class="bi bi-person me-2"></i> Người dùng</a></li>
        <li><a class="nav-link text-white" href="admin_qa_management.php"><i class="bi bi-question-circle me-2"></i> Quản lý Hỏi/Đáp</a></li>

        <li class="nav-item"><a class="nav-link text-white" href="#"><i class="bi bi-info-circle me-2"></i> Giới thiệu</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="#"><i class="bi bi-box-arrow-right me-2"></i> Đăng xuất</a></li>
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
              <p class="fs-3 text-primary fw-bold">1024</p>
            </div>
          </div>
          <div class="col-sm-6 col-lg-4">
            <div class="card p-3">
              <h6>Tổng câu hỏi</h6>
              <p class="fs-3 text-success fw-bold">360</p>
            </div>
          </div>
          <div class="col-sm-6 col-lg-4">
            <div class="card p-3">
              <h6>Lượt truy cập</h6>
              <p class="fs-3 text-danger fw-bold">12,450</p>
            </div>
          </div>
        </div>

        <!-- Chart -->
        <div class="card mt-4 p-4">
          <h6>Thống kê truy cập</h6>
          <canvas id="myChart" height="100"></canvas>
        </div>
      </div>
    </div>
  </div>

  <!-- JS Scripts -->
  <!-- <script>
    // Toggle Sidebar
    document.getElementById("menu-toggle").addEventListener("click", function () {
      document.getElementById("sidebar").classList.toggle("collapsed");
    });

    // Chart.js
    const ctx = document.getElementById('myChart').getContext('2d');
    const myChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ['T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'CN'],
        datasets: [{
          label: 'Lượt truy cập',
          data: [1200, 1900, 3000, 5000, 2000, 3000, 7000],
          backgroundColor: 'rgba(54, 162, 235, 0.6)',
          borderRadius: 5
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false
      }
    });
  </script> -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
