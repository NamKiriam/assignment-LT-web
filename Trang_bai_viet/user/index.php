<?php
session_start(); // Đảm bảo session được khởi động

// Debug: Kiểm tra session
if (!isset($_SESSION['user_name'])) {
    // Lưu URL hiện tại để quay lại sau khi đăng nhập
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
    header("Location: ../../auth/login.php");
    exit();
}

include "../../include/header_home.php";
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách bài viết</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- External CSS -->
    <link rel="stylesheet" href="css/style.css">

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            fetch('api/index.php?path=articles')
                .then(response => response.json())
                .then(data => {
                    const container = document.getElementById('article_thumbnail');
                    container.innerHTML = '';

                    data.forEach(article => {
                        const card = document.createElement('div');
                        card.className = 'article-card';

                        card.innerHTML = `
                            <img src="../res/images.png" alt="post" class="img-fluid">
                            <div class="article">
                                <p class="title">${article.title}</p>
                                <p class="author">Author: ${article.author}</p>
                                <p class="date">Update date: ${formatDate(article.update_date)}</p>
                            </div>
                        `;

                        // Thêm sự kiện click vào từng article
                        card.addEventListener('click', () => {
                            window.location.href = `view_article.php?id=${article.id}`;
                        });

                        container.appendChild(card);
                    });
                })
                .catch(error => console.error('Error loading articles:', error));
        });

        function formatDate(mysqlDate) {
            const [datePart] = mysqlDate.split(' ');
            const [year, month, day] = datePart.split('-');
            return `${day}/${month}/${year}`;
        }
            
    </script>

</head>
<body>
    <!-- Header -->

    <!-- Main Content -->
    <main>
        <div class="container-fluid">
            <h1 class="main-title">Chuyên mục bài viết</h1>
            <p class="sub-title">Luôn cập nhật mới mỗi ngày</p>

            <div class="question-section">                                
                <div id="article_thumbnail"></div>
            </div>
        </div>
    </main>

    <!-- Desktop Footer (Visible on larger screens) -->
    <footer class="footer desktop-footer d-flex flex-column justify-content-between">
        <div class="footer-tab d-flex flex-column flex-md-row justify-content-between align-items-center">
            <span class="logo"><img src="../res/logo.png" alt="Logo" class="img-fluid"></span>
            <div class="footer-tab-item fw-bold d-flex flex-wrap gap-2">
                <a href="#">Trang chủ</a>
                <a href="#">Hỏi đáp</a>
                <a href="#">Bài viết</a>
            </div>
        </div>
        <div class="contact-info d-flex flex-column flex-md-row justify-content-between align-items-center align-items-md-start gap-4">
            <div class="contact-info d-flex flex-column gap-3 align-items-center align-items-md-start">
                <p><strong>Liên hệ</strong></p>
                <a href="#" class="d-block mb-2"><i class="bi bi-envelope-fill me-2"></i>Email: <span class="__cf_email__" data-cfemail="402538212d302c2500272d21292c6e232f2d">[email protected]</span></a>
                <a href="#" class="d-block mb-2"><i class="bi bi-telephone-fill me-2"></i>Hotline: 0123 456 789</a>
                <a href="#" class="d-block mb-2"><i class="bi bi-geo-alt-fill me-2"></i>CS sản xuất: KCN Tân Bình, TP.HCM</a>
                <a href="#" class="d-block"><i class="bi bi-geo-fill me-2"></i>Văn phòng: Quận 1, TP.HCM</a>
            </div>
            <div class="social d-flex flex-column align-items-center gap-3">
                <p><strong>Mạng xã hội</strong></p>
                <div class="social-icon d-flex flex-wrap gap-3 justify-content-center">
                    <a href="#"><img src="../res/facebook.png" alt="Facebook"></a>
                    <a href="#"><img src="../res/tiktok.png" alt="TikTok"></a>
                    <a href="#"><img src="../res/twitter.png" alt="Twitter"></a>
                    <a href="#"><img src="../res/instargram.png" alt="Instagram"></a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Mobile Footer (Visible on mobile and tablet) -->
    <footer class="mobile-footer d-none">
        <div class="container d-flex justify-content-around align-items-center">
            <a href="#" class="nav-item text-center">
                <i class="bi bi-house-door"></였다: 1.5rem;"></i>
                <span class="d-block">Trang chủ</span>
            </a>
            <a href="#" class="nav-item text-center">
                <i class="bi bi-list"></i>
                <span class="d-block">Thực đơn</span>
            </a>
            <a href="#" class="nav-item text-center">
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
</body>
</html>
