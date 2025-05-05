<?php
session_start();
require_once '../../include/config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../auth/login.php");
    exit();
}

?>

<?php
// Lấy ID từ URL
$id = $_GET['id'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Article</title>
    <meta charset="UTF-8">
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

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const id = "<?php echo $id; ?>";

            // Lấy dữ liệu bài viết
            fetch(`api/index.php?path=articles/${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert(data.error);
                        return;
                    }
                    document.getElementById('articleId').textContent = data.id;
                    document.getElementById('title').value = data.title;
                    document.getElementById('author').value = data.author;
                })
                .catch(err => console.error('Error:', err));

            // Gửi PUT request khi nhấn nút
            document.getElementById('saveBtn').addEventListener('click', () => {
                const title = document.getElementById('title').value;
                const author = document.getElementById('author').value;

                if (!title || !author) {
                    alert('Title and Author are required!');
                    return;
                }

                fetch(`api/index.php?path=articles/${id}`, {
                    method: 'PUT',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ title, author })
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message || data.error || 'Update completed');
                    window.location.href = 'index.php'; // Quay lại danh sách
                })
                .catch(err => console.error('Error:', err));
            });
        });
    </script>
</head>
<body>

    <!-- Main Content -->
    <main class="container mt-5">
        
        <!-- Box hiển thị nội dung -->
        <h1 id="title" class="main-title">Sửa thông tin bài viết</h1>

        <!-- Nút "Quay về" bên dưới box -->
        <div class="mt-3">
            <a href="index.php" class="btn btn-secondary" style="margin-bottom:30px">Quay về</a>
        </div>

        <p><strong>ID:</strong> <span id="articleId"></span></p>
        <label>Title: <input type="text" id="title" /></label><br><br>
        <label>Author: <input type="text" id="author" /></label><br><br>
        <button id="saveBtn" class="btn btn-primary">Save Changes</button><br><br>

    </main>

   

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>
