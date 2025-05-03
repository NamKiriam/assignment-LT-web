<?php
require_once '../config.php';

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $gender = $_POST['gender'];
    $birthday = $_POST['birthday'];

    // Kiểm tra dữ liệu
    if (empty($fullname) || empty($email) || empty($password)) {
        $errors[] = "Vui lòng điền đầy đủ thông tin bắt buộc.";
    } else {
        // Kiểm tra email đã tồn tại
        $stmt = $connection->prepare("SELECT ID_user FROM user WHERE Email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $errors[] = "Email đã được sử dụng.";
        } else {
            // Mã hóa mật khẩu và chèn dữ liệu
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $connection->prepare("INSERT INTO user (Username, Email, Password, Gender, Birthday) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $fullname, $email, $hashed, $gender, $birthday);

            if ($stmt->execute()) {
                $success = "Đăng ký thành công! Bạn có thể đăng nhập.";
            } else {
                $errors[] = "Đăng ký thất bại. Vui lòng thử lại.";
            }
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Đăng ký tài khoản</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <style>
    body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    margin: 0;
    padding: 0;
    color: #333;
  }
  
  /* Navbar */
  .navbar {
    background-color: #00c29f !important;
  }
  
  .navbar-brand img {
    height: 50px;
    width: auto;
    display: block;
  }

  .user-icon {
    height: 50px;
    width: auto;
    border-radius: 50%;
    object-fit: cover;
  }
  
  .navbar-nav .nav-link {
    font-weight: 500;
  }

    /* === Footer === */
    .bg-footer {
    background-color: #14d3a2;
  }
  
  .social-icon {
    padding: 10px;
    border-radius: 50%;
    background-color: white;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    transition: 0.3s;
    color: black;
  }
  
  .social-icon:hover {
    transform: scale(1.1);
  }
  
  /* Icon brand màu chuẩn */
  .facebook {
    color: #1877f2;
  }
  .tiktok {
    color: black;
  }
  .x {
    color: black;
  }
  .instagram {
    color: #e1306c;
  }
  
  
  /* Responsive */
  @media (max-width: 576px) {
    footer .col-12.d-flex {
      flex-direction: column;
      align-items: flex-start;
    }
    footer .col-12.d-flex nav {
      margin-top: 0.5rem;
    }
    footer .col-md-6 {
      margin-top: 1.5rem;
    }
  }
  </style>

</head>
<body class="bg-light">

<!-- Navbar -->
<section class="navbar navbar-expand-lg navbar-dark bg-success px-3">
  <a class="navbar-brand" href="#">
    <img src="../Trang_chu/assets/picture/foodiness.png" alt="Logo">
  </a>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ms-auto">
      <li class="nav-item"><a class="nav-link text-white" href="../Trang_chu/home.html">Trang chủ</a></li>
      <li class="nav-item"><a class="nav-link text-white" href="../Trang_gioi_thieu/index.html">Giới thiệu</a></li>
      <li class="nav-item"><a class="nav-link text-white" href="../Trang_hoi_dap/index.html">Hỏi đáp</a></li>
      <li class="nav-item"><a class="nav-link text-white" href="../Trang_thuc_don/index.html">Thực đơn</a></li>
      <li class="nav-item"><a class="nav-link text-white" href="#">Bài viết</a></li>
      <li class="nav-item"><a class="nav-link text-white" href="../Trang_lien_he/contact.html">Liên hệ</a></li>
    </ul>
    <img src="../Trang_chu/assets/picture/user_icon.png" alt="User" class="ms-3 user-icon">
  </div>
</section>

<div class="container mt-5">
  <div class="card mx-auto" style="max-width: 600px;">
    <div class="card-body">
      <h3 class="card-title text-center mb-4">Đăng ký tài khoản</h3>

      <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
      <?php elseif ($errors): ?>
        <div class="alert alert-danger">
          <?php foreach ($errors as $e) echo "<p>$e</p>"; ?>
        </div>
      <?php endif; ?>

      <form method="POST">
        <div class="mb-3">
          <label class="form-label">Họ tên</label>
          <input type="text" name="fullname" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Mật khẩu</label>
          <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Giới tính</label>
          <select name="gender" class="form-select">
            <option value="Nam">Nam</option>
            <option value="Nữ">Nữ</option>
            <option value="Không tiết lộ">Không tiết lộ</option>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label">Ngày sinh</label>
          <input type="date" name="birthday" class="form-control">
        </div>

        <button type="submit" class="btn btn-success w-100 fw-bold">Đăng ký</button>
      </form>
    </div>
  </div>
</div>

<!-- Footer -->
<footer class="bg-footer text-dark py-4">
<div class="container">
    <div class="row justify-content-between">
    <!-- Cột trái: logo + liên hệ -->
    <div class="col-md-6 mb-4">
        <a href="#" class="navbar-brand d-block mb-3">
        <img src="../Trang_chu/assets/picture/foodiness.png" alt="Foodiness Logo" height="50">
        </a>
        <h5 class="fw-bold mb-3">Liên hệ</h5>
        <p><i class="bi bi-envelope me-2"></i>Email: info@foodiness.vn</p>
        <p><i class="bi bi-telephone me-2"></i>Hotline: 0123 456 789</p>
        <p><i class="bi bi-geo-alt me-2"></i>CS sản xuất: KCN Tân Bình, TP.HCM</p>
        <p><i class="bi bi-building me-2"></i>Văn phòng: Quận 1, TP.HCM</p>
    </div>

    <!-- Cột phải: nav + mạng xã hội -->
    <div class="col-md-5 text-md-end text-start">
        <nav class="mb-33">
        <a href="#" class="fw-bold text-dark me-3">Trang chủ</a>
        <a href="../Trang_gioi_thieu/index.html" class="fw-bold text-dark me-3">Giới thiệu</a>
        <a href="../Trang_hoi_dap/index.html" class="fw-bold text-dark me-3">Hỏi đáp</a>
        <a href="../Trang_thuc_don/index.html" class="fw-bold text-dark me-3">Thực đơn</a>
        <a href="#" class="fw-bold text-dark me-3">Bài viết</a>
        <a href="../Trang_lien_he/contact.html" class="fw-bold text-dark">Liên hệ</a>
        </nav>

        <h6 class="fw-bold mb-3">Mạng xã hội</h6>
        <div class="d-flex gap-3 justify-content-md-end justify-content-start">
        <a href="#"><i class="fab fa-facebook fa-2x social-icon facebook"></i></a>
        <a href="#"><i class="fab fa-tiktok fa-2x social-icon tiktok"></i></a>
        <a href="#"><i class="fab fa-x-twitter fa-2x social-icon x"></i></a>
        <a href="#"><i class="fab fa-instagram fa-2x social-icon instagram"></i></a>
        </div>
    </div>
    </div>
</div>
</footer>

</body>
</html>
