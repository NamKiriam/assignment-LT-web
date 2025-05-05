<?php
require_once '../include/config.php'; // Include your database connection file

$error = '';
$success = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dishName = trim($_POST['dish_name']);
    $dishType = $_POST['dish_type'];
    $dishDescription = trim($_POST['dish_description']);
    $dishPrice = floatval($_POST['dish_price']);

    if (empty($dishName) || empty($dishType) || empty($dishPrice)) {
        $error = 'Vui lòng điền đầy đủ thông tin.';
    } else {
        try {
            $tableName = '';
            switch ($dishType) {
                case 'main_dish':
                    $tableName = 'main_dish';
                    break;
                case 'dessert':
                    $tableName = 'dessert';
                    break;
                case 'meal':
                    $tableName = 'meal';
                    break;
                default:
                    $tableName = 'dish';
            }

            $stmt = $pdo->prepare("INSERT INTO $tableName (name, description, price) VALUES (:name, :description, :price)");
            $stmt->execute([
                ':name' => $dishName,
                ':description' => $dishDescription,
                ':price' => $dishPrice,
            ]);

            $success = 'Món ăn đã được thêm thành công.';
        } catch (Exception $e) {
            $error = 'Lỗi: ' . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Món ăn</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Thêm/Chỉnh sửa Món ăn</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php elseif ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label for="dish_name" class="form-label">Tên món ăn</label>
            <input type="text" class="form-control" id="dish_name" name="dish_name" required>
        </div>
        <div class="mb-3">
            <label for="dish_type" class="form-label">Loại món ăn</label>
            <select class="form-select" id="dish_type" name="dish_type" required>
                <option value="dish">Món ăn</option>
                <option value="main_dish">Món chính</option>
                <option value="dessert">Tráng miệng</option>
                <option value="meal">Bữa ăn</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="dish_description" class="form-label">Mô tả</label>
            <textarea class="form-control" id="dish_description" name="dish_description" rows="3"></textarea>
        </div>
        <div class="mb-3">
            <label for="dish_price" class="form-label">Giá</label>
            <input type="number" class="form-control" id="dish_price" name="dish_price" step="0.01" required>
        </div>
        <button type="submit" class="btn btn-primary">Thêm món ăn</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>