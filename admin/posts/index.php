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
    
    <!-- Main Content -->
    <main>

        <div class="container-fluid">
            <h1 class="main-title">Quản lý các bài viết</h1>

            <div class="mt-3">
                <a href="../../admin" class="btn btn-primary btn-sm" style="margin-bottom:30px">Quay về trang chủ admin</a>
            </div>
            <div class="mt-3">
                <a href="new-article.php" class="btn btn-secondary" style="margin-bottom:30px">Tạo mới</a>
            </div>

            <table class="table table-bordered" style="border: 2px solid black">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Upload date</th>
                        <th>Content</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="articleTable"></tbody>
            </table>

            <script>
                function loadArticles() {
                    fetch(`api/index.php?path=articles`)
                        .then(response => response.json())
                        .then(data => {
                            const tbody = document.getElementById('articleTable');
                            tbody.innerHTML = '';
                            data.forEach(article => {
                                tbody.innerHTML += `
                                    <tr>
                                        <td>${article.id}</td>
                                        <td>${article.title}</td>
                                        <td>${article.author}</td>
                                        <td>${article.update_date}</td>
                                        <td>
                                            <button class="btn btn-primary btn-sm" onclick="seeContent('${article.id}')">See content</button>
                                        </td>
                                        <td>
                                            <button class="btn btn-success btn-sm" onclick="editArticle('${article.id}')">Edit</button>
                                            <button class="btn btn-danger btn-sm" onclick="deleteArticle('${article.id}')">Delete</button>
                                        </td>
                                    </tr>
                                `;
                            });
                        })
                        .catch(error => console.error('Error loading articles:', error));
                }

                function seeContent(id) {
                    window.location.href = `view_article.php?id=${id}`;
                }

                function editArticle(id) {
                    window.location.href = `edit_article.php?id=${id}`;
                }

                function deleteArticle(id) {
                    if (confirm('Are you sure you want to delete this article?')) {
                        fetch(`api/index.php?path=articles/${id}`, {
                            method: 'DELETE'
                        })
                        .then(response => response.json())
                        .then(data => {
                            alert(data.message || 'Article deleted');
                            loadArticles();
                        })
                        .catch(error => console.error('Error deleting article:', error));
                    }
                }

                // Load articles on page load
                document.addEventListener('DOMContentLoaded', loadArticles);
            </script>
        </div>        
    </main>

   

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>