<?php
session_start();
require_once '../../include/config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../auth/login.php");
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
</head>
<body>
    <!-- Header -->

    <!-- Main Content -->
    <main class="container mt-5">
        <!-- Box hiển thị nội dung -->
        <h1 id="title" class="main-title">Tiêu đề bài viết</h1>
        <div class="card">
            <div class="card-body">
                <p class="card-text" id="content">
                    Đây là phần nội dung bạn muốn hiển thị bên trong box. Bạn có thể đặt văn bản, hình ảnh hoặc bất kỳ thành phần HTML nào khác tại đây.
                </p>
            </div>
        </div>
        <div>
            <p id="like">Like:</p>
            <p id="dislike">Dislike:</p>
        </div>

        <script>
            // Lấy ID từ query string
            const params = new URLSearchParams(window.location.search);
            const id = params.get('id');

            if (id) {
                fetch(`api/index.php?path=articles/${id}`)
                    .then(response => response.json())
                    .then(article => {
                        document.getElementById('title').textContent = article.title;
                        document.getElementById('content').textContent = article.content;
                        document.getElementById('like').textContent = '👍: ' + article.like;
                        document.getElementById('dislike').textContent = '👎: ' + article.dislike;
                    })
                    .catch(error => {
                        document.getElementById('title').textContent = 'Error loading article';
                        console.error('Fetch error:', error);
                    });
            } else {
                document.getElementById('title').textContent = 'Invalid article ID';
            }
        </script>
        
        <!-- Nút "Quay về" bên dưới box -->
        <div class="mt-3">
            <a href="index.php" class="btn btn-secondary" style="margin-bottom:30px">Quay về</a>
        </div>
    </main>
    
    
</body>
</html>