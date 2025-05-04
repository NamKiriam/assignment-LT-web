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
    <header class="header">
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <span class="navbar-brand logo"><img src="../res/logo.png" alt="Logo" class="img-fluid"></span>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse header-tab-item fw-bold" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="#">Trang chủ</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Hỏi đáp</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Thực đơn</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Bài viết</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Giới thiệu</a></li>
                        <li class="nav-item"><a class="nav-link" href="#"><i class="bi bi-person-circle"></i></a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main>
        <div class="container-fluid">
            <h1 class="main-title">Quản lý các bài viết</h1>

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
