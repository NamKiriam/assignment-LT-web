<?php
session_start();
require_once '../../include/config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../../../auth/login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý các bài viết</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- External CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Header -->
    

    <!-- Main Content -->
    <main>
        <div class="container-fluid">
            <h1 class="main-title">Quản lý các bài viết</h1>

            <div class="mt-3">
                <a href="index.php" class="btn btn-secondary" style="margin-bottom:30px">Quay về</a>
            </div>
            
            <div id="message"></div>

            <form id="articleForm">
                <div class="mb-3">
                    <label for="title" class="form-label" style="font-weight: bold">Tiêu đề</label>
                    <input type="text" class="form-control" id="title" required>
                </div>
                <div class="mb-3">
                    <label for="author" class="form-label" style="font-weight: bold">Tác giả</label>
                    <input type="text" class="form-control" id="author" required>
                </div>
                <div class="mb-3">
                    <label for="content" class="form-label" style="font-weight: bold">Nội dung</label>
                    <textarea class="form-control" id="content" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary" style="margin-bottom: 3%">Tạo bài viết</button>
            </form>
            
        </div>

        <script>
        document.getElementById('articleForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const data = {
                title: document.getElementById('title').value.trim(),
                author: document.getElementById('author').value.trim(),
                content: document.getElementById('content').value.trim()
            };

            fetch('api/index.php?path=articles', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(result => {
                const msgDiv = document.getElementById('message');
                if (result.message) {
                    msgDiv.innerHTML = `<div class="alert alert-success">${result.message}. Đang chuyển hướng...</div>`;
                    setTimeout(() => {
                        window.location.href = "index.php";
                    }, 2000); // Chuyển trang sau 2 giây
                } else if (result.errors) {
                    msgDiv.innerHTML = `<div class="alert alert-danger">${result.errors.join('<br>')}</div>`;
                } else if (result.error) {
                    msgDiv.innerHTML = `<div class="alert alert-danger">${result.error}</div>`;
                }
            })
            .catch(error => {
                document.getElementById('message').innerHTML = `<div class="alert alert-danger">Lỗi: ${error}</div>`;
            });
        });
        </script>
    </main>

   

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>