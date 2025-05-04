<?php
session_start(); // Đảm bảo session được khởi động

// Debug: Kiểm tra session
if (!isset($_SESSION['user_name'])) {
    // Lưu URL hiện tại để quay lại sau khi đăng nhập
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
    header("Location: ../auth/login.php");
    exit();
}

include "../include/header_home.php";
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hỏi Đáp</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- External CSS -->
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="../include/header_footer.css">
</head>
<body>
    <!-- Main Content -->
    <main>
        <div class="container-fluid px-3 px-md-5">
            <h1 class="main-title text-center text-center">Hãy đặt câu hỏi cho chúng tôi</h1>
            <p class="sub-title text-center text-center">Chúng tôi sẽ trả lời sớm nhất có thể</p>

            <div class="question-section">
                <div class="question-box">
                    <form id="question-form">
                        <div class="mb-3">
                            <label for="current-user" class="form-label">Tên người dùng</label>
                            <input type="text" class="form-control" id="current-user" value="<?php echo htmlspecialchars($_SESSION['user_name']); ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <textarea class="form-control" id="question-text" rows="5" placeholder="Câu hỏi của tôi..." required></textarea>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary m-3">Gửi câu hỏi</button>
                        </div>
                    </form>
                </div>
                <div id="question-list" class="question-list">
                    <!-- Danh sách câu hỏi sẽ được tạo động bởi JavaScript -->
                </div>
                <div id="pagination" class="pagination d-flex justify-content-center gap-2 mt-3">
                    <!-- Nút phân trang sẽ được tạo động bởi JavaScript -->
                </div>
            </div>
        </div>
    </main>

    <!-- Desktop Footer -->
    <div class="d-none d-md-block">
        <?php include("../include/footer_home.php"); ?>
    </div>

    <!-- Mobile Footer -->
    <footer class="mobile-footer d-block d-md-none">
        <div class="container d-flex justify-content-around align-items-center">
            <a href="../Trang_chu/home.php" class="nav-item text-center">
                <i class="bi bi-house-door" style="font-size: 1.5rem;"></i>
                <span class="d-block">Trang chủ</span>
            </a>
            <a href="../Trang_thuc_don/index.php" class="nav-item text-center">
                <i class="bi bi-list"></i>
                <span class="d-block">Thực đơn</span>
            </a>
            <a href="../Trang_hoi_dap/index.php" class="nav-item text-center">
                <i class="bi bi-question-circle"></i>
                <span class="d-block">Hỏi đáp</span>
            </a>
            <a href="#" class="nav-item text-center">
                <i class="bi bi-person"></i>
                <span class="d-block">Tài khoản</span>
            </a>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="addQuestion.js"></script>
</body>
</html>