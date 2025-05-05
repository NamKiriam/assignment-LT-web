<?php
session_start(); // Đảm bảo session được khởi động

// Debug: Kiểm tra session
if (!isset($_SESSION['user_name'])) {
    // Lưu URL hiện tại để quay lại sau khi đăng nhập
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
    header("Location: ../auth/login.php");
    exit();
}

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
    <link rel="stylesheet" href="../include/header_footer.css">

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
                            <img src="res/images.png" alt="post" class="img-fluid">
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
    <?php 
    include "../include/header_home.php";
    ?>
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
<!-- Footer -->
    <?php 
    include "../include/footer_home.php";
    ?>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
