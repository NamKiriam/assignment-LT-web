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
    <title>Xem bài viết</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- External CSS -->
    <link rel="stylesheet" href="css/article-style.css">
    <link rel="stylesheet" href="../include/header_footer.css">
</head>
<body>
    <!-- Header -->
    <?php include "../include/header_home.php"; ?>
    <!-- Main Content -->
    <main class="container mt-5">
        <!-- Box hiển thị nội dung -->

        <div class="container-fluid">
            <h1 class="main-title" id="title">The quick brown fox jumps over the lazy dog</h1>

            <!-- Nút "Quay về" bên dưới box -->
            <div class="mt-3">
                <a href="index.php" class="btn btn-secondary" style="margin-bottom:30px">Quay về</a>
            </div>

            <div style="display: flex; justify-content: center; align-items: center;">
                <img src="res/Good_Food_Display_-_NCI_Visuals_Online.jpg"
                     class="img-fluid"
                     alt="Responsive image"
                     style="height: 300px; width: 100%;">
            </div>     

            <div class="question-section">                                
                <p id="content" style="text-align:justify">
                    The quick brown fox jumps over the lazy dog. The quick brown fox jumps over the lazy dog.
                    The quick brown fox jumps over the lazy dog. The quick brown fox jumps over the lazy dog.
                    The quick brown fox jumps over the lazy dog. The quick brown fox jumps over the lazy dog.
                    The quick brown fox jumps over the lazy dog. The quick brown fox jumps over the lazy dog.
                    The quick brown fox jumps over the lazy dog. The quick brown fox jumps over the lazy dog.
                    The quick brown fox jumps over the lazy dog. The quick brown fox jumps over the lazy dog.
                    The quick brown fox jumps over the lazy dog. The quick brown fox jumps over the lazy dog.
                </p>
                <div class="sub-title">
                    <p id="author" class="author">Author:</p>
                    <p id="update_date" class="date">Update date:</p>
                    <button id="likeBtn" class="bi bi-emoji-heart-eyes" style="font-size: 2rem;"></button>
                    <button id="dislikeBtn" class="bi bi-emoji-angry" style="font-size: 2rem;"></button>
                </div>
            </div>
        </div>

        <script>
        const params = new URLSearchParams(window.location.search);
        const id = params.get('id');

        if (id) {
            fetch(`api/index.php?path=articles/${id}`)
                .then(response => response.json())
                .then(article => {
                    if (article.error) {
                        document.getElementById('title').textContent = 'Article not found';
                        return;
                    }

                    document.getElementById('title').textContent = article.title;
                    document.getElementById('content').textContent = article.content;
                    document.getElementById('author').textContent = 'Author: ' + article.author;
                    document.getElementById('update_date').textContent = 'Update date: ' + formatDate(article.update_date);
                })
                .catch(error => {
                    document.getElementById('title').textContent = 'Error loading article';
                    console.error('Fetch error:', error);
                });

            
            // Thêm sự kiện Like
            document.getElementById('likeBtn').addEventListener('click', () => {
                fetch(`api/articles.php?path=articles/${id}/like`, {
                    method: 'POST'
                })
                .then(res => res.json())
                .then(data => alert(data.message))
                .catch(err => alert("Lỗi khi gửi like"));
            });

            // Thêm sự kiện Dislike
            document.getElementById('dislikeBtn').addEventListener('click', () => {
                fetch(`api/articles.php?path=articles/${id}/dislike`, {
                    method: 'POST'
                })
                .then(res => res.json())
                .then(data => alert(data.message))
                .catch(err => alert("Lỗi khi gửi dislike"));
            });

        } else {
            document.getElementById('title').textContent = 'Invalid article ID';
        }

        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('vi-VN'); // Định dạng dd/mm/yyyy theo kiểu Việt Nam
        }
    </script>


        

    </main>
    
    <!-- Footer -->
    <?php include "../include/footer_home.php"; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
